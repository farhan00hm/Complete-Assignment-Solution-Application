<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use App\Jobs\ForgotPassword;

use App\User;

class LoginController extends Controller {
	/**
     * Login user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials, ($request->input('remember') == '1') ? true : false))
            return response()->json([
                'success' => 1,
                'error' => 'Invalid email and/or password'
            ], 401);

        $user = $request->user();
        $redirect = '/dashboard';
        if (Auth::user()->user_type == "Student" && Auth::user()->onboarded == 0) {
          $redirect = '/onboarding/student';
        }

        if (Auth::user()->user_type == "Professional" && Auth::user()->onboarded == 0) {
          $redirect = '/onboarding/professional';
        }

        $message = 'Login success. Redirecting to dashboard';

        return response()->json([
            'success' => 1,
            'redirect' => $redirect,
            'message' => $message
        ], 200);
    }

    /**
     * Change user password
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function changePassword(Request $request){
    	$user = $request->user();

    	if ($user->update([
        	'password' => bcrypt($request->input('password')),
      	])) {
          	Auth::logout();

          	$request->session()->invalidate();
          	return response()->json([
              	'success' => 1,
              	'redirect' => '/',
              	'message' => 'Your password has been reset. You will redirected to login again'
          	], 200);
      	} else {
          	return response()->json([
              	'success' => 0,
              	'error' => 'Error resetting password. Refresh browser and try again'
          	], 409);
      	}
    }

     /**
     * Reset user password
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function reset(Request $request){
        $email = Auth::user()->email;
        $password = $request->input('old');

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'success' => 0,
                'error' => 'Invalid old password'
            ], 200);
        }

        $user = $request->user();

        if ($user->update([
            'password' => bcrypt($request->input('newPass')),
        ])) {
            Auth::logout();
            $request->session()->invalidate();

            return response()->json([
                'success' => 1,
                'redirect' => '/login',
                'message' => 'Your password has been reset. You will redirected to login again'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error resetting password. Refresh browser and try again'
            ], 409);
        }

    }

    /**
     * Recover password
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function recover(Request $request){
        $email = Auth::user()->email;

        $user = User::where('email', $email)->first();

        if (! $user) {
            return response()->json([
                'success' => 0,
                'error' => 'No account associated with the provided email address'
            ], 200);
        }

        $raw = (string) Str::uuid();

        if ($user->update([
            'password' => bcrypt($raw),
            'password_changed' => 0
        ])) {
            // Queue an email with new password
            $name = $user->first_name." ". $user->last_name;
            ForgotPassword::dispatch($name, $user->email, $raw);

            return response()->json([
                'success' => 1,
                'redirect' => '/login',
                'message' => 'Your account has been reset and new password send to email'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error resetting account. Refresh browser and try again'
            ], 409);
        }

    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}
