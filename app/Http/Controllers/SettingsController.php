<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Subject;

class SettingsController extends Controller {
    /**
     * Get settings page
     * @return \Illuminate\View\View
    */
    public function index(){
        $areas = SubCategory::all();
        $levels = Category::all();

    	return view('member/settings', [
    		'title' => 'Settings',
    		'link' => 'stngs',
            'areas' => $areas,
            'levels' => $levels,
    	]);
    }

    /**
     * Update profile
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function updateProfile(Request $request){
    	$user = Auth::user();

    	$validator = \Validator::make($request->all(), [
			'first' => 'required|string',
            'last' => 'required|string',
        ]);

        if ($user->user_type == "Student" || $user->user_type == "Professional") {
            $validator = \Validator::make($request->all(), [
                'first' => 'required|string',
                'last' => 'required|string',
                'gender' => 'required|string',
                'dob' => 'required|date',
                'phone' => 'required',
                'school' => 'required|string',
            ]);
        }


        if ($validator->passes()) {
			if ($user->update([
				'first_name' => $request->input('first'),
				'last_name' => $request->input('last'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'dob' => $request->input('dob'),
                'school' => $request->input('school'),
			])) {
				return response()->json([
	                'success' => 1,
	                'message' => 'Profile details updated successfully.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error updating profile details. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }


    /**
     * Update banking information for Solution expert
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function updateBank(Request $request){
        $user = Auth::user();

        $validator = \Validator::make($request->all(), [
            'bank' => 'required|string',
            'account_number' => 'required|unique:experts',
        ]);

        if ($validator->passes()) {
            if ($user->expert->update([
                'bank_name' => ucwords($request->input('bank')),
                'account_number' => $request->input('account_number'),
            ])) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Banking details updated successfully.'
                ], 201);
            } else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating banking details. Refresh browser and try again'
                ], 409);
            }
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Update academic qualification for Solution expert
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function updateSEAcademicQualification(Request $request){
        $user = Auth::user();

        $validator = \Validator::make($request->all(), [
            'qualification' => 'required|string',
            'description' => 'required|min:200',
        ]);

        if ($validator->passes()) {
            if ($user->expert->update([
                'qualification' => $request->input('qualification'),
                'description' => $request->input('description'),
            ])) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Academic qualification details updated successfully.'
                ], 201);
            } else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating academic qualification details. Refresh browser and try again'
                ], 409);
            }
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Update areas of expertise for Solution expert
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function updateSEAreasOfExpertise(Request $request){
        $user = Auth::user();

        $validator = \Validator::make($request->all(), [
            'areas' => 'required',
        ]);

        if ($validator->passes()) {
            $subjects = $request->input('areas');
            for ($i=0; $i < sizeof($subjects); $i++) {
                $subject = new Subject;
                $subject->expert_id = $user->expert->id;
                $subject->sub_category_id = ucfirst(trim($subjects[$i]));
                $subject->name = SubCategory::where('id', trim($subjects[$i]))->first()->name;
                $subject->save();
            }

            return response()->json([
                'success' => 1,
                'message' => 'Your areas of expertise have been updated.'
            ], 201);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Delete FL area of expertise
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function deleteSEAreaOfExpertise(Request $request){
        $user = Auth::user();

        $validator = \Validator::make($request->all(), [
            'uuid' => 'required|string',
        ]);

        if ($validator->passes()) {
            $subject = Subject::where('uuid', $request->input('uuid'))->first();

            if (!$subject) {
                return response()->json([
                    'success' => 0,
                    'error' => 'Area of expertise not found'
                ], 404);
            }

            if ($subject->delete()) {
                return response()->json([
                    'success' => 1,
                    'message' => 'Area of expertise has been removed from your profile.'
                ], 201);
            } else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Error removing area of expertise. Refresh browser and try again'
                ], 409);
            }
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
}
