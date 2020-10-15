<?php

namespace App\Http\Controllers\Bid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TransactionTrait;
use App\Jobs\SEHired;

use App\Models\Transaction;
use App\Models\Escrow;
use App\Models\Homework;
use App\Models\Bid;

class HireController extends Controller {
	use TransactionTrait;

    /**
     * Hire - accept a bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function hire(Request $request){
    	$validator = \Validator::make($request->all(), [
            'uuid' => 'required',
        ]);

        if ($validator->passes()) {
        	$bid = Bid::where('uuid', $request->input('uuid'))->first();

        	if (!$bid) {
        		return response()->json([
	                'success' => 0,
	                'error' => 'Invalid bid!'
	            ], 404);
        	}

        	if ($bid->amount > auth()->user()->wallet) {
        		return response()->json([
	                'success' => 0,
	                'redirect' => '/user/financials/wallet',
	                'error' => 'Insufficient funds in wallet. Redirecting to top up page ... '
	            ], 409);
        	}


    		DB::beginTransaction();
    		// Update bids table status = 1 (accepted)
	        try {
	        	$bid->update([
					'status' => 1,
				]);

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('error', $e->getMessage());
	        }

        	// Update homeworks table set: status = 3 (Hired), awarded_to = id of bid submitter
	        try {
	        	$bid->homework->update([
					'status' => 5,
					'awarded_to' => $bid->user_id,
					'winning_bid_id' => $bid->id,
					'winning_bid_amount' => $bid->amount,
					'hired_on' => date('Y-m-d'),
				]);

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('error', $e->getMessage());
	        }

	        // Update users table (wallet field) : deduct
	        try {
	        	auth()->user()->update([
					'wallet' => (auth()->user()->wallet - $bid->amount),
				]);

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('error', $e->getMessage());
	        }

	        // Create a transaction entry
	        try {
	        	$trx = new Transaction;
	        	$trx->from_user = auth()->user()->id;
	        	$trx->to_user = $bid->user_id;
	        	$trx->initiator = auth()->user()->id;
	        	$trx->homework_id = $bid->homework->id;
	        	$trx->sk_ref = $this->generateSkooliTransactionRef();
	        	$trx->amount = $bid->amount;
	        	$trx->status = "COMPLETED";
	        	$trx->type = "PAY";
	        	$trx->processor = "INTERNAL";
	        	$trx->processor_status = "SUCCESS";
	        	$trx->comments = "Bid accepted";
	        	$trx->save();

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('error', $e->getMessage());
	        }

	        // Create an escrow entry
	        try {
	        	$escrow = new Escrow;
	        	$escrow->homework_id = $bid->homework->id;
	        	$escrow->bid_id = $bid->id;
	        	$escrow->transaction_id = $trx->id;
	        	$escrow->amount = $bid->amount;
	        	$escrow->status = "ACTIVE";
	        	$escrow->save();

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('error', $e->getMessage());
	        }

	        DB::commit();

	        // Queue an email to FL alerting them that they have been hired
	        SEHired::dispatch($bid->bidder->email, $bid->homework->uuid, $bid->homework->title);

    		return response()->json([
                'success' => 1,
                'balance' => auth()->user()->wallet,
                'redirect' => '/homeworks/ongoing',
                'message' => 'You have just hired! Redirecting to ongoing homeworks. New wallet balance: ' . auth()->user()->wallet
            ], 201);

        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Bids - decline a bid
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function decline(Request $request){
    	$validator = \Validator::make($request->all(), [
            'uuid' => 'required',
        ]);

        if ($validator->passes()) {
        	$bid = Bid::where('uuid', $request->input('uuid'))->first();

        	if (!$bid) {
        		return response()->json([
	                'success' => 0,
	                'error' => 'Invalid bid!'
	            ], 404);
        	}


    		DB::beginTransaction();
    		// Update bids table status = 3 (declined)
	        try {
	        	$bid->update([
					'status' => 3,
				]);

	        } catch (\Exception $e) {
	        	\Log::error($e);
	            return back()->with('error', $e->getMessage());
	        }

	        DB::commit();

    		return response()->json([
                'success' => 1,
                'message' => 'Bid declined'
            ], 201);

        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }
}
