<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller {
    /**
     * Get parent onboarding page
     * @return \Illuminate\View\View
    */
    public function index(){
    	return view('member/onboarding/professional', [
    		'title' => 'Professional Onboarding',
    	]);
    }

    /**
     * Create a parent profile (onboard)
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function onboard(Request $request){
    	$validator = \Validator::make($request->all(), [
			'first' => 'required|string',
            'last' => 'required|string',
            'username' =>  'required|unique:users',
            'gender' => 'required',
            'dob' => 'required',
            'phone' => 'required',
        ]);


        if ($validator->passes()) {
        	$user = Auth::user();

			if ($user->update([
				'first_name' => $request->input('first'),
				'last_name' => $request->input('last'),
				'username' => strtolower($request->input('username')),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
                'phone' => $request->input('phone'),
				'school' => ucwords($request->input('school')),
				'onboarded' => 1
			])) {
				return response()->json([
	                'success' => 1,
	                'redirect' => '/dashboard',
	                'message' => 'Your profile has been created.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error creating profile. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }
}
