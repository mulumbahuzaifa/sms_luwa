<?php

namespace App\Http\Controllers;

use App\Models\SettingModel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class Setting extends Controller
{
    // index page setting
    public function index()
    {
        $data['getRecord'] = SettingModel::getSingle();
        $data['header_title'] = "Setting";
        return view('setting.settings', $data);
    }

    //localization setting
    public function localization()
    {
        $data['getRecord'] = SettingModel::getSingle();
        return view('setting.localization_settings', $data);
    }
    //payment setting
    public function payment()
    {
        $data['getRecord'] = SettingModel::getSingle();
        return view('setting.payment_settings', $data);
    }
    //socialMedia setting
    public function socialMedia()
    {
        $data['getRecord'] = SettingModel::getSingle();
        return view('setting.social_settings', $data);
    }
    //Other setting
    public function other()
    {
        $data['getRecord'] = SettingModel::getSingle();
        return view('setting.other_settings', $data);
    }

    public function update(Request $request){
        $setting = SettingModel::getSingle();
        if (!$setting) {
            $newSetting = new SettingModel();
            $newSetting->website_name   = trim($request->website_name);
            $newSetting->address    = trim($request->address);
            $newSetting->country       = trim($request->country);
            $newSetting->city       = trim($request->city);
            $newSetting->state       = trim($request->state);
            $newSetting->zip_code       = trim($request->zip_code);
            $newSetting->email       = trim($request->email);
            if(!empty($request->logo)) {
                $upload_file = rand() . '.' . $request->logo->extension();
                $request->logo->move(storage_path('app/public/setting/'), $upload_file);
                $newSetting->logo = $upload_file;
            }
            if(!empty($request->favicon)) {
                $upload_file2 = rand() . '.' . $request->favicon->extension();
                $request->favicon->move(storage_path('app/public/setting/'), $upload_file2);
                $newSetting->favicon = $upload_file2;
            }
            $newSetting->save();

            Toastr::success('Settings have been added successfully :)','Success');
        }else{
            // dd($request->all());
            $setting->website_name   = trim($request->website_name);
            $setting->address    = trim($request->address);
            $setting->country       = trim($request->country);
            $setting->city       = trim($request->city);
            $setting->state       = trim($request->state);
            $setting->zip_code       = trim($request->zip_code);
            $setting->email       = trim($request->email);
            if(!empty($request->logo)) {
                $upload_file = rand() . '.' . $request->logo->extension();
                $request->logo->move(storage_path('app/public/setting/'), $upload_file);
                $setting->logo = $upload_file;
            }
            if(!empty($request->favicon)) {
                $upload_file2 = rand() . '.' . $request->favicon->extension();
                $request->favicon->move(storage_path('app/public/setting/'), $upload_file2);
                $setting->favicon = $upload_file2;
            }
            // if (!empty($request->logo)) {
            //     if(!empty($request->image_hidden)){
            //         unlink(storage_path('app/public/setting/'.$request->image_hidden));
            //     }
            //     $upload_file = rand() . '.' . $request->logo->extension();
            //     $request->logo->move(storage_path('app/public/setting/'), $upload_file);

            //     $setting->logo = $upload_file;
            // } else {
            //     $upload_file = $request->image_hidden;
            //     $setting->logo = $upload_file;
            // }
            // if (!empty($request->favicon)) {
            //     if(!empty($request->image_hidden)){
            //         unlink(storage_path('app/public/setting/'.$request->image_hidden));
            //     }
            //     $upload_file = rand() . '.' . $request->favicon->extension();
            //     $request->favicon->move(storage_path('app/public/setting/'), $upload_file);

            //     $setting->favicon = $upload_file;
            // } else {
            //     $upload_file = $request->image_hidden;
            //     $setting->favicon = $upload_file;
            // }

            $setting->save();

            Toastr::success('Settings have been updated successfully :)','Success');
        }


        return redirect()->back();
    }
    public function paymentUpdate(Request $request){
        $setting = SettingModel::getSingle();
        if (!$setting) {
            $newSetting = new SettingModel();
            $newSetting->paypal_email       = trim($request->paypal_email);
            $newSetting->stripe_key       = trim($request->stripe_key);
            $newSetting->stripe_secret       = trim($request->stripe_secret);

            $newSetting->save();

            Toastr::success('Settings have been added successfully :)','Success');
        }else{
            $setting->paypal_email       = trim($request->paypal_email);
            $setting->stripe_key       = trim($request->stripe_key);
            $setting->stripe_secret       = trim($request->stripe_secret);

            $setting->save();

            Toastr::success('Settings have been updated successfully :)','Success');
        }


        return redirect()->back();
    }
}
