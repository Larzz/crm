<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Mail\EmployeeMail;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Leave;

class EmployeeController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    public function UpdateEmployee ($employee_id) { 

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'position' => 'required',
            'date_joined' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }

        $user = User::where('id', $employee_id)->first();

        if($user) {
            $user->update([
                'name' => $this->request->name,
                'position' => $this->request->position,
                'date_joined' => $this->request->date_joined,
                'birth_date' => $this->request->birth_date,
                'mobile_number' => $this->request->mobile_number
            ]);
            return response()->json(['status' => true, 'employee' => $user], 200);
        }

        return response()->json(['status' => false], 502);
    }


}
