<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Jobs\EmailVerification;

use App\User;

class RegisterController extends Controller
{
    /**
     * Register user - student or parent
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'type' => ["required", "in:Student,Professional"],
            'password' => ['required',
                'min:6',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'  // must contain a special character
            ],
            'email' => 'required|email|unique:users',
        ]);


        if ($validator->passes()) {
            $user = new User;
            $user->email = $request->input('email');
            $user->user_type = $request->input('type');
            $user->password = bcrypt($request->input('password'));

            if ($user->save()) {
                // Attach Student/Professional role to the user
                $user->assignRole($request->input('type'));
                Auth::login($user);

                // Queue an email to the user to verify their email
                EmailVerification::dispatch($user->email, $user->uuid);

                // Get redirect path
                $redirect = $this->getProfileRedirect($request->input('type'));

                return response()->json([
                    'success' => 1,
                    'redirect' => $redirect,
                    'message' => 'Account created successfully. Redirecting to complete your profile ...'
                ], 201);
            } else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Error creating account. Refresh browser and try again'
                ], 409);
            }
        }

        return response()->json(['error' => $validator->errors()->all()],409);
    }

    /**
     * Get where a user will be redirected to complete profile based on user type
     * @param string $userType
     * @return string $redirect
     */
    public function getProfileRedirect($userType)
    {
        $redirect = "/onboarding/student";

        if ($userType == "Professional") {
            $redirect = "/onboarding/professional";
        }

        return $redirect;
    }

//    Email Verification
    public function emailVerification($uuId)
    {
        $user = User::where('uuid',$uuId)->first();
        if($user->email_verified_at == null){
            $user->email_verified_at = Carbon::now();
            $user->save();
        }
        if(Auth::check()){
            return redirect(route('dashboard'));
        }
        else{
            return redirect('/login');
        }
    }
}
