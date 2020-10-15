<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Transaction;
use App\Models\Escrow;
use App\Models\Commission;
use App\Models\Expert;
use App\Models\Homework;

class DashboardController extends Controller {
    /**
     * Get registration page
     * @return \Illuminate\View\View
    */
    public function index(){
        if (Auth::user()->user_type === "Student" || Auth::user()->user_type === "Professional") {
            $trxs = Transaction::where('from_user', auth()->user()->id)->orWhere('to_user', auth()->user()->id)->orderBy('id', 'DESC')->paginate(6);

            return view('member/dashboard/'.strtolower(Auth::user()->user_type), [
                'title' => 'Dashboard',
                'link' => 'dash',
                'trxs' => $trxs,
            ]);
        }

        if (Auth::user()->user_type === "FL") {
            $trxs = Transaction::where('from_user', auth()->user()->id)->orWhere('to_user', auth()->user()->id)->orderBy('id', 'DESC')->paginate(6);

            return view('member/dashboard/'.strtolower(Auth::user()->user_type), [
                'title' => 'Dashboard',
                'link' => 'dash',
                'trxs' => $trxs,
            ]);
        }

        if (Auth::user()->user_type === "Admin") {
            $trxCount = Transaction::where('status', "COMPLETED")->where('type', 'TOPUP')->count();
            $totalComms = Commission::sum('amount');
            $escrowValue = Escrow::where('status', 'ACTIVE')->sum('amount');

            $noOfStudents = User::where('user_type', 'Student')->count();
            $noOfSE = Expert::where('approved', 1)->count();
            $homeworksPosted = Homework::count();

            $openHomeworks = Homework::where('status', 1)->count();
            $ongoingHomeworks = Homework::whereIn('status', [3, 5])->count();
            $completedHomeworks = Homework::where('status', 8)->count();

            return view('member/dashboard/'.strtolower(Auth::user()->user_type), [
                'title' => 'Dashboard',
                'link' => 'dash',
                'trxCount' => $trxCount,
                'totalComms' => $totalComms,
                'escrowValue' => $escrowValue,
                'noOfStudents' => $noOfStudents,
                'noOfSE' => $noOfSE,
                'homeworksPosted' => $homeworksPosted,
                'openHomeworks' => $openHomeworks,
                'ongoingHomeworks' => $ongoingHomeworks,
                'completedHomeworks' => $completedHomeworks,
            ]);
        }

    	return view('member/dashboard/'.strtolower(Auth::user()->user_type), [
    		'title' => 'Dashboard',
    		'link' => 'dash'
    	]);
    }
}
