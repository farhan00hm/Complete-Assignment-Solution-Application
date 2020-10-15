<?php

namespace App\Http\Controllers\DiscountCodes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Traits\DiscountCodeTrait;
use App\Traits\TransactionTrait;

use App\Models\DiscountCode;
use App\Models\CodeRedeemer;
use App\User;
use App\Models\Transaction;

class UserDiscountCodesController extends Controller {
    use DiscountCodeTrait, TransactionTrait;

    /**
     * Get discount codes page
     * @return \Illuminate\View\View
    */
    public function index(){
        $codes = CodeRedeemer::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('member/discount-codes/user/redeem', [
            'title' => 'Redeem Discount Code',
            'codes' => $codes,
            'link' => 'dcnt'
        ]);
    }

    /**
     * Redeem a discount code
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function redeem(Request $request){
        $validator = \Validator::make($request->all(), [
            'code' =>  'required',
        ]);


        if ($validator->passes()) {
            $code = DiscountCode::where('code', $request->input('code'))->first();

            if (! $code) {
                return response()->json([
                    'success' => 0,
                    'error' => 'Invalid discount code'
                ], 200);
            }

            if (! $this->validateCode($code->code)) {
                return response()->json([
                    'success' => 0,
                    'error' => 'Invalid discount code'
                ], 200);
            }

            // Check if user has already redeemed the code
            $redeemed = CodeRedeemer::where('user_id', auth()->user()->id)->where('discount_code_id', $code->id)->count();

            if ($redeemed > 0) {
                return response()->json([
                    'success' => 0,
                    'error' => 'You have already redeemed this discount code.'
                ], 200);
            }

            DB::beginTransaction();
            // Update discount codes table
            try {
                $code->update([
                    'redeem_count' => (int) $code->redeem_count + 1,
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
                $trx->to_user = auth()->user()->id;
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
                auth()->user()->update([
                    'wallet' => (auth()->user()->wallet + $code->amount),
                ]);

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating user wallet. Error: '. $e->getMessage(),
                ], 200);
            }

            // Create an entry to code redeemers table
            try {
                $redeemer = new CodeRedeemer;
                $redeemer->discount_code_id = $code->id;
                $redeemer->user_id = auth()->user()->id;
                $redeemer->save();

            } catch (\Exception $e) {
                \Log::error($e);
                return response()->json([
                    'success' => 0,
                    'error' => 'Error updating redeemers table. Error: '. $e->getMessage(),
                ], 200);
            }

            DB::commit();

            return response()->json([
                'success' => 1,
                'message' => 'Discount code successfully redeemed'
            ], 200);
        }
    }
}
