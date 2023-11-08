<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Department;
use Brian2694\Toastr\Facades\Toastr;

class DepartmentController extends Controller
{
    /** index page department */
    public function indexDepartment()
    {

        return view('department.add-department');
    }

    /** Parent save record */
    public function departmentSave(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'category' => 'required|string',
            'date_created' => 'required|date', // Assuming date_created is a date field
            // Add more validation rules as needed
        ]);

        DB::beginTransaction();
        try {
            $department = new Department;
            $department->name = $request->name;
            $department->code = $request->code;
            $department->description = $request->description;
            $department->category = $request->category;
            $department->HOD = $request->HOD;

            // Format the date to 'YYYY-MM-DD' format
            $department->date_created = Carbon::createFromFormat('d-m-Y', $request->date_created)->format('Y-m-d');

            $department->save();

            Toastr::success('Department has been added successfully.', 'Success');
            DB::commit();

            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add new Department.', 'Error');
            return redirect()->back();
        }
    }
    /** edit record */
    public function editDepartment($id)
    {
        $departmentEdit = Department::where('id',$id)->first();
        return view('department.edit-department', compact('departmentEdit'));
    }

    /** update record */
    public function departmentUpdate(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string',
        'code' => 'required|string',
        'category' => 'required|string',
        'date_created' => 'required', // Assuming date_created is a date field
        // Add more validation rules as needed
    ]);
    // Find the department by ID
    $department = Department::find($id);

    if (!$department) {
        Toastr::error('fail, Department not found. :)','Error');
        return redirect()->back();
    }

    // Update department attributes
    $department->name = $request->input('name');
    $department->code = $request->input('code');
    $department->category = $request->input('category');
    $department->HOD = $request->input('HOD');
    $department->date_created = \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('date_created'))->format('Y-m-d');

    // Save the updated department
    $department->save();
    Toastr::success('Has been update successfully :)','Success');
    return redirect()->back();

    }

       /** student delete */
    public function departmentDelete($id)
    {
        DB::beginTransaction();
        try {

            // Find the department by ID
            $department = Department::find($id);

            if (!$department) {
                Toastr::error('Department not found.', 'Error');
                return redirect()->back();
            }

            // Delete the department
            $department->delete();

            Toastr::success('Department has been deleted successfully.', 'Success');
            DB::commit();
            return redirect()->back();



        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Department deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** department list */
    public function departmentList()
    {
        $departments = Department::orderBy('name', 'asc')->paginate(12);
        return view('department.list-department', ['departments' => $departments]);
    }
}
