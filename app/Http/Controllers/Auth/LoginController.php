<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Rules\MatchOldPassword;
use App\Mail\ForgotPasswordMail;
use Mail;
use Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
    * Where to redirect users after login.
    *
    * @var string
    */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }
    /** index page login */
    public function login()
    {
        return view('auth.login');
    }

    /** login with databases */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            $email     = $request->email;
            $password  = $request->password;

            if (Auth::attempt(['email'=>$email,'password'=>$password])) {
                /** get session */
                $user = Auth::User();
                Session::put('name', $user->name);
                Session::put('email', $user->email);
                Session::put('user_id', $user->user_id);
                Session::put('join_date', $user->join_date);
                Session::put('phone_number', $user->phone_number);
                Session::put('status', $user->status);
                Session::put('role_name', $user->role_name);
                Session::put('avatar', $user->avatar);
                Session::put('position', $user->position);
                Session::put('department', $user->department);
                Toastr::success('Login successfully :)','Success');

                if ($user->role_name == 'Admin') {
                    return redirect()->intended('home');
                }else if($user->role_name == 'Super Admin'){
                    return redirect()->intended('home');
                }else if($user->role_name == 'Student'){
                    return redirect()->intended('student/dashboard');
                }else if($user->role_name == 'Teacher'){
                    return redirect()->intended('teacher/dashboard');
                }else if($user->role_name == 'Parent'){
                    return redirect()->intended('parent/dashboard');
                }
            } else {

                Toastr::error('fail, WRONG USERNAME OR PASSWORD :)','Error');

                return redirect('login');
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, LOGIN :)','Error');
            return redirect()->back();
        }
    }

    public function forgotPassword(){
        return view('auth.forgot-password');
    }

    public function postForgotPassword(Request $request){
        $user = User::getEmailSingle($request->email);
        if(!empty($user)){
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', "Please check your email and reset your password");
        }else{
            return redirect()->back()->with('error', "Email not found in the system");
        }
    }


    /** logout */
    public function logout( Request $request)
    {
        Auth::logout();
        // forget login session
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('user_id');
        $request->session()->forget('join_date');
        $request->session()->forget('phone_number');
        $request->session()->forget('status');
        $request->session()->forget('role_name');
        $request->session()->forget('avatar');
        $request->session()->forget('position');
        $request->session()->forget('department');
        $request->session()->flush();

        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }

}
