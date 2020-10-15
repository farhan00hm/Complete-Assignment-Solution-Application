<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Homework;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewSEController extends Controller {
    /**
     * Get review solution expert page
     * @return \Illuminate\View\View
    */
    public function index(Request $request){
    	$homework = Homework::where('uuid', $request->segment(2))->first();

    	if (! $homework) {
    		return redirect()->back();
    	}

    	$prev = str_replace(url('/'), '', url()->previous());
    	$reviewed = Review::where('reviewer', auth()->user()->id)->where('homework_id', $homework->id)->first();

    	return view('member/homework/reviews/student', [
    		'title' => 'Review Freelancer',
    		'hw' => $homework,
    		'prev' => $prev,
    		'reviewed' => $reviewed,
    		'link' => 'hw'
    	]);
    }

    /**
     * Create a review
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function rate(Request $request){
    	$validator = \Validator::make($request->all(), [
            'review' =>  'required|string',
            'rating' =>  'required|string',
            'hwId' =>  'required|string',
        ]);


        if ($validator->passes()) {
        	$hw = Homework::where('id', $request->hwId)->first();
        	if (! $hw) {
        		return response()->json([
	                'success' => 0,
	                'error' => 'Invalid homework'
	            ], 404);
        	}

        	$entry = new Review;
        	$entry->reviewer = auth()->user()->id;
        	$entry->homework_id = $hw->id;
        	$entry->rating = $this->getRating($request->rating);
        	$entry->review = $request->review;

        	if(Auth::user()->user_type == 'FL'){
                $entry->reviewee = $hw->posted_by;
            }else{
                $entry->reviewee = $hw->awarded_to;
            }

			if ($entry->save()) {
				return response()->json([
	                'success' => 1,
	                'message' => 'You successfully reviewed the solution expert.'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error reviewing solution expert. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function getRating($given){
    	switch ($given) {
    		case '5':
    			return (float) 1;
    			break;

    		case '4':
    			return (float) 2;
    			break;

    		case '3':
    			return (float) 3;
    			break;

    		case '2':
    			return (float) 4;
    			break;

    		case '1':
    			return (float) 5;
    			break;

    		default:
    			return (float) $given;
    			break;
    	}
    }
}
