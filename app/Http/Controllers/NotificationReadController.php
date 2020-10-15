<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationReadController extends Controller
{
    public function markRead($notificationId){
        $notification = DB::table('notifications')->where('id',$notificationId)->first();
//        dd($notification->data["hwUuid"]);
        $uuid = json_decode($notification->data)->hwUuid;
//        $notification = Auth::user()->Notifications->find($notificationId);
//        Auth::user()->unreadNotifications->where('id',$notificationId)->markAsRead();
        DB::table('notifications')->where('id',$notificationId)->update(['read_at'=>Carbon::now()]);
        return redirect()->route('homeworks.single',$uuid);
    }
}
