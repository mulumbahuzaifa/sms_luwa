<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddFeesModel extends Model
{
    use HasFactory;
    protected $table = 'student_add_fees';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getFees($student_id){
        return self::select('student_add_fees.*', 'sm_classes.name as class_name', 'users.name as creator_name')
                ->join('sm_classes','sm_classes.id','=', 'student_add_fees.class_id')
                ->join('users','users.id','=', 'student_add_fees.created_by')
                ->where('student_add_fees.student_id', '=', $student_id)
                ->where('student_add_fees.is_payment', '=', 1)
                ->get();

    }
    static function getTotalFees($class_id){
        return SmClass::find($class_id)->fees_amount;
    }

    static public function getPaidFees($student_id, $class_id){
        return self::where('student_add_fees.class_id', '=', $class_id)
                ->where('student_add_fees.student_id', '=', $student_id)
                ->where('student_add_fees.is_payment', '=', 1)
                ->sum('student_add_fees.paid_amount');
    }
}
