<?php

namespace App\Http\Controllers\API\v1\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Leave;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

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
        $user->role = 2; //emplloyee
        $user->position = $this->request->position;
        $user->date_joined = $this->request->date_joined;
        $user->mobile_number = $this->request->mobile_number;
        $user->api_token = hash('sha256', $token);

        if($user->save()) {

            $user->attachRole('employee');

            // assign leave
            $leave = new Leave;
            $leave->year = date('Y');
            $leave->available_days = 23;
            $leave->used_days = 0;
            $leave->is_forfeited = false;
            $leave->user_id = $user->id;

            if($leave->save()) {
                return response()->json(['status' => true], 201);
            }
        }

        return response()->json(['status' => false], 404);
    }


    public function getEmployees() {
        return response()->json(['employees' => User::where('role', 2)->get()], 200);
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
