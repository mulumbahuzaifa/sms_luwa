<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailUserMail;
use App\Models\NoticeBoardMessageModel;
use App\Models\NoticeBoardModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;

class CommunicateController extends Controller
{
    public function SendEmail(){
        $data['header_title'] = "Send Email";
        return view('communicate.send_email', $data);
    }

    public function SearchUsers(Request $request){
        $json = array();
        if (!empty($request->search)) {
            $getUser = User::SearchUsers($request->search);
            foreach ($getUser as $user) {
                $type = '';
                if ($user->role_name == "Admin") {
                    $type = 'Admin';
                }elseif ($user->role_name == "Teacher") {
                    $type = 'Teacher';
                }elseif ($user->role_name == "Student") {
                    $type = 'Student';
                }elseif ($user->role_name == "Parent") {
                    $type = 'Parent';
                }

                $name = $user->name.' '. $user->last_name.' - '. $type;
                $json[] = ['id' => $user->id, 'text' => $name];
            }
        }
        echo json_encode($json);
    }
    public function SendEmailUser(Request $request){
        if (!empty($request->user_id)) {
            $user = User::getSingle($request->user_id);
            $user->send_message = $request->message;
            $user->send_subject = $request->subject;

            Mail::to($user->email)->send(new SendEmailUserMail($user));
        }
        if (!empty($request->message_to)) {
            foreach($request->message_to as $user_type){
                $getUser = User::getUser($user_type);
                foreach ($getUser as $user) {
                    $user->send_message = $request->message;
                    $user->send_subject = $request->subject;

                    Mail::to($user->email)->send(new SendEmailUserMail($user));
                }
            }
        }
        Toastr::success('Email Send Successfully)','Success');
        return redirect()->back();
    }

    public function NoticeBoard(){
        $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['header_title'] = "Notice Board";
        return view('communicate.noticeboard.list', $data);
    }



    public function AddNoticeBoard(){
        $data['header_title'] = "Add New Notice Board";
        return view('communicate.noticeboard.add', $data);
    }


    public function SaveNoticeBoard(Request $request){
        $save = new NoticeBoardModel();
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->created_by = Auth::user()->id;
        $save->save();

        if (!empty($request->message_to)) {
            foreach ($request->message_to as  $message_to) {
                $message = new  NoticeBoardMessageModel();
                $message->notice_board_id = $save->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }

        Toastr::success('Notice Board Created Successfully)','Success');
        return redirect('admin/communicate/notice_board');
    }


    public function EditNoticeBoard($id){
        $data['getRecord'] = NoticeBoardModel::getSingle($id);
        $data['header_title'] = "Edit Notice Board";
        return view('communicate.noticeboard.edit', $data);
    }

    public function UpdateNoticeBoard($id, Request $request){
        $save = NoticeBoardModel::getSingle($id);
        $save->title = $request->title;
        $save->notice_date = $request->notice_date;
        $save->publish_date = $request->publish_date;
        $save->message = $request->message;
        $save->save();

        NoticeBoardMessageModel::DeletedRecord($id);

        if (!empty($request->message_to)) {
            foreach ($request->message_to as  $message_to) {
                $message = new  NoticeBoardMessageModel();
                $message->notice_board_id = $save->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }

        Toastr::success('Notice Board Updated Successfully)','Success');
        return redirect('admin/communicate/notice_board');
    }

    public function DeleteNoticeBoard($id){
        $save = NoticeBoardModel::getSingle($id);
        $save->delete();
        NoticeBoardMessageModel::DeletedRecord($id);

        Toastr::success('Notice Board Deleted Successfully)','Success');
        return redirect()->back();
    }

}
