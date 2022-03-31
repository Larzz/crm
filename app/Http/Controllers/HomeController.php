<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Role;

use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    protected $request;

    public function __construct(Request $request) {
        // $this->middleware('role:staff');
        $this->request = $request;
    }
   
    public function login() {
        return view('public.pages.login');
    }

    public function register() {
        return view('public.pages.register');
    }

    public function submit_login() {

        $status = false;
        
        $this->request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $this->request->email)->first();

        if(!$user) {

            $response = ['status' => 'false', 'message' => 'User not Found'];
            return Response()->json($response, 404);

        } else {

            $credentials = $this->request->only('email', 'password');

            if (Auth::attempt($credentials)) {

                $url = '';

                if($user->hasRole('admin')) {
                    $url = route('admin.home');
                } 

                if ($user->hasRole('employee')) {
                    $url = route('staff.home');
                }

                if($user->hasRole('client')) {
                    $url = route('client.index');
                } 

                $response = ['status' => 'true', 'redirect_url' => $url];
                return Response()->json($response, 200);
            }

        }

        $response = ['status' => $status];
        return Response()->json($response, 200);

    }

    public function submit_register() {

        $user = New User;
        $user->name = $this->request->fullname;
        $user->email = $this->request->email;
        $user->password = Hash::make($this->request->password);
        $user->role = $this->request->role;
      
        if($user->save()) {
     
            switch ($this->request->role) {

                case "1":
                    $user->attachRole('admin');
                break;

                case "2":
                     $user->attachRole('employee');
                break;

                case "3":
                    $user->attachRole('client');
                break;
             
            }

            $status = true;

        }

        $response = array('status' => $status);
        return Response()->json($response);

    }

    public function reset_password() {

        $user = User::where('email', $this->request->email)->first();

        if($user) {
            
            $reset_code = $this->quickRandom();
            $user->reset_code = $reset_code;
            
            if ($user->save()) {
                Mail::to($user->email)->send(New ForgotPassword($user, $reset_code, 'Request a Reset Password: Creativo Backend'));
                return response()->json(['status' => true, 'msg' => 'Successfully sent a message.']);
            }

            return response()->json(['status' => false, 'msg' => 'Something went wrong, please try again.']);
        }
        return response()->json(['status' => false, 'msg' => 'The email is not associated with any account.']);
    }

    public function reset_password_view($code) {

        $user = User::where('reset_code', $code)->first();

        if($user) {
            return view('public.pages.reset_password', ['user' => $user]);
        }

        abort(404);
    }

    public function change_password() {

        $user = User::where('email', $this->request->email)->where('reset_code', $this->request->code)->first();

        if($user) {

            $user->reset_code = null;
            $user->password = Hash::make($this->request->password);
            if($user->save()) {
                return response()->json(['status' => true, 'msg' => 'Successfully reset your password!']);
            }
        }

        return response()->json(['status' => false, 'msg' => 'Unable to find the user. if you believe this is mistake. kindly contact us.']);
    }

    public function logout() {
        Auth::logout();
        return redirect(route('home.login'));
    }


    public static function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

}
