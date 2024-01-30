<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{

    public function EventList(){
        // $data['getRecord'] = NoticeBoardModel::getRecord();
        $data['header_title'] = "Events List";
        return view('events.list', $data);
    }

    public function AddEvent(){
        $data['header_title'] = "Add New Event";
        return view('events.add', $data);
    }

    public function EditEvent($id){
        // $data['getRecord'] = NoticeBoardModel::getSingle($id);
        $data['header_title'] = "Edit Event";
        return view('events.edit', $data);
    }
}
