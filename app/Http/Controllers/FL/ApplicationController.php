<?php

namespace App\Http\Controllers\FL;

use App\Http\Controllers\Controller;
use App\Jobs\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\User;
use App\Models\Expert;
use App\Models\Subject;
use App\Models\SubCategory;
use App\Models\ExpertFile;

class ApplicationController extends Controller {
    /**
     * Get solution expert application page
     * @return \Illuminate\View\View
    */
    public function index(){
    	$areas = SubCategory::all();


    	return view('auth/fl/apply', [
    		'title' => 'Become a Freelancer',
			'areas' => $areas
    	]);
    }

    /**
     * Solution expert submit an application
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function submit(Request $request){
    	$validator = \Validator::make($request->all(), [
			'first' => 'required|string',
            'last' => 'required|string',
            'email' =>  'required|unique:users',
            'username' =>  'required|unique:users|max:50',
      		'gender' => 'required',
            'password' => ['required',
                'min:6',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'  // must contain a special character
            ],
      		'dob' => 'required',
            'qualification' => 'required|string',
            'other' => 'required_if:qualification,Other',
            'areas' => 'required',
            'description' => 'required|min:200',
            'files' => 'required|max:2048'
        ]);


        if ($validator->passes()) {
        	DB::beginTransaction();

            // Create a user, assign FL role and login user
	        try {
	        	$user = new User;
	            $user->first_name = ucwords($request->input('first'));
	            $user->last_name = ucwords($request->input('last'));
	            $user->username = strtolower($request->input('username'));
	            $user->gender = $request->input('gender');
	            $user->dob = $request->input('dob');
	            $user->phone = $request->input('phone');
	            $user->email = strtolower($request->input('email'));
	            $user->password = bcrypt($request->input('password'));
	            $user->user_type = "FL";
	            $user->school = ucwords($request->input('school'));
	            $user->save();

	            $user->assignRole("FL");

	            Auth::login($user);

                // Queue an email to the user to verify their email
                EmailVerification::dispatch($user->email, $user->uuid);

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return response()->json([
	                'success' => 0,
	                'error' => 'Error creating user'
	            ], 500);
	        }

	        // Create a solution expert profile
	        try {
	        	$qualification = $request->input('qualification');
	        	if ($qualification == "Other") {
	        		$qualification = $request->input('other');
	        	}

	        	$expert = new Expert;
	            $expert->user_id = $user->id;
	            $expert->qualification = $qualification;
	            $expert->description = $request->input('description');
	            $expert->save();

	            $subjects = explode(",", $request->input('areas'));
		        for ($i=0; $i < sizeof($subjects); $i++) {
		        	$subject = new Subject;
		        	$subject->expert_id = $expert->id;
		        	$subject->sub_category_id = ucfirst(trim($subjects[$i]));
		        	$subject->name = SubCategory::where('id', trim($subjects[$i]))->first()->name;
		        	$subject->save();
		        }

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return response()->json([
	                'success' => 0,
	                'error' => 'Error creating solution expert profile'
	            ], 500);
	        }

            if($request->hasfile('files')) {
	            foreach($request->file('files') as $file) {
	            	try {
	            		$name = $file->getClientOriginalName();
			            $timedName = time().$file->getClientOriginalName();

			            $uploaded = Storage::disk('s3')->put($timedName, file_get_contents($file), 'public');
			        } catch (\Exception $e) {
			        	\Log::error($e);
			            return response()->json([
			                'success' => 0,
			                'error' => 'Error uploading file to server. '.$e->getMessage()
			            ], 409);
			        }

		            if ($uploaded == 1) {
		            	$upload_path = "https://skooli-uploads.s3.amazonaws.com/".str_replace(' ', '+', $timedName);

		            	try {
				        	$expf = new ExpertFile;
				            $expf->expert_id = $expert->id;
				            $expf->original_file_name = $name;
				            $expf->upload_path = $upload_path;
				            $expf->save();

				        } catch (\Exception $e) {
				        	\Log::error($e);
				            return response()->json([
				                'success' => 0,
				                'error' => 'Error creating expert files on database'
				            ], 409);
				        }
		            }
	            }
	        }
        
        // @dd($request->all());
	        DB::commit();

	        // Everything was successful
	        return response()->json([
                'success' => 1,
                'redirect' => '/dashboard',
                'message' => 'Your application has been received. You will get a an email with approval decision'
            ], 201);

        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }
}
