<?php

namespace App\Http\Controllers\Financials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Commission;

class CommissionController extends Controller {
    /**
     * Get all commissions page
     * @return \Illuminate\View\View
    */
    public function index(){
        $comms = Commission::orderBy('id', 'DESC')->paginate(10);

        return view('member/financials/commissions/all', [
            'title' => 'Commissions',
            'link' => 'comm',
            'comms' => $comms,
        ]);
    }
}
