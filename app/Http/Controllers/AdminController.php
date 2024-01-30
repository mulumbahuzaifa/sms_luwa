<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
     /** add admin page */
     public function adminAdd()
     {
         return view('admin.add-admin');
     }

     /** admin list */
     public function adminList()
     {
         $data['listAdmin'] = User::listAdmin();
         $data['header_title'] = "admins List";
         return view('admin.list-admins',$data);
     }

     /** admin Grid */
     public function adminGrid()
     {
         // $adminGrid = admin::all();
         $data['adminGrid'] = User::listAdmin();
         $data['header_title'] = "admins Grid";
         return view('admin.admins-grid',$data);
     }

     /** save record */
     public function saveRecord(Request $request)
     {
         $request->validate([
             'name'       => 'required|string',
             'last_name'       => 'required|string',
             'email'           => 'required|email|unique:users',
             'password'        => 'required|string|min:8|confirmed',
             'password_confirmation' => 'required',
         ]);

         try {

             $admin = new User;
             $admin->name   = trim($request->name);
             $admin->last_name    = trim($request->last_name);
             $admin->gender       = trim($request->gender);
             if(!empty($request->date_of_birth)){
                 $admin->date_of_birth= trim($request->date_of_birth);
             }
             $admin->religion     = trim($request->religion);
             $admin->email        = trim($request->email);
             if(!empty($request->join_date)){
                 $admin->join_date= trim($request->join_date);
             }
             $admin->status = trim($request->status);
             $admin->marital_status = trim($request->marital_status);
             $admin->address = trim($request->address);
             $admin->current_address = trim($request->current_address);
             $admin->phone_number = trim($request->phone_number);
             $admin->qualification = trim($request->qualification);
             $admin->experience = trim($request->experience);
             $admin->note = trim($request->note);
             $admin->role_name = "Admin";
             $admin->position = "Admin";
             $admin->password = Hash::make($request->password);
             if(!empty($request->avatar)) {
                 $upload_file = rand() . '.' . $request->avatar->extension();
                 $request->avatar->move(storage_path('app/public/admin-photos/'), $upload_file);
                 $admin->avatar = $upload_file;
             }
             $admin->save();

             Toastr::success('Admin Has been add successfully :)','Success');
             return redirect()->back();
         } catch(\Exception $e) {
             \Log::info($e);
             DB::rollback();
             Toastr::error('fail, Add new record  :)','Error');
             return redirect()->back();
         }
     }

     /** edit record */
     public function editRecord($id)
     {
         $data['admin'] = User::getSingle($id);
         if(!empty($data['admin'])){
             $data['header_title'] = "Admin Edit";
             return view('admin.edit-admin',$data);
         }else{
             abort(404);
         }
     }

     /** update record admin */
     public function updateRecordAdmin(Request $request, $id)
     {
         $request->validate([
             'name'       => 'required|string',
             'last_name'       => 'required|string',
             'email'           => 'required|email|unique:users,email,'.$id,
         ]);
         DB::beginTransaction();
         try {
             $admin = User::getSingle($id);
             $admin->name   = trim($request->name);
             $admin->last_name    = trim($request->last_name);
             $admin->gender       = trim($request->gender);
             if(!empty($request->date_of_birth)){
                 $admin->date_of_birth= trim($request->date_of_birth);
             }
             $admin->religion     = trim($request->religion);
             $admin->email        = trim($request->email);
             $admin->marital_status        = trim($request->marital_status);
             if(!empty($request->join_date)){
                 $admin->join_date= trim($request->join_date);
             }

             $admin->address = trim($request->address);
             $admin->current_address = trim($request->current_address);
             $admin->phone_number = trim($request->phone_number);
            //  $admin->qualification = trim($request->qualification);
            //  $admin->experience = trim($request->experience);
            //  $admin->note = trim($request->note);
             $admin->status = trim($request->status);

             if (!empty($request->avatar)) {
                 if(!empty($request->image_hidden)){
                     unlink(storage_path('app/public/admin-photos/'.$request->image_hidden));
                 }
                 $upload_file = rand() . '.' . $request->avatar->extension();
                 $request->avatar->move(storage_path('app/public/admin-photos/'), $upload_file);

                 $admin->avatar = $upload_file;
             } else {
                 $upload_file = $request->image_hidden;
                 $admin->avatar = $upload_file;
             }
             $admin->save();

             Toastr::success('Has been update successfully :)','Success');
             DB::commit();
             return redirect()->back();

         } catch(\Exception $e) {
             DB::rollback();
             Toastr::error('fail, update record  :)','Error');
             return redirect()->back();
         }
     }

     /** delete record */
     public function adminDelete(Request $request, $id)
     {
         DB::beginTransaction();
         try {
             $getRecord = User::getSingle($id);

             if (!empty($getRecord)) {
                 unlink(storage_path('app/public/admin-photos/'.$getRecord->avatar));
                 $getRecord->delete();
                 DB::commit();
                 Toastr::success('Student deleted successfully :)','Success');
                 return redirect()->back();
             } else {
                 Toastr::error('Student deleted fail, try again :)','Error');
                 return redirect()->back();
             }

         } catch(\Exception $e) {
             DB::rollback();
             Toastr::error('Deleted record fail :)','Error');
             return redirect()->back();
         }
     }
}
