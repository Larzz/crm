<?php

namespace App\Http\Controllers\API\v1\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Leave;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Mail\EmployeeMail;
use Illuminate\Support\Facades\Mail;
class EmployeeController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function addEmployee() { 

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'position' => 'required',
            'date_joined' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }
    
        $user = new User;

        $token = Str::random(60);

        $user->name = $this->request->name;
        $user->email = $this->request->email;
        $user->password = Hash::make($this->request->password);
        $user->role = 2; //employee
        $user->position = $this->request->position;
        $user->date_joined = $this->request->date_joined;
        $user->birth_date = $this->request->birth_date;
        $user->mobile_number = $this->request->mobile_number;
        $user->annual_leave = $this->request->number_of_days;
        $user->sick_leave = $this->request->number_of_sick_days;
        $user->api_token = hash('sha256', $token);
        $user->notes = $this->request->notes;

        if($user->save()) {

            $user->attachRole('employee');
            // assign leave
            $leave = new Leave;
            $leave->year = date('Y');
            $leave->available_days = $this->request->number_of_days;
            $leave->used_days = 0;
            $leave->is_forfeited = false;
            $leave->user_id = $user->id;

            if($leave->save()) {
                Mail::to($user->email)->send(New EmployeeMail($user, $leave, $this->request->password, 'Employee Creation Notification'));
                // Mail::to('larry@creativouae.com')->send(New EmployeeMail($user, $leave, $this->request->password, 'Employee Creation Confirmation'));
                return response()->json(['status' => true], 201);
            }
        }

        return response()->json(['status' => false], 502);
    }


    public function getEmployees() {
        return response()->json(['employees' => User::where('role', 2)->orderBy('created_at', 'desc')->get()], 200);
    }


    public function getEmployee($employee_id) {

        $employee = User::where('id', $employee_id)->first();
        if($employee) {
            return response()->json(['status' => true, 'employee' => $employee]);
        }
        return response()->json(['status' => false], 404);

    }


    public function editEmployee($employee_id) {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'password' => 'required|min:6|max:255',
            'position' => 'required',
            'date_joined' => 'required'
        ]);

        $employee = User::where('id', $employee_id)->first();

        if ($employee) {
            
            $employee->name = $this->request->name;
            $employee->password = $this->request->password;
            $employee->position = $this->request->position;
            $employee->date_joined = $this->request->date_joined;
            $employee->annual_leave = $this->request->annual_leave;
            $employee->sick_leave = $this->request->sick_leave;

            if($employee->save()) {
                return response()->json(['status' => true, 'employee' => $employee]);
            }

            return response()->json(['status' => false], 500);
        }

        return response()->json(['status' => false], 200);
    }

    public function deleteEmployee($employee_id) {

        $employee = User::where('id', $employee_id)->first();

        if($employee) {
            $employee->delete();

            return response()->json(['status' => true], 201);
        }

            
        return response()->json(['status'], 404);

    }

    
}
