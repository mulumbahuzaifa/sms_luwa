<?php

namespace App\Models;

use Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamModel extends Model
{
    use HasFactory;
    protected $table = 'exams';

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = self::select('exams.*', 'users.name as created_by')
            ->join('users', 'users.id', '=' , 'exams.created_by');
            if(!empty(Request::get('name'))){
                $return = $return->where('exams.name', 'like', '%' . Request::get('name') . '%');
            }
        $return = $return->where('exams.is_deleted','=', 0)
            ->orderBy('exams.id', 'desc')
            ->paginate(50);

        return $return;
    }
}
