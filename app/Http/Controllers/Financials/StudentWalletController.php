<?php

namespace App\Http\Controllers\Financials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\TransactionTrait;

use App\Models\Transaction;

class StudentWalletController extends Controller {
	use TransactionTrait;

    /**
     * Get student wallet
     * @return \Illuminate\View\View
    */
    public function index(Request $request){
        $topups = Transaction::where('type', 'TOPUP')->orWhere('to_user', auth()->user()->id)->orderBy('id', 'DESC')->paginate(6);
    	return view('member/financials/student/wallet', [
    		'title' => 'Post Homework',
    		'link' => 'wallet',
            'topups' => $topups,
    	]);
    }

    /**
     * Top up wallet - initiate transaction
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function topUp(Request $request){
    	$validator = \Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);

        if ($validator->passes()) {
        	$skRef = $this->generateSkooliTransactionRef();
        	$trx = new Transaction;
        	$trx->to_user = auth()->user()->id;
        	$trx->initiator = auth()->user()->id;
        	$trx->sk_ref = $skRef;
        	$trx->amount = $request->input('amount');
        	$trx->status = "CREATED";
        	$trx->type = "TOPUP";
        	$trx->processor = $request->input('processor');
        	$trx->processor_status = "CREATED";
        	$trx->comments = "Wallet top up by " . auth()->user()->username . ". Wallet balance before transaction: " . auth()->user()->wallet;

			if ($trx->save()) {
				return response()->json([
	                'success' => 1,
	                'sk_ref' => $skRef,
	                'message' => 'Transaction initiated successfully'
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error initiating transaction. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Top up wallet - confirm transaction
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function payStackCallback(Request $request){
    	$validator = \Validator::make($request->all(), [
            'sk_ref' => 'required',
            'trans' => 'required',
            'status' => 'required',
            'message' => 'required',
        ]);

        if ($validator->passes()) {
        	$trx = Transaction::where('sk_ref', $request->input('sk_ref'))->where('to_user', auth()->user()->id)->first();

        	if (!$trx) {
        		return response()->json([
	                'success' => 0,
	                'error' => 'Invalid transaction!'
	            ], 404);
        	}

        	if ($request->input('status') == "success") {
        		DB::beginTransaction();
	        	// Update transactions table
		        try {
		        	$trx->update([
						'status' => 'COMPLETED',
						'processor_id' => $request->input('trans'),
						'processor_status' => strtoupper($request->input('status')),
					]);

		        } catch (\Exception $e) {
		        	\Log::error($e);
		            return back()->with('error', $e->getMessage);
		        }

		        // Update users table (wallet field)
		        try {
		        	auth()->user()->update([
						'wallet' => (auth()->user()->wallet + $trx->amount),
					]);

		        } catch (\Exception $e) {
		        	\Log::error($e);
		            return back()->with('error', $e->getMessage);
		        }

		        DB::commit();

        		return response()->json([
	                'success' => 1,
	                'balance' => auth()->user()->wallet,
	                'message' => 'Wallet top up success. Wallet balance: ' . auth()->user()->wallet
	            ], 201);
        	} else {
        		return response()->json([
	                'success' => 0,
	                'error' => 'Transaction was not completed on Paystack end. Your wallet balance is: ' . auth()->user()->wallet
	            ], 409);
        	}
        	
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }
}
