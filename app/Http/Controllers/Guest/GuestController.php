<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Homework;

class GuestController extends Controller {
    /**
     * Get home page
     * @return \Illuminate\View\View
    */
    public function index(){
        $this->archiveHomeworks();
    	$homeworks = Homework::where('status', 1)->orderBy('id', 'DESC')->get();
    	return view('welcome', [
    		'homeworks' => $homeworks
    	]);
    }

    public function archiveHomeworks(){
        $homeworks = Homework::where('status', 1)->orderBy('id', 'DESC')->get();
        foreach ($homeworks as $homework){
            $posted_date = $homework->created_at;
            $interval  = $posted_date->diffInHours(date('Y-m-d H:i:s'));
//            dump("Home Work created: ".$posted_date." Today's Date: ".date('Y-m-d H:i:s')." Times Remaining: ".$interval);
            if ($interval > 72 and $homework->hired_on == null and $homework->status == 1) {
//                Homework::where('id', $homework->id)->update(array('status' => 1));
                $homework->status = 2;
                $homework->save();
            }
        }
    }
}
