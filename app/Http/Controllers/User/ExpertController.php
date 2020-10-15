<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Jobs\SEApproved;
use App\Jobs\SEDeclined;
use App\Jobs\SERequestMoreInfo;

use App\Models\Expert;
use App\Models\Transaction;

class ExpertController extends Controller {
    /**
     * Get all freelancers whose approval status is pending
     * @return \Illuminate\View\View
    */
    public function pendingApproval(){
    	$experts = Expert::where('approved', 0)->paginate(10);

    	return view('member/users/experts/pending', [
    		'title' => 'Freelancers - Pending Approval',
    		'link' => 'exps',
    		'experts' => $experts
    	]);
    }

    /**
     * Approve application
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function approve(Request $request){
    	$expert = Expert::where('uuid', $request->input('uuid'))->first();

    	if (empty($expert)) {
    		return response()->json([
                'success' => 0,
                'error' => 'No expert with the provided details'
            ], 404);
    	}

    	if ($expert->update([
    		'approved' => 1
    	])) {
    		// Send approval email
            SEApproved::dispatch($expert->user->email,  $expert->user->first_name);

    		return response()->json([
                'success' => 1,
                'message' => 'Solution expert approved successfully. An email has been sent with approval status'
            ], 200);
    	} else {
    		return response()->json([
                'success' => 0,
                'error' => 'Error approving solution expert. Refresh browser and try again.'
            ], 500);
    	}

    }

    /**
     * Request more infomation application
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function requestInfo(Request $request){
        $expert = Expert::where('uuid', $request->input('uuid'))->first();

        if (empty($expert)) {
            return response()->json([
                'success' => 0,
                'error' => 'No expert with the provided details'
            ], 404);
        }

        if ($expert->update([
            'approved' => 4
        ])) {
            // Send an email request more info
            SERequestMoreInfo::dispatch($expert->user->email,  $expert->user->first_name, $request->input('info'));

            return response()->json([
                'success' => 1,
                'message' => 'An email has been sent requesting for more information'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error sending request. Refresh browser and try again.'
            ], 500);
        }

    }

    /**
     * Decline application
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function decline(Request $request){
    	$expert = Expert::where('uuid', $request->input('uuid'))->first();

    	if (empty($expert)) {
    		return response()->json([
                'success' => 0,
                'error' => 'No expert with the provided details'
            ], 404);
    	}

    	if ($expert->update([
    		'approved' => 2
    	])) {
    		// Send application declined email
            SEDeclined::dispatch($expert->user->email,  $expert->user->first_name);

    		return response()->json([
                'success' => 1,
                'message' => 'Solution expert application declined. An email has been sent with status'
            ], 200);
    	} else {
    		return response()->json([
                'success' => 0,
                'error' => 'Error declining solution expert application. Refresh browser and try again.'
            ], 500);
    	}

    }

    /**
     * Get all approved freelancers
     * @return \Illuminate\View\View
    */
    public function approved(){
        $experts = Expert::where('approved', 1)->paginate(10);

        return view('member/users/experts/approved', [
            'title' => 'Freelancers - Approved',
            'link' => 'exps',
            'experts' => $experts
        ]);
    }

    /**
     * Get a single solution expert
     * @return \Illuminate\View\View
    */
    public function single(Request $request){
        $expert = Expert::where('uuid', $request->segment(4))->first();

        if (!$expert)
            abort (404);

        return view('member/users/experts/single', [
            'title' => 'Freelancer - Profile',
            'link' => 'exps',
            'expert' => $expert
        ]);
    }

    /**
     * Get a single solution profile
     * @return \Illuminate\View\View
    */
    public function profile(Request $request){
        $expert = Expert::where('uuid', $request->segment(4))->first();

        if (!$expert)
            abort (404);

        $trxs = Transaction::where('from_user', $expert->user->id)->orWhere('to_user', $expert->user->id)->orderBy('id', 'DESC')->paginate(10);

        return view('member/users/experts/profile', [
            'title' => 'Freelancer - Profile',
            'link' => 'exps',
            'expert' => $expert,
            'trxs' => $trxs,
        ]);
    }
}
