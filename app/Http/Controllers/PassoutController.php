<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassoutController extends Controller
{
    public function passoutList(){
        $data['header_title'] = "Passout";
        return view('passouts.list', $data);
    }

    public function passoutAdd(){
        $data['header_title'] = "Passout Add";
        return view('passouts.add', $data);
    }

    public function passoutEdit(){
        $data['header_title'] = "Passout Edit";
        return view('passouts.edit', $data);
    }
}
