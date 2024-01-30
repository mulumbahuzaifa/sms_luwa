<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'join_date',
        'phone_number',
        'status',
        'role_name',
        'email',
        'avatar',
        'position',
        'department',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getSingleClass($id){
        return self::select('users.*', 'sm_classes.amount', 'sm_classes.name as class_name')
                    ->join('sm_classes', 'sm_classes.id','=', 'users.class_id')
                    ->where('users.id','=', $id)
                    ->first();
    }

    static public function getEmailSingle($email){
        return User::where('email', '=', $email)->first();
    }

    static public function getTokenSingle($remember_token){
        return User::where('remember_token', '=', $remember_token)->first();
    }

    static public function SearchUsers($search){
        $return = self::select('users.*');
        $return = $return->where(function($query) use ($search){
            $query->where('users.name', 'like', '%'.$search.'%')
            ->orWhere('users.last_name', 'like', '%'.$search.'%');
        });
        $return = $return->orderBy('users.id', 'desc')
            ->limit(10)
            ->get();
        return $return;
    }

    static public function listAdmin(){
        $return = self::select('users.*')
        ->where('users.role_name', '=', 'Admin')
        ->orWhere('users.role_name', '=','Super Admin')
        ->where('is_deleted', '=', 0);
        if(!empty(Request::get('name'))){
            $return = $return->where('users.name', 'like', '%'.Request::get('name').'%')->orWhere('last_name', 'LIKE', '%'.Request::get('name')."%");
        }
        if(!empty(Request::get('email'))){
            $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
        }
        if(!empty(Request::get('religion'))){
            $return = $return->where('users.religion', 'like', '%'.Request::get('religion').'%');
        }
        if(!empty(Request::get('phone_number'))){
            $return = $return->where('users.phone_number', 'like', '%'.Request::get('phone_number').'%');
        }
        if(!empty(Request::get('gender'))){
            $return = $return->where('users.gender', '=', Request::get('gender'));
        }

    $return = $return->orderBy('users.id', 'desc')
        ->paginate(20);

    return $return;

    }
    static public function studentList(){
        $return = self::select('users.*', 'sm_classes.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
        ->join('users as parent','parent.id', '=', 'users.parent_id' , 'left')
        ->join('sm_classes', 'sm_classes.id', '=', 'users.class_id')
            ->where('users.role_name', '=', 'Student');
            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%')->orWhere('last_name', 'LIKE', '%'.Request::get('name')."%");
            }
            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }
            if(!empty(Request::get('admission_number'))){
                $return = $return->where('users.admission_number', 'like', '%'.Request::get('admission_number').'%');
            }
            if(!empty(Request::get('roll_number'))){
                $return = $return->where('users.roll_number', 'like', '%'.Request::get('roll_number').'%');
            }
            if(!empty(Request::get('religion'))){
                $return = $return->where('users.religion', 'like', '%'.Request::get('religion').'%');
            }
            if(!empty(Request::get('class'))){
                $return = $return->where('sm_classes.name.', 'like', '%'.Request::get('class').'%');
            }
            if(!empty(Request::get('caste'))){
                $return = $return->where('users.caste', 'like', '%'.Request::get('caste').'%');
            }
            if(!empty(Request::get('phone_number'))){
                $return = $return->where('users.phone_number', 'like', '%'.Request::get('phone_number').'%');
            }
            if(!empty(Request::get('gender'))){
                $return = $return->where('users.gender', '=', Request::get('gender'));
            }
            if(!empty(Request::get('date'))){
                $return = $return->where('users.admission_date', '=', Request::get('date'));
            }
        $return = $return->orderBy('users.id', 'desc')
            ->paginate(20);

        return $return;

    }
    static public function getCollectFeesStudent(){
        $return = self::select('users.*', 'sm_classes.name as class_name','sm_classes.id as class_id', 'sm_classes.amount')
            ->join('sm_classes', 'sm_classes.id', '=', 'users.class_id')
            ->where('users.role_name', '=', 'Student');
            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%');
            }
            if(!empty(Request::get('last_name'))){
                $return = $return->where('users.last_name', 'like', '%'.Request::get('last_name').'%');
            }

            if(!empty(Request::get('class_id'))){
                $return = $return->where('sm_classes.id', 'like', '%'.Request::get('class_id').'%');
            }

        $return = $return->orderBy('users.name', 'asc')
            ->paginate(20);

        return $return;

    }

    static public function getPaidAmount($student_id, $class_id){
        return StudentAddFeesModel::getPaidFees($student_id, $class_id);
    }

    static public function getStudentClass($class_id){
        return self::select('users.id', 'users.name', 'users.last_name')
            ->where('users.role_name', '=', 'Student')
            ->where('users.class_id', '=', $class_id)
            ->orderBy('users.id', 'desc')
            ->get();

    }

    static public function getUser($user_type){
        return self::select('users.*')
            ->where('users.role_name', '=', $user_type)
            ->where('users.is_deleted', '=', 0)
            ->get();
    }

    static public function listTeacher(){
        $return = self::select('users.*')
            ->where('users.role_name', '=', 'Teacher')
            ->where('is_deleted', '=', 0);
            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%')->orWhere('last_name', 'LIKE', '%'.Request::get('name')."%");
            }
            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }
            if(!empty(Request::get('religion'))){
                $return = $return->where('users.religion', 'like', '%'.Request::get('religion').'%');
            }
            if(!empty(Request::get('phone_number'))){
                $return = $return->where('users.phone_number', 'like', '%'.Request::get('phone_number').'%');
            }
            if(!empty(Request::get('gender'))){
                $return = $return->where('users.gender', '=', Request::get('gender'));
            }
            if(!empty(Request::get('date'))){
                $return = $return->where('users.admission_date', '=', Request::get('date'));
            }
        $return = $return->orderBy('users.id', 'desc')
            ->paginate(20);

        return $return;

    }
    static public function getTeacher(){
        $return = self::select('users.*')
            ->where('users.role_name', '=', 'Teacher')
            ->where('is_deleted', '=', 0);

        $return = $return->orderBy('users.id', 'desc')
            ->get();

        return $return;

    }
    static public function getStudents(){
        $return = self::select('users.*')
            ->where('users.role_name', '=', 'Student')
            ->where('is_deleted', '=', 0);

        $return = $return->orderBy('users.id', 'desc')
            ->get();

        return $return;

    }
    static public function getParent(){
        $return = self::select('users.*')
            ->where('users.role_name', '=', 'Parent')
            ->where('is_deleted', '=', 0);

        $return = $return->orderBy('users.id', 'desc')
            ->get();

        return $return;

    }

    static public function parentList() {
        $return = self::select('users.*')
                        ->where('role_name', '=', 'Parent')
                        ->where('is_deleted', '=', 0);
                        if(!empty(Request::get('name'))){
                            $return = $return->where('users.name', 'like', '%'.Request::get('name').'%')->orWhere('last_name', 'LIKE', '%'.Request::get('name')."%");
                        }
                        if(!empty(Request::get('email'))){
                            $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
                        }
                        if(!empty(Request::get('gender'))){
                            $return = $return->where('users.gender', '=', Request::get('gender'));
                        }
                        if(!empty(Request::get('phone_number'))){
                            $return = $return->where('users.phone_number', 'like', '%'.Request::get('phone_number').'%');
                        }
                        if(!empty(Request::get('occupation'))){
                            $return = $return->where('users.occupation', 'like', '%'.Request::get('occupation').'%');
                        }
                        if(!empty(Request::get('address'))){
                            $return = $return->where('users.address', 'like', '%'.Request::get('address').'%');
                        }
        $return = $return->orderBy('id', 'asc')
        ->paginate(20);

        return $return;
    }

    static public function getSearchStudent(){
        if(!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('email'))){
            $return = self::select('users.*', 'sm_classes.name as class_name', 'parent.name as parent_name')
                ->join('users as parent','parent.id', '=', 'users.parent_id' , 'left')
                ->join('sm_classes', 'sm_classes.id', '=', 'users.class_id', 'left')
                ->where('users.role_name', '=', 'Student');
            if(!empty(Request::get('id'))){
                $return = $return->where('users.id', '=', Request::get('id'));
            }
            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%')->orWhere('last_name', 'LIKE', '%'.Request::get('name')."%");
            }
            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }

        $return = $return->orderBy('users.id', 'asc')
            ->limit(10)
            ->get();
        return $return;
        }
    }

    static public function getMyStudent($parent_id){
        if(!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('email'))){
            $return = self::select('users.*', 'sm_classes.name as class_name', 'parent.name as parent_name')
                ->join('users as parent','parent.id', '=', 'users.parent_id' , 'left')
                ->join('sm_classes', 'sm_classes.id', '=', 'users.class_id', 'left')
                ->where('users.role_name', '=', 'Student')
                ->where('users.parent_id', '=', $parent_id)
                ->orderBy('users.id', 'desc')
                ->get();
        return $return;
        }
    }

    static public function getTeacherStudent($teacher_id){
        $return = self::select('users.*', 'sm_classes.name as class_name')
        ->join('sm_classes', 'sm_classes.id', '=', 'users.class_id')
        ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'sm_classes.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('users.role_name', '=', 'Student');
            if(!empty(Request::get('name'))){
                $return = $return->where('users.name', 'like', '%'.Request::get('name').'%')->orWhere('last_name', 'LIKE', '%'.Request::get('name')."%");
            }
            if(!empty(Request::get('email'))){
                $return = $return->where('users.email', 'like', '%'.Request::get('email').'%');
            }
            if(!empty(Request::get('admission_number'))){
                $return = $return->where('users.admission_number', 'like', '%'.Request::get('admission_number').'%');
            }
            if(!empty(Request::get('roll_number'))){
                $return = $return->where('users.roll_number', 'like', '%'.Request::get('roll_number').'%');
            }
            if(!empty(Request::get('religion'))){
                $return = $return->where('users.religion', 'like', '%'.Request::get('religion').'%');
            }
            if(!empty(Request::get('class'))){
                $return = $return->where('sm_classes.name.', 'like', '%'.Request::get('class').'%');
            }
            if(!empty(Request::get('gender'))){
                $return = $return->where('users.gender', '=', Request::get('gender'));
            }
            if(!empty(Request::get('date'))){
                $return = $return->where('users.admission_date', '=', Request::get('date'));
            }
        $return = $return->orderBy('users.id', 'desc')
            ->groupBy('users.id')
            ->paginate(20);

        return $return;

    }
    static public function getTeacherStudentCount($teacher_id){
        $return = self::select('users.id')
        ->join('sm_classes', 'sm_classes.id', '=', 'users.class_id')
        ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'sm_classes.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('users.role_name', '=', 'Student')
            ->orderBy('users.id', 'desc')
            ->groupBy('users.id')
            ->count();

        return $return;

    }

    static public function getAttendance($student_id, $class_id,$attendance_date){
        return StudentAttendanceModel::CheckAlreadyAttendance($student_id, $class_id,$attendance_date);
    }
}
