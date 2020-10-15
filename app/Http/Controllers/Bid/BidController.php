<?php

namespace App\Http\Controllers\Bid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TransactionTrait;
use App\Jobs\SECounterOffer;

use App\Models\Transaction;
use App\Models\Escrow;
use App\Models\Homework;
use App\Models\Bid;
use App\Models\CounterBid;

class BidController extends Controller {
    use TransactionTrait;

    /**
     * Get all open bids - Mostly a request from FL
     * @return \Illuminate\View\View
    */
    public function open(Request $request){
    	$bids = Bid::where('user_id', auth()->user()->id)->where('status', 0)->orderBy('id', 'DESC')->paginate(10);

    	return view('member/bids/fl/open', [
    		'title' => 'Open Bids',
    		'bids' => $bids,
    		'link' => 'bids',
    	]);

    }

    /**
     * Submit a bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function submit(Request $request){
    	$validator = \Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'completion' => 'required|date',
            'intro' => 'required|max:300',
        ]);

    	// Check if the user has another open bid or declined
    	$other = Bid::where('homework_id', $request->input('hwId'))->where('user_id', auth()->user()->id)->first();

    	if ($other && $other->status == 0) {
    		return response()->json([
                'success' => 0,
                'error' => 'Error! You already have another open bid for this homework'
            ], 409);
    	}

    	if ($other && $other->status == 3) {
    		return response()->json([
                'success' => 0,
                'error' => 'Error! You cannot submit another bid since your previous bid was declined.'
            ], 409);
    	}

        if ($validator->passes()) {
        	$bid = new Bid;
			$bid->homework_id = $request->input('hwId');
			$bid->user_id = auth()->user()->id;
			$bid->amount = $request->input('amount');
			$bid->expected_completion_date = $request->input('completion');
			$bid->proposal = $request->input('intro');

			if ($bid->save()) {
				return response()->json([
	                'success' => 1,
	                'message' => 'Bid submitted successfully'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error submitting bid. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Withdraw a bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function withdraw(Request $request){
    	// Check if the user has another open bid or declined
    	$bid = Bid::where('id', $request->input('bidId'))->where('user_id', auth()->user()->id)->first();

    	if (!$bid) {
    		return response()->json([
                'success' => 0,
                'error' => 'Bid not found'
            ], 404);
    	}

    	if ($bid->delete()) {
    		return response()->json([
                'success' => 1,
                'message' => 'Bid withdrawn successfully'
            ], 201);
    	}else{
    		return response()->json([
                'success' => 0,
                'error' => 'Error withdrawing bid. Refresh browser and try again'
            ], 500);
    	}

    }

    /**
     * Get all declined bids - Mostly a request from FL
     * @return \Illuminate\View\View
    */
    public function declined(Request $request){
    	$bids = Bid::where('user_id', auth()->user()->id)->where('status', 3)->orderBy('id', 'DESC')->paginate(10);

    	return view('member/bids/fl/declined', [
    		'title' => 'Declined Bids',
    		'bids' => $bids,
    		'link' => 'bids',
    	]);

    }

    /**
     * Submit a counter offer/bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function counter(Request $request){
        $validator = \Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'note' => 'nullable|max:200',
        ]);

        // Check if the bid being countered exists
        $bid = Bid::where('id', $request->input('bidId'))->first();

        if (!$bid) {
            return response()->json([
                'success' => 0,
                'error' => 'Error! Bid to counter not found'
            ], 201);
        }

        if ($validator->passes()) {
            $cb = new CounterBid;
            $cb->bid_id = $bid->id;
            $cb->amount = $request->input('amount');
            $cb->note = $request->input('note');

            if ($cb->save()) {
                // Send a counter offer email to FL
                SECounterOffer::dispatch($bid->bidder->email, $bid->uuid, $bid->homework->uuid, $bid->homework->title);

                return response()->json([
                    'success' => 1,
                    'message' => 'Counter offer submitted successfully'
                ], 201);
            } else {
                return response()->json([
                    'success' => 0,
                    'error' => 'Error submitting counter offer. Refresh browser and try again'
                ], 409);
            }
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Get all counter bids - Mostly a request from FL
     * @return \Illuminate\View\View
    */
    public function counterOffers(Request $request){
        $myBidIds = array();
        $bids = Bid::where('user_id', auth()->user()->id)->where('status', 0)->get();

        foreach ($bids as $bid) {
            array_push($myBidIds, $bid->id);
        }

        $offers = CounterBid::whereIn('bid_id', $myBidIds)->where('status', 0)->orderBy('id', 'DESC')->paginate(10);

        return view('member/bids/fl/counter', [
            'title' => 'My Active Counter Offers',
            'offers' => $offers,
            'link' => 'bids',
        ]);

    }

