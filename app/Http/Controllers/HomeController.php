<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Models\User;
use App\Models\Role;
use App\Models\Logs;

use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    protected $request;

    public function __construct(Request $request) {
        // $this->middleware('role:staff');
        $this->request = $request;
        date_default_timezone_set('Asia/Dubai');
    }
   
    public function login() {

        if (auth()->check()) {
            $user = Auth()->user();

            if($user->hasRole('admin')) {
                $url = route('admin.home');
            } 

            if ($user->hasRole('employee')) {
                $url = route('staff.home');
            }

            if($user->hasRole('client')) {
                $url = route('client.index');
            } 
            return redirect($url);
        }
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

                $userAgent = $_SERVER['HTTP_USER_AGENT'];

                 $deviceInfo = [
                    'Operating System' => $this->getOS($userAgent),
                    'Browser' => $this->getBrowser($userAgent),
                    'Device Type' => $this->getDeviceType($userAgent)
                ];

                $logs = new Logs;
                $logs->user_id = Auth()->user()->id;
                $logs->date = date('Y-m-d');
                $logs->login = date('H:i:s');
                $logs->logout = '';
                $logs->device = json_encode($deviceInfo);
                $logs->ip_address = $this->getClientIP();
                $logs->save();  

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

        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        $deviceInfo = [
            'Operating System' => $this->getOS($userAgent),
            'Browser' => $this->getBrowser($userAgent),
            'Device Type' => $this->getDeviceType($userAgent)
        ];

        $logs = new Logs;
        $logs->user_id = Auth()->user()->id;
        $logs->date = date('Y-m-d');
        $logs->login = '';
        $logs->logout = date('H:i:s');
        $logs->device = json_encode($deviceInfo);
        $logs->ip_address = $this->getClientIP();

        if ($logs->save()) {
            Auth::logout();
            return redirect(route('home.login'));
        }

    }


    public static function quickRandom($length = 16) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    function getDevice() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
        // Basic device info
        // $deviceInfo = [
        //     'Operating System' => getOS($userAgent),
        //     'Browser' => getBrowser($userAgent),
        //     'Device Type' => getDeviceType($userAgent)
        // ];
    
        // return $deviceInfo;
    }
    
    function getOS($userAgent) {
        $osArray = [
            '/windows nt 10/i'      => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile'
        ];
    
        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                return $value;
            }
        }
    
        return 'Unknown OS';
    }
    
    function getBrowser($userAgent) {
        $browserArray = [
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        ];
    
        foreach ($browserArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                return $value;
            }
        }
    
        return 'Unknown Browser';
    }
    
    function getDeviceType($userAgent) {
        if (preg_match('/mobile/i', $userAgent)) {
            return 'Mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }


    function getClientIP() {
        $ipAddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check IP from shared internet
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check IP passed from proxy
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Check IP address from remote address
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
    }

}
