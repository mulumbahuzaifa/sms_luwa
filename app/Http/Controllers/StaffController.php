<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Staff;
use Brian2694\Toastr\Facades\Toastr;

class StaffController extends Controller
{
     /** Staffs list */
     public function staffList()
     {
         $staffs = Staff::orderBy('id', 'desc')->paginate(12);
         return view('staff.list-staff', ['staffs' => $staffs]);
     }

     /** staff add */
    public function addStaff()
    {
        $departments = Department::all();
        return view('staff.add-staff', ['departments' => $departments]);
    }

    /** Parent save record */
    public function staffSave(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'email' => 'required|email',
            'employee_id' => 'required|string',
            'qualifications' => 'required',
            'role' => 'required',
            'address' => 'required',
            'department_id' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required|date', // Assuming date_created is a date field
            'joining_date' => 'date', // Assuming date_created is a date field
            // Add more validation rules as needed
        ]);

        DB::beginTransaction();
        try {
            $staff = new Staff();
            $staff->first_name = $request->first_name;
            $staff->last_name = $request->last_name;
            $staff->gender = $request->gender;
            $staff->phone_number = $request->phone_number;
            $staff->email = $request->email;
            $staff->address = $request->address;
            $staff->role = $request->role;
            $staff->employee_id = $request->employee_id;
            $staff->salary = $request->salary;
            $staff->qualifications	 = $request->qualifications	;
            $staff->department_id	 = $request->department_id	;

            // Format the date to 'YYYY-MM-DD' format
            $staff->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
            $staff->joining_date = Carbon::createFromFormat('d-m-Y', $request->joining_date)->format('Y-m-d');

            $staff->save();

            Toastr::success('Staff has been added successfully.', 'Success');
            DB::commit();

            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add new Staff.', 'Error');
            return redirect()->back();
        }
    }
    /** edit record */
    public function editStaff($id)
    {
        $staffEdit = Staff::where('id',$id)->first();
        $departments = Department::all();
        return view('staff.edit-staff', ['departments' => $departments, 'staffEdit' => $staffEdit]);
    }

    /** update record */
    public function staffUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'email' => 'required|email',
            'employee_id' => 'required|string',
            'qualifications' => 'required',
            'role' => 'required',
            'address' => 'required',
            'department_id' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required|date', // Assuming date_created is a date field
            // Add more validation rules as needed
        ]);
        // dd($request->all());
        // Find the staff by ID
        $staff = Staff::find($id);

        if (!$staff) {
            Toastr::error('fail, staff not found. :)','Error');
            return redirect()->back();
        }
        // Update staff attributes

        $staff->first_name = $request->input('first_name');
        $staff->last_name = $request->input('last_name');
        $staff->gender = $request->input('gender');
        $staff->phone_number = $request->input('phone_number');
        $staff->email = $request->input('email');
        $staff->address = $request->input('address');
        $staff->role = $request->input('role');
        $staff->employee_id = $request->input('employee_id');
        $staff->salary = $request->input('salary');
        $staff->qualifications = $request->input('qualifications');
        $staff->department_id = $request->input('department_id');
        $staff->date_of_birth = \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');
        $staff->joining_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('joining_date'))->format('Y-m-d');

        // Save the updated staff
        $staff->save();
        Toastr::success('Has been update successfully :)','Success');
        return redirect()->back();

    }

       /** student delete */
    public function staffDelete($id)
    {
        DB::beginTransaction();
        try {

            // Find the department by ID
            $staff = Staff::find($id);

            if (!$staff) {
                Toastr::error('staff not found.', 'Error');
                return redirect()->back();
            }

            // Delete the staff
            $staff->delete();

            Toastr::success('Staff has been deleted successfully.', 'Success');
            DB::commit();
            return redirect()->back();



        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Staff deleted fail :)','Error');
            return redirect()->back();
        }
    }

}
