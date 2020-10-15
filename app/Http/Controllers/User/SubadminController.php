<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Jobs\SubadminCreated;

use Spatie\Permission\Models\Role;

use App\User;

class SubadminController extends Controller {
	/**
     * Get all subadmins
     * @return \Illuminate\View\View
    */
    public function index(){
    	$subadmins = User::where('user_type', "Subadmin")->orderBy('id', 'DESC')->paginate(10);

    	return view('member/users/subadmins/all', [
    		'title' => 'Sub Admins',
    		'link' => 'subs',
    		'subadmins' => $subadmins,
    	]);
    }

    /**
     * Get create subadmin page
     * @return \Illuminate\View\View
    */
    public function new(){
        $roles = Role::whereNotIn('name', ['Admin', 'Subadmin', 'FL', 'Professional', 'Student'])->get();

    	return view('member/users/subadmins/new', [
    		'title' => 'Create Sub Admin',
    		'link' => 'subs',
            'roles' => $roles,
    	]);
    }

    /**
     * Create a subadmin
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function create(Request $request){
    	$validator = \Validator::make($request->all(), [
			'first' => 'required|string',
            'last' => 'required|string',
            'email' =>  'required|email|unique:users',
            'role' => 'required',
        ]);


        if ($validator->passes()) {
        	$raw = (string) Str::uuid();

			$sub = new User;
			$sub->first_name = ucfirst($request->input('first'));
			$sub->last_name = ucfirst($request->input('last'));
			$sub->email = strtolower($request->input('email'));
			$sub->username = strtolower($request->input('email'));
			$sub->user_type = "Subadmin";
			$sub->email_verified_at = Carbon::now()->toDateString();
			$sub->password = bcrypt($raw);

			if ($sub->save()) {
				// Attach Subadmin specific role to the user
				$sub->assignRole($request->input('role'));

                // Queue an email to send password to subadmin email
                $name = $sub->first_name." ". $sub->last_name;
                SubadminCreated::dispatch($name, $sub->email, $raw, $sub->roles()->first()->long_name);

				return response()->json([
	                'success' => 1,
	                'message' => 'Subadmin created successfully. Login credentials send via email.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error creating sub admin. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Get edit subadmin page
     * @param \Illuminate\Http\Request
     * @return \Illuminate\View\View
    */
    public function edit(Request $request){
    	$subadmin = User::where('uuid', $request->segment(4))->first();
        $roles = Role::whereNotIn('name', ['Admin', 'Subadmin', 'FL', 'Professional', 'Student'])->get();

    	return view('member/users/subadmins/edit', [
    		'title' => 'Create Sub Admin',
    		'link' => 'subs',
    		'subadmin' => $subadmin,
            'roles' => $roles,
    	]);
    }

    /**
     * Update a subadmin
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request){
    	$user = User::where('id', $request->input('id'))->first();

    	$validator = \Validator::make($request->all(), [
			'first' => 'required|string',
            'last' => 'required|string',
            'email' => 'required|unique:users,email,'.$user->id,
            'role' => 'required',
        ]);


        if ($validator->passes()) {
			if ($user->update([
				'first_name' => $request->input('first'),
				'last_name' => $request->input('last')
			])) {
                // Remove all roles assigned to the subadmin and attach a role afresh.
                $user->roles()->detach();
                $user->assignRole($request->input('role'));
				return response()->json([
	                'success' => 1,
	                'message' => 'Sub admin details updated successfully.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error updating sub admin. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Delete a subadmin
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function delete(Request $request){
		if (User::where('uuid', $request->input('uuid'))->delete()) {
			return response()->json([
                'success' => 1,
                'message' => 'Sub admin has been deleted successfully'
            ], 200);
		} else {
			return response()->json([
                'success' => 0,
                'error' => 'Error deleting sub admin'
            ], 409);
		}
	}
}
