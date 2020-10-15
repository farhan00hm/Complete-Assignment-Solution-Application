<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\Expert;
use App\Models\Subject;
use App\Models\SubCategory;
use App\Models\ExpertFile;

class SocialiteController extends Controller {
    /**
     * Get complete socialite sign up page
     * @return \Illuminate\View\View
    */
    public function complete(){
    	if(Auth::check()){
    		$areas = SubCategory::all();

    		return view('auth/socialite/complete', [
	    		'title' => 'Complete Signup',
	    		'areas' => $areas
	    	]);
    	}

    	return redirect()->to('/login');
    }

    /**
     * Student complete profile
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function studentCompleteProfile(Request $request){
    	$validator = \Validator::make($request->all(), [
			'type' => ["required" , "in:Student"],
            'first' => 'required|max:250',
            'last' => 'required|max:250',
            'username' =>  'required|unique:users',
            'gender' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'school' => 'required|max:250',
        ]);


        if ($validator->passes()) {
        	$user = Auth::user();
			if ($user->update([
				'first_name' => ucwords($request->input('first')),
	        	'last_name' => ucwords($request->input('last')),
	            'username' => strtolower($request->input('username')),
	            'gender' => $request->input('gender'),
	            'dob' => $request->input('dob'),
	            'phone' => $request->input('phone'),
				'user_type' => $request->input('type'),
				'school' => ucwords($request->input('school')),
				'onboarded' => 1,
			])) {
				// Attach Student role to the user
				$user->assignRole($request->input('type'));
				Auth::logout();
				$request->session()->invalidate();
                Auth::login($user);

				return response()->json([
	                'success' => 1,
	                'redirect' => '/dashboard',
	                'message' => 'Profile completed successfully. Redirecting to complete your dashboard ...'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error completing profile. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Professional complete profile
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function parentCompleteProfile(Request $request){
    	$validator = \Validator::make($request->all(), [
			'type' => ["required" , "in:Professional"],
            'first' => 'required|max:250',
            'last' => 'required|max:250',
            'username' =>  'required|unique:users',
            'gender' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'school' => 'required|max:250',
        ]);


        if ($validator->passes()) {
        	$user = Auth::user();
			if ($user->update([
				'first_name' => ucwords($request->input('first')),
	        	'last_name' => ucwords($request->input('last')),
	            'username' => strtolower($request->input('username')),
	            'gender' => $request->input('gender'),
	            'dob' => $request->input('dob'),
	            'phone' => $request->input('phone'),
				'user_type' => $request->input('type'),
				'school' => ucwords($request->input('school')),
				'onboarded' => 1,
			])) {
				// Attach Professional role to the user
				$user->assignRole($request->input('type'));
				Auth::logout();
				$request->session()->invalidate();
                Auth::login($user);

				return response()->json([
	                'success' => 1,
	                'redirect' => '/dashboard',
	                'message' => 'Profile completed successfully. Redirecting to complete your dashboard ...'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error completing profile. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Solution expert - complete profile after socialite sign up
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function seCompleteProfile(Request $request){
    	$validator = \Validator::make($request->all(), [
			'fl-first' => 'required|max:250',
            'fl-last' => 'required|max:250',
            'fl-username' =>  'required|unique:users,username|max:50',
            'fl-gender' => 'required',
            'fl-dob' => 'required',
            'fl-qualification' => 'required|string',
            'other' => 'required_if:fl-qualification,Other',
            'areas' => 'required',
            'fl-description' => 'required|min:200',
           	'files.*' => 'required|max:2048'
        ]);


        if ($validator->passes()) {
			DB::beginTransaction();

            // Update user and assign FL role
	        try {
	        	$user = Auth::user();
	            $user->update([
	            	'first_name' => ucwords($request->input('fl-first')),
		            'last_name' => ucwords($request->input('fl-last')),
		           	'username' => strtolower($request->input('fl-username')),
		           	'gender' => $request->input('fl-gender'),
		           	'dob' => $request->input('fl-dob'),
		            'user_type' => "FL",
	            ]);

	            $user->assignRole("FL");
	            Auth::logout();
				$request->session()->invalidate();
	            Auth::login($user);

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return response()->json([
	                'success' => 0,
	                'error' => 'Error creating profile'
	            ], 500);
	        }

	        // Create a solution expert profile
	        try {
	        	$qualification = $request->input('fl-qualification');
	        	if ($qualification == "Other") {
	        		$qualification = $request->input('other');
	        	}

	        	$expert = new Expert;
	            $expert->user_id = $user->id;
	            $expert->qualification = $qualification;
	            $expert->description = $request->input('fl-description');
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

	        DB::commit();

	        // Everything was successful
	        return response()->json([
                'success' => 1,
                'redirect' => '/dashboard',
                'message' => 'Your profile has been completed and is being reviewed. You will get a an email with approval decision.'
            ], 201);

        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }
}
