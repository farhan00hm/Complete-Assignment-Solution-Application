<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Jobs\ContactUs;

class PagesController extends Controller {
    /**
     * Get contact us page
     * @return \Illuminate\View\View
    */
    public function contactPage(){
    	return view('pages/contact', [
    		'title' => 'Contact Us'
    	]);
    }

    /**
     * Send a message
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function contactUs(Request $request){
    	$validator = \Validator::make($request->all(), [
            'name' =>  'required|string',
            'email' =>  'required|email',
            'subject' =>  'required|max:200',
            'comments' =>  'required',
        ]);


        if ($validator->passes()) {
        	// Queue an email for contacting us
            ContactUs::dispatch($request->input('name'), $request->input('email'), $request->input('subject'), $request->input('comments'), env('ADMIN_EMAIL_ADDRESS'));

        	return response()->json([
                'success' => 1,
                'message' => 'Thanks for reaching out. We will get back to you in the shortest time humanly possible'
            ], 201);
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Get how it works page
     * @return \Illuminate\View\View
    */
    public function how(){
        return view('pages/how', [
            'title' => 'How It Works'
        ]);
    }

    /**
     * Get about us page
     * @return \Illuminate\View\View
    */
    public function about(){
        return view('pages/about', [
            'title' => 'About Us'
        ]);
    }
}
