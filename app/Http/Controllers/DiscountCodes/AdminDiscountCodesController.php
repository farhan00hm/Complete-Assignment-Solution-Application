<?php

namespace App\Http\Controllers\DiscountCodes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\DiscountCodeTrait;
use App\Traits\TransactionTrait;

use App\Models\DiscountCode;
use App\User;
use App\Models\Transaction;

class AdminDiscountCodesController extends Controller {
    use DiscountCodeTrait, TransactionTrait;

    /**
     * Get discount codes page
     * @return \Illuminate\View\View
    */
    public function index(){
        $codes = DiscountCode::where('status', 'CREATED')->orderBy('id', 'DESC')->paginate(10);

        return view('member/discount-codes/admin/active', [
            'title' => 'Unused Discount Codes',
            'codes' => $codes,
            'link' => 'dcnt'
        ]);
    }

    /**
     * Get in active discount codes page
     * @return \Illuminate\View\View
    */
    public function inactive(){
        $codes = DiscountCode::withTrashed()->where('status', 'INVALIDATED')->orderBy('id', 'DESC')->paginate(10);

        return view('member/discount-codes/admin/inactive', [
            'title' => 'Unused Discount Codes',
            'codes' => $codes,
            'link' => 'dcnt'
        ]);
    }

    /**
     * Get create a discount code page
     * @return \Illuminate\View\View
    */
    public function new(){
    	return view('member/discount-codes/admin/new', [
    		'title' => 'Create a Discount Code',
    		'link' => 'dcnt'
    	]);
    }

    /**
     * Create a discount code
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function create(Request $request){
    	$validator = \Validator::make($request->all(), [
            'amount' =>  'required|numeric',
            'comments' => 'nullable|max:200',
        ]);


        if ($validator->passes()) {
            $code = $this->generateCode();

        	$ds = new DiscountCode;
        	$ds->created_by = auth()->user()->id;
            $ds->code = $code;
			$ds->amount = $request->input('amount');
			$ds->comments = $request->input('comments');

			if ($ds->save()) {
				return response()->json([
	                'success' => 1,
	                'message' => 'Discount code created. Code: '.$code,
	            ], 201);
			} else {
				return response()->json([
	                'success' => 0,
	                'error' => 'Error generating code. Refresh browser and try again'
	            ], 409);
			}
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Admin issue discount code
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    /*public function adminIssue(Request $request){
        $validator = \Validator::make($request->all(), [
            'username' =>  'required',
            'codeId' => 'required|numeric',
        ]);


        if ($validator->passes()) {
            $user = User::where('username', $request->input('username'))->first();

            if (! $user) {
                return response()->json([
                    'success' => 0,
                    'error' => 'Invalid user selected'
                ], 200);
            }

            $code = DiscountCode::where('id', $request->input('codeId'))->first();

            if (! $code) {
                return response()->json([
                    'success' => 0,
                    'error' => 'Invalid discount code selected'
                ], 200);
            }

            DB::beginTransaction();
            // Update discount codes table
            try {
                $code->update([
                    'status' => 'REDEEMED',
                    'discounted_by' => auth()->user()->id,
                    'discounted_to' => $user->id,
                    'discounted_on' => date('Y-m-d'),
                    'redemmed_on' => date('Y-m-d'),
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error redeeming discount code. Error: '. $e->getMessage(),
                ], 200);
            }

            // Create a transaction entry
            try {
                $trx = new Transaction;
                $trx->from_user = auth()->user()->id;
                $trx->to_user = $user->id;
                $trx->initiator = auth()->user()->id;
                $trx->sk_ref = $this->generateSkooliTransactionRef();
                $trx->amount = $code->amount;
                $trx->status = "COMPLETED";
                $trx->type = "DISCOUNT";
                $trx->processor = "INTERNAL";
                $trx->processor_status = "SUCCESS";
                $trx->comments = "Discount code: " . $code->code;
                $trx->save();

            } catch (\Exception $e) {
                \Log::error($e);
               return response()->json([
                    'success' => 0,
                    'error' => 'Error creating a transaction. Error: '. $e->getMessage(),
                ], 200);
            }

            // Top up wallet for the user
            try {
                $user->update([
                    'wallet' => ($user->wallet + $code->amount),
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating user wallet. Error: '. $e->getMessage(),
                ], 200);
            }

            DB::commit();

            // Sent an email to the user (student/parent/FL) alerting them of the discount

            return response()->json([
                'success' => 1,
                'message' => 'Discount code successfully redeemed'
            ], 200);
        }
    }*/

    /**
     * Delete a discount code
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function delete(Request $request){
        $code = DiscountCode::where('uuid', $request->input('uuid'))->first();
        if ($code->update([
            'status' => 'INVALIDATED',
            'invalidated_on' => date('Y-m-d'),
        ])) {
            $code->delete();
            return response()->json([
                'success' => 1,
                'message' => 'Code has been deactivated.'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'error' => 'Error deactivating code'
            ], 409);
        }
    }
}
