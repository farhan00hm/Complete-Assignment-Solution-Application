<?php

namespace App\Http\Controllers\Financials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;

class StudentTransactionController extends Controller {
    /**
     * Get registration page
     * @return \Illuminate\View\View
    */
    public function index(){
        $trxs = Transaction::where('from_user', auth()->user()->id)->orWhere('to_user', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('member/financials/student/transactions', [                                 
            'title' => 'Transactions',
            'link' => 'fncls',
            'trxs' => $trxs,
        ]);
    }

   

   
}