    /**
     * Decline a counter bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function declineCounter(Request $request){
        $counter = CounterBid::where('id', $request->input('counterId'))->first();

        if (!$counter) {
            return response()->json([
                'success' => 0,
                'error' => 'Bid not found'
            ], 404);
        }

        if ($counter->update([
            'status' => 3,
        ])) {
            return response()->json([
                'success' => 1,
                'message' => 'You have decline the counter offer'
            ], 201);
        }else{
            return response()->json([
                'success' => 0,
                'error' => 'Error declining counter offer. Refresh browser and try again'
            ], 500);
        }

    }

    /**
     * Accept a counter bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function acceptCounter(Request $request){
        $counter = CounterBid::where('id', $request->input('counterId'))->first();

        if (!$counter) {
            return response()->json([
                'success' => 0,
                'error' => 'Counter offer not found'
            ], 404);
        }

        if ($counter->amount > $counter->bid->homework->postedBy->wallet) {
            return response()->json([
                'success' => 0,
                'error' => 'Error! Insufficent funds for the homework to accept counter offer.'
            ], 201);
        }

        DB::beginTransaction();
        // Update counter offers table status = 1 (accepted)
        try {
            $counter->update([
                'status' => 1,
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => $e->getMessage()
            ], 201);
        }

        // Update bids table: amount = amount of the counter, status = 1 (accepted)
        try {
            $counter->bid->update([
                'amount' => $counter->amount,
                'status' => 1,
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => $e->getMessage()
            ], 201);
        }

        // Update homeworks table set: status = 5 (hired), awarded_to = logged in user
        try {
            $counter->bid->homework->update([
                'status' => 5,
                'awarded_to' => auth()->user()->id,
                'winning_bid_id' => $counter->bid->id,
                'winning_bid_amount' => $counter->bid->amount,
                'hired_on' => date('Y-m-d'),
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => $e->getMessage()
            ], 201);
        }

        // Update users table (wallet field for the user who posted the homework) : deduct
        try {
            $counter->bid->homework->postedBy->update([
                'wallet' => ($counter->bid->homework->postedBy->wallet - $counter->amount),
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => $e->getMessage()
            ], 201);
        }

        // Create a transaction entry
        try {
            $trx = new Transaction;
            $trx->from_user = $counter->bid->homework->postedBy->id;
            $trx->to_user = $counter->bid->user_id;
            $trx->initiator = $counter->bid->homework->postedBy->id;
            $trx->homework_id = $counter->bid->homework->id;
            $trx->sk_ref = $this->generateSkooliTransactionRef();
            $trx->amount = $counter->amount;
            $trx->status = "COMPLETED";
            $trx->type = "PAYC";
            $trx->processor = "INTERNAL";
            $trx->processor_status = "SUCCESS";
            $trx->comments = "Counter offer accepted";
            $trx->save();

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => $e->getMessage()
            ], 201);
        }

        // Create an escrow entry
        try {
            $escrow = new Escrow;
            $escrow->homework_id = $counter->bid->homework->id;
            $escrow->bid_id = $counter->bid->id;
            $escrow->transaction_id = $trx->id;
            $escrow->amount = $counter->amount;
            $escrow->status = "ACTIVE";
            $escrow->save();

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => 0,
                'error' => $e->getMessage()
            ], 201);
        }

        DB::commit();

        return response()->json([
            'success' => 1,
            'redirect' => '/freelancer/homeworks/ongoing',
            'message' => 'You have accepted the counter offer and been hired! Redirecting to ongoing homeworks.'
        ], 201);

    }
}
