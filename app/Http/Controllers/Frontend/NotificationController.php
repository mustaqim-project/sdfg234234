<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use App\Models\Friendships;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Session;

class NotificationController extends Controller
{
    public function notifications()
    {
        $date = Carbon::today();
        $page_data['new_notification'] = Notification::where('reciver_user_id', auth()->user()->id)->where('status', '0')
            ->orderBy('id', 'DESC')->get();
        $page_data['older_notification'] = Notification::where('reciver_user_id', auth()->user()->id)->where('created_at', '<', $date)->orderBy('id', 'DESC')->get();
        $page_data['view_path'] = 'frontend.notification.notification';
        return view('frontend.index', $page_data);
    }

    public function accept_friend_notification($id)
    {
        $response = array();
        $is_updated = Friendships::where('requester', $id)->where('accepter', auth()->user()->id)->update(['is_accepted' => '1']);
        Notification::where('sender_user_id', $id)->where('reciver_user_id', auth()->user()->id)->update(['status' => '1', 'view' => '1']);

        if ($is_updated == 1) {
            //update my id to my friend list
            $my_friends = User::where('id', auth()->user()->id)->value('friends');
            $my_friends = json_decode($my_friends);
            if (is_array($my_friends)) {
                array_push($my_friends, (int) $id);
            } else {
                $my_friends = [(int) $id];
            }
            $my_friends = json_encode($my_friends);

            User::where('id', auth()->user()->id)->update(['friends' => $my_friends]);

            //update my id to my friend list
            $my_friends_of_friends = User::where('id', $id)->value('friends');
            $my_friends_of_friends = json_decode($my_friends_of_friends);

            if (is_array($my_friends_of_friends)) {
                array_push($my_friends_of_friends, (int) auth()->user()->id);
            } else {
                $my_friends_of_friends = [(int) auth()->user()->id];
            }
            $my_friends_of_friends = json_encode($my_friends_of_friends);

            User::where('id', $id)->update(['friends' => $my_friends_of_friends]);

        }

        $notify = new Notification();
        $notify->sender_user_id = auth()->user()->id;
        $notify->reciver_user_id = $id;
        $notify->type = "friend_request_accept";
        $notify->save();

        Session::flash('success_message', get_phrase('Friend Request Accepted'));
        $response = array('reload' => 1);
        return json_encode($response);
    }

    public function decline_friend_notification($id)
    {
        $response = array();
        $friendship = Friendships::where('requester', $id)->where('accepter', auth()->user()->id)->delete();
        $notify = Notification::where('sender_user_id', $id)->where('reciver_user_id', auth()->user()->id)->delete();

        Session::flash('success_message', get_phrase('Cancle Friend Request'));
        $response = array('reload' => 1);
        return json_encode($response);
    }



    public function mark_as_read($id)
    {
        $response = array();
        Notification::where('id', $id)->update(['status' => '1', 'view' => '1']);

        Session::flash('success_message', get_phrase('Marked As Read'));
        $response = array('reload' => 1);
        return json_encode($response);
    }


}
