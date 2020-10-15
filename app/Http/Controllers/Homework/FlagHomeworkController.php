<?php

namespace App\Http\Controllers\Homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\FlaggedHomework;
use App\Models\Homework;

class FlagHomeworkController extends Controller {
    /**
     * Flag a homework
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function flag(Request $request) {
    	// Check if the user has already flagged the homework
    	if (FlaggedHomework::where('homework_id', $request->input('id'))->where('flagged_by', auth()->user()->id)->first()) {
    		return response()->json([
                'success' => 0,
                'error' => 'You already flagged this homework!'
            ], 201);
    	}

    	$validator = \Validator::make($request->all(), [
			'reason' => 'required|string',
        ]);

        if ($validator->passes()) {
        	$flhw = new FlaggedHomework;
			$flhw->homework_id = $request->input('id');
			$flhw->flagged_by = auth()->user()->id;
			$flhw->reason = $request->input('reason');

			if ($flhw->save()) {
				return response()->json([
	                'success' => 1,
	                'message' => 'Your report has been filed and will be acted upon.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error flagging homework. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Get flagged homeworks page
     * @return \Illuminate\View\View
    */
    public function flagged(){
    	$hws = FlaggedHomework::where('resolution_status', 1)->paginate(10);

    	return view('member/homework/admin/flagged', [
    		'title' => 'Flagged Homeworks',
    		'hws' => $hws,
    		'link' => 'flhw'
    	]);
    }

    /**
     * Admin approve flagged homework
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function approve(Request $request) {
    	$hw = Homework::where('id', $request->input('hwId'))->first();

    	if (!$hw) {
    		return response()->json([
                'success' => 0,
                'error' => 'Homework not found'
            ], 404);
    	}

    	DB::beginTransaction();
  
        try {
        	FlaggedHomework::where('homework_id', $hw->id)->update([
        		'resolution_status' => 2,
        		'resolution_date' => date('Y-m-d'),
        	]);

        } catch (\Exception $e) {
        	\Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => 'Error updating flagged homework status'
            ], 201);
        }

        try {
        	$hw->update([
        		'status' => 4,
        		'deleted_at' => date('Y-m-d H:i:s'),
        	]);

        } catch (\Exception $e) {
        	\Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => 'Error approving flag request'
            ], 201);
        }

        DB::commit();

        return response()->json([
	        'success' => 1,
	        'message' => 'Homework has been purged out of the system'
	    ], 201);
    }

    /**
     * Admin decline flagged homework
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function decline(Request $request) {
    	$hw = Homework::where('id', $request->input('hwId'))->first();

    	if (!$hw) {
    		return response()->json([
                'success' => 0,
                'error' => 'Homework not found'
            ], 404);
    	}

    	DB::beginTransaction();
  
        try {
        	FlaggedHomework::where('homework_id', $hw->id)->delete();

        } catch (\Exception $e) {
        	\Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => 'Error deleting flagged homework status'
            ], 201);
        }

        DB::commit();

        return response()->json([
	        'success' => 1,
	        'message' => 'Homework status has been updated'
	    ], 201);
    }
}
