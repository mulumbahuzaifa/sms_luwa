<?php

namespace App\Http\Controllers;

use DB;
use App\Models\SmParent;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ParentController extends Controller
{
    /** index page parent list */
    public function parentList()
    {
        $parentList = SmParent::orderBy('id', 'desc')->paginate(12);;
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

            $parent = new SmParent();
            $parent->first_name   = $request->first_name;
            $parent->last_name    = $request->last_name;
            $parent->address       = $request->address;
            $parent->email        = $request->email;
            $parent->phone_number = $request->phone_number;
            $parent->save();

            Toastr::success('Has been add successfully :)','Success');
            DB::commit();

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
        $parentEdit = SmParent::where('id',$id)->first();
        return view('parent.edit-parent',compact('parentEdit'));
    }

    /** update record */
    public function parentUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'address' => 'required|string',
            'email'         => 'required|email',
            'phone_number'  => 'required',
        ]);
        // Find the class by ID
        $parent = SmParent::find($id);

        if (!$parent) {
            Toastr::error('fail, parent not found. :)','Error');
            return redirect()->back();
        }
        // Update parent attributes

        $parent->first_name = $request->input('first_name');
        $parent->last_name = $request->input('last_name');
        $parent->email = $request->input('email');
        $parent->address = $request->input('address');
        $parent->phone_number = $request->input('phone_number');


        // Save the updated parent
        $parent->save();
        Toastr::success('Has been update successfully :)','Success');
        return redirect()->back();
    }

    /** parent delete */
    public function parentDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->id)) {
                SmParent::destroy($request->id);
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
        $parentProfile = SmParent::where('id',$id)->first();
        return view('parent.parent-profile',compact('parentProfile'));
    }
}
