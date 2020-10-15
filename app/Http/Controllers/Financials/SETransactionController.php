<?php

namespace App\Http\Controllers\Financials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;
use App\User;

class SETransactionController extends Controller {
    /**
     * Get registration page
     * @return \Illuminate\View\View
    */
    public function index(){
        $trxs = Transaction::where('from_user', auth()->user()->id)->orWhere('to_user', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('member/financials/fl/transactions', [
            'title' => 'Transactions',
            'link' => 'fncls',
            'trxs' => $trxs,
        ]);
    }

    /**
     * Get receipt page
     * @return \Illuminate\View\View
    */
    public function viewReceipt(Request $request){
        if (empty($request->uuid)) {
            return redirect('/');
        }

        $user = User::where('uuid', $request->uuid)->first();
        if (! $user) {
            return redirect('/');
        }

        $trx = Transaction::where('uuid', $request->segment(3))->first();

        return view('pdfs/fl-payment', [
            'title' => 'Payment Receipt',
            'paymentId' => $trx->id,
            'user' => $user,
            'walletBalance' => $trx->amount,
        ]);
    }
}
