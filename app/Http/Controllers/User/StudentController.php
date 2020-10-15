<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Transaction;

class StudentController extends Controller {
    /**
     * Get all students
     * @return \Illuminate\View\View
    */
    public function index(Request $request){
    	$students = User::whereIn('user_type', ['Student', 'Professional'])->paginate(10);

		return view('member/users/students/all', [
    		'title' => 'Students',
    		'link' => 'studs',
    		'students' => $students
    	]);
    }

    /**
     * Get a student profile
     * @return \Illuminate\View\View
    */
    public function profile(Request $request){
    	$student = User::whereIn('user_type', ['Student', 'Professional'])->where('uuid', $request->segment(4))->first();
//    	dd($student->reviewee());

		if (! $student)
			return redirect()->back();

		$trxs = Transaction::where('from_user', $student->id)->orWhere('to_user', $student->id)->orderBy('id', 'DESC')->paginate(10);

		return view('member/users/students/profile', [
    		'title' => 'Students',
    		'link' => 'studs',
    		'student' => $student,
    		'trxs' => $trxs,
    	]);

    }
}
