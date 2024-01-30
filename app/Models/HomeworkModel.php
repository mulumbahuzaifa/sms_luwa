<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class HomeworkModel extends Model
{
    use HasFactory;

    protected $table = 'homework';

    static public function getRecord(){
        $return = HomeworkModel::select('homework.*', 'sm_classes.name as class_name', 'subjects.name as subject_name', 'users.name as created_by_name','users.last_name as created_by_last_name')
            ->join('users', 'users.id', '=', 'homework.created_by')
            ->join('sm_classes', 'sm_classes.id', '=', 'homework.class_id')
            ->join('subjects', 'subjects.id', '=', 'homework.subject_id')
            ->where('homework.is_deleted', '=', 0);
            if(!empty(Request::get('class_name'))){
                $return = $return->where('sm_classes.name', 'like', '%'.trim(Request::get('class_name')).'%');
            }
            if(!empty(Request::get('subject_name'))){
                $return = $return->where('subjects.name', 'like', '%'.trim(Request::get('subject_name')).'%');
            }
            if(!empty(Request::get('homework_date_from'))){
                $return = $return->where('notice_board.homework_date', '>=', '%'.Request::get('homework_date_from').'%');
            }
            if(!empty(Request::get('homework_date_to'))){
                $return = $return->where('notice_board.homework_date', '<=', '%'.Request::get('homework_date_to').'%');
            }
            if(!empty(Request::get('submission_date_from'))){
                $return = $return->where('notice_board.submission_date', '>=', '%'.Request::get('submission_date_from').'%');
            }
            if(!empty(Request::get('submission_date_to'))){
                $return = $return->where('notice_board.submission_date', '<=', '%'.Request::get('submission_date_to').'%');
            }
        $return = $return->orderBy('homework.id', 'DESC')
            ->paginate(20);
        return $return;
    }

    static public function getSingle($id){
        return self::find($id);
    }

}
