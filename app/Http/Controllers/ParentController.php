<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Parent;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ParentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $parentList = Parent::all();
        return view('parent.parent',compact('parentList'));
    }

    /** parent add page */
    public function parentAdd()
    {
        return view('parent.add-parent');
    }

    /** parent save record */
    public function parentSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'address' => 'required|string',
            'email'         => 'required|email',
            'phone_number'  => 'required',
        ]);

        DB::beginTransaction();
        try {

            $upload_file = rand() . '.' . $request->upload->extension();
            $request->upload->move(storage_path('app/public/parent-photos/'), $upload_file);
            if(!empty($request->upload)) {
                $parent = new Parent;
                $parent->first_name   = $request->first_name;
                $parent->last_name    = $request->last_name;
                $parent->address       = $request->gender;
                $parent->email        = $request->email;
                $parent->phone_number = $request->phone_number;
                $parent->save();

                Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            }

            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new parent  :)','Error');
            return redirect()->back();
        }
    }

    /** view for edit parent */
    public function parentEdit($id)
    {
        $parentEdit = Parent::where('id',$id)->first();
        return view('parent.edit-parent',compact('parentEdit'));
    }

    /** update record */
    public function parentUpdate(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->upload)) {
                unlink(storage_path('app/public/parent-photos/'.$request->image_hidden));
                $upload_file = rand() . '.' . $request->upload->extension();
                $request->upload->move(storage_path('app/public/parent-photos/'), $upload_file);
            } else {
                $upload_file = $request->image_hidden;
            }

            $updateRecord = [
                'upload' => $upload_file,
            ];
            Parent::where('id',$request->id)->update($updateRecord);

            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update parent  :)','Error');
            return redirect()->back();
        }
    }

    /** parent delete */
    public function parentDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->id)) {
                Parent::destroy($request->id);
                // unlink(storage_path('app/public/parent-photos/'.$request->avatar));
                DB::commit();
                Toastr::success('parent deleted successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('parent deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** parent profile page */
    public function parentProfile($id)
    {
        $parentProfile = Parent::where('id',$id)->first();
        return view('parent.parent-profile',compact('parentProfile'));
    }
}
