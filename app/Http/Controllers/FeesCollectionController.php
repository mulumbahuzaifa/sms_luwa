<?php

namespace App\Http\Controllers;

use App\Models\SettingModel;
use App\Models\SmClass;
use App\Models\StudentAddFeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Stripe\Stripe;

class FeesCollectionController extends Controller
{
    public function collect_fees(Request $request){
        $data['getClass'] = SmClass::getClass();
        if (!empty($request->all())) {
            $data['getRecord'] = User::getCollectFeesStudent();
        }
        $data['header_title'] = "Collect Fees";
        return view('fees.collect_fees', $data);
    }

    public function collect_fees_add($student_id){
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $data['header_title'] = "Add Collect Fees";

        $data['getTotalFees'] = StudentAddFeesModel::getTotalFees($getStudent->class_id);
        $data['getPaidFees'] = StudentAddFeesModel::getPaidFees($student_id, $getStudent->class_id);
        return view('fees.add_collect_fees', $data);
    }

    public function collect_fees_insert($student_id, Request $request){
        // dd($request->all());
        $getStudent = User::getSingleClass($student_id);

        $getPaidFees = StudentAddFeesModel::getPaidFees($student_id, $getStudent->class_id);
        $remainingAmount = $getStudent->amount - $getPaidFees;
        if(!empty($request->amount)){

            if ( $remainingAmount >= $request->amount) {
                $remainingAmountUser = $remainingAmount - $request->amount;

                $payment = new StudentAddFeesModel();
                $payment->student_id = $request->student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remainingAmount;
                $payment->remaining_amount = $remainingAmountUser;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();


                Toastr::success('Fees Added Successfully', 'Success');
                return redirect()->back();

            }else{
                Toastr::error('Amount is greater than remaining amount', 'Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Amount has to be greater than 0', 'Error');
            return redirect()->back();
        }

    }

    //Student Fees
    public function collectFeesStudent(Request $request){
        $student_id = Auth::user()->id;

        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;


        $data['header_title'] = "Fees Collection ";

        $data['getTotalFees'] = StudentAddFeesModel::getTotalFees($getStudent->class_id);
        $data['getPaidFees'] = StudentAddFeesModel::getPaidFees($student_id, Auth::user()->class_id);
        return view('student.my_fees_collection', $data);
    }

    public function collectFeesStudentPayment(Request $request){
        $student_id = Auth::user()->id;
        $getStudent = User::getSingleClass($student_id);

        $getPaidFees = StudentAddFeesModel::getPaidFees($student_id, $getStudent->class_id);
        if (!empty($request->amount)) {
            $remainingAmount = $getStudent->amount - $getPaidFees;
            if ( $remainingAmount >= $request->amount) {
                $remainingAmountUser = $remainingAmount - $request->amount;

                $payment = new StudentAddFeesModel();
                $payment->student_id = $student_id;
                $payment->class_id = Auth::user()->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remainingAmount;
                $payment->remaining_amount = $remainingAmountUser;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                $getSetting = SettingModel::getSingle();

                if ($request->payment_type == 'Paypal') {
                    $query = array();
                    $query['business']      = $getSetting->paypal_email;
                    $query['cmd']           = '_xclick';
                    $query['item_name']     = "Student Fees";
                    $query['no_shipping']   = '1';
                    $query['item_number']   = $payment->id;
                    $query['amount']        = $request->amount;
                    $query['currency_code'] = 'USD';
                    $query['cancel_return'] = url('student/paypal/payment-error');
                    $query['return']        = url('student/paypal/payment-success');

                    $query_string = http_build_query($query);
                    // header('Location: https://www.paypal.com/cgi-bin/webscr?'.$query_string);
                    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?'.$query_string);
                    exit();
                }else if($request->payment_type == 'Stripe'){

                }

                Toastr::success('Fees Paid Successfully', 'Success');
                return redirect()->back();

            }else{
                Toastr::error('Amount is greater than remaining amount', 'Error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Amount has to be greater than 0', 'Error');
            return redirect()->back();
        }

    }

    public function paymentError(){
        Toastr::error('Failed due to some error, Please try again ', 'Error');
        return redirect('student/fees_collection');
    }

    public function paymentSuccess(Request $request){
        if(!empty($request->item_number) && !empty($request->st) && $request->st == "Completed"){
            $fees = StudentAddFeesModel::getSingle($request->item_number);
            if(!empty($fees)){
                $fees->is_payment = 1;
                $fees->payment_data = json_encode($request->all());
                $fees->save();

                Toastr::success('Fees Paid Successfully', 'Success');
                return redirect('student/fees_collection');
            }else{
                Toastr::error('Failed due to some error, Please try again ', 'Error');
                return redirect('student/fees_collection');
            }
        }else{
            Toastr::error('Failed due to some error, Please try again ', 'Error');
            return redirect('student/fees_collection');
        }
    }

}
