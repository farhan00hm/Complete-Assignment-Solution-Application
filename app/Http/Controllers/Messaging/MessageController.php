<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Room;
use App\Models\MessageThread;
use App\User;

class MessageController extends Controller {
    /**
     * Get messages
     * @return \Illuminate\View\View
    */
    public function index(){
    	$admin = User::where('user_type', 'Admin')->first();
    	if (in_array(auth()->user()->user_type, ["Admin", "Subadmin"])) {
            $rooms = Room::where('from', $admin->id)->orWhere('to', $admin->id)->orderBy('id', 'DESC')->get();

    		if ($rooms->count() == 0) {
    			return view('member/messaging/none', [
		    		'title' => 'Messaging',
		    		'link' => 'msngs',
		    	]);
    		}
    	}



    	if (in_array(auth()->user()->user_type, ["Student", "Professional", "FL"])) {
            $rooms = Room::where('from', auth()->user()->id)->orWhere('to', auth()->user()->id)->orderBy('id', 'DESC')->get();

    		if ($rooms->count() == 0) {
    			$rm = new Room;
    			$rm->from = auth()->user()->id;
    			$rm->to = User::where('user_type', 'Admin')->first()->id;
    			$rm->save();
    		}

    		$rooms = Room::where('from', auth()->user()->id)->orWhere('to', auth()->user()->id)->orderBy('id', 'DESC')->get();
    	}

    	$uuid = $rooms->last()->uuid;

    	return redirect('/messages/'.$uuid);
    }

    /**
     * Get a room
     * @return \Illuminate\View\View
    */
    public function room(Request $request){
    	$uuid = $request->segment(2);
    	$room = Room::where('uuid', $uuid)->first();

    	$threads = MessageThread::where('room_id', $room->id)->get();

    	if (auth()->user()->user_type !== 'Subadmin' || auth()->user()->user_type !== 'Admin') {
    		$rooms = Room::where('from', auth()->user()->id)->orWhere('to', auth()->user()->id)->orderBy('id', 'DESC')->get();
    	}

    	$from = auth()->user()->id;

    	$admin = User::where('user_type', 'Admin')->first();
    	if (auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Subadmin') {
    		$rooms = Room::where('from', $admin->id)->orWhere('to', $admin->id)->orderBy('id', 'DESC')->get();
    		$from = $admin->id;
    	}

    	return view('member/messaging/rooms', [
    		'title' => 'Messaging',
    		'threads' => $threads,
    		'rooms' => $rooms,
    		'currentRoom' => $room,
    		'from' => $from,
    		'link' => 'msngs',
    	]);
    }

    /**
     * Send a message
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function send(Request $request){
    	$validator = \Validator::make($request->all(), [
            'message' => 'required',
            'roomId' => 'required',
        ]);

        if ($validator->passes()) {
        	$adminId = User::where('user_type', 'Admin')->first()->id;
        	$from = auth()->user()->id;
        	if(auth()->user()->user_type == "Subadmin"){
        		$from = $adminId;
        	}

        	$room = Room::where('id', $request->input('roomId'))->first();

        	DB::beginTransaction();
	      	try {
      			$room->update([
      				'last_message' => $request->input('message'),
      			]);
	        } catch (\Exception $e) {
	            \Log::error($e);
	            return response()->json([
	                'success' => 0,
	                'error' => "Error sending message"
	            ], 201);
	        }

	        $to = $room->from;
	        if ($to == $from) {
	        	$to = $room->to;
	        }

	      	try {
      			$thd = new MessageThread;
      			$thd->room_id = $room->id;
      			$thd->from = $from;
      			$thd->to = $to;
      			$thd->message = $request->input('message');
      			$thd->save();
	        } catch (\Exception $e) {
	            \Log::error($e);
	            return response()->json([
	                'success' => 0,
	                'error' => "Error sending message"
	            ], 201);
	        }


	        DB::commit();

	        $threads = MessageThread::where('room_id', $room->id)->get();

	        $messages = "";
	        foreach ($threads as $th) {
            	if($th->from == $from){
            		$messages .= '<div class="message-bubble me">';
                        $messages .= '<div class="message-bubble-inner">';
                            $messages .= '<div class="message-text">';
                                $messages .= '<p>'.$th->message.'<br><small style="float: right;">'.$th->created_at->diffForHumans().'</small></p>';
                            $messages .= '</div>';
                        $messages .= '</div>';
                        $messages .= '<div class="clearfix"></div>';
                    $messages .= '</div>';
            	}else{
                	$messages .= '<div class="message-bubble">';
                        $messages .= '<div class="message-bubble-inner">';
                            $messages .= '<div class="message-text">';
                                $messages .= '<p>'.$th->message.'<br><small style="float: left;">'.$th->created_at->diffForHumans().'</small></p>';
                            $messages .= '</div>';
                        $messages .= '</div>';
                        $messages .= '<div class="clearfix"></div>';
                    $messages .= '</div>';
                }
        	}


	        return response()->json([
	            'success' => 1,
	            'messages' => $messages,
	        ], 201);
        }

    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Refresh a room
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function refresh(Request $request){
        $room = Room::where('id', $request->input('roomId'))->first();
        $threads = MessageThread::where('room_id', $room->id)->get();

        $adminId = User::where('user_type', 'Admin')->first()->id;
    	$from = auth()->user()->id;
    	if(auth()->user()->user_type == "Subadmin"){
    		$from = $adminId;
    	}

        $messages = "";
        foreach ($threads as $th) {
        	if($th->from == $from){
        		$messages .= '<div class="message-bubble me">';
                    $messages .= '<div class="message-bubble-inner">';
                        $messages .= '<div class="message-text">';
                            $messages .= '<p>'.$th->message.'<br><small style="float: right;">'.$th->created_at->diffForHumans().'</small></p>';
                        $messages .= '</div>';
                    $messages .= '</div>';
                    $messages .= '<div class="clearfix"></div>';
                $messages .= '</div>';
        	}else{
            	$messages .= '<div class="message-bubble">';
                    $messages .= '<div class="message-bubble-inner">';
                        $messages .= '<div class="message-text">';
                            $messages .= '<p>'.$th->message.'<br><small style="float: left;">'.$th->created_at->diffForHumans().'</small></p>';
                        $messages .= '</div>';
                    $messages .= '</div>';
                    $messages .= '<div class="clearfix"></div>';
                $messages .= '</div>';
            }
    	}


        return response()->json([
            'success' => 1,
            'messages' => $messages,
        ], 201);

    }

    /**
     * Send a message
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
    */
    public function delete(Request $request){
        $room = Room::where('uuid', $request->input('uuid'))->first();

        if (! $room) {
            return response()->json([
                'success' => 0,
                'error' => 'Conversation not found',
            ], 201);
        }

        $threads = MessageThread::where('room_id', $room->id)->get();

        foreach ($threads as $thread) {
            if ($thread->from === auth()->user()->id) {
                $thread->delete();
            }
        }
    }
}
