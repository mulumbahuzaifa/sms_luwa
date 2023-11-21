<?php

namespace App\Http\Controllers;

use App\Models\ExamModel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    public function examList()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = "Exam List";
        return view('examinations.exam.list', $data);
    }

    public function addExam()
    {
        $data['header_title'] = "Add Exam";
        return view('examinations.exam.add', $data);
    }

    public function saveExam(Request $request){
        $exam = new ExamModel();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = auth()->user()->id;
        $exam->created_at = date('Y-m-d H:i:s');
        $exam->save();

        Toastr::success('Exam added successfully :)','Success');
        return redirect()->route('exam.list')->with('success', 'Exam added successfully!');
    }

    public function editExam($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Exam";
            return view('examinations.exam.edit', $data);
        } else {
            Toastr::error('Exam not found :(', 'Error');
            return redirect()->route('exam.list')->with('error', 'Exam not found!');
        }

    }

    public function examUpdate($id, Request $request){
        $exam = ExamModel::getSingle($id);
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        // $exam->updated_by = auth()->user()->id;
        $exam->updated_at = date('Y-m-d H:i:s');
        $exam->save();

        Toastr::success('Exam updated successfully :)','Success');
        return redirect()->route('exam.list')->with('success', 'Exam updated successfully!');
    }

    public function examDelete($id){
        $exam = ExamModel::getSingle($id);
        if(!empty($exam)){
            $exam->is_deleted = 1;
            $exam->save();
            // $exam->delete();
            Toastr::success('Exam deleted successfully :)','Success');
            return redirect()->route('exam.list')->with('success', 'Exam deleted successfully!');
        }else{
            Toastr::error('Exam not found :(', 'Error');
            return redirect()->route('exam.list')->with('error', 'Exam not found!');
        }

    }
}
