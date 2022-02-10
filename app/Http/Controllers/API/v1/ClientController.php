<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Mail\ClientNotification;
use Illuminate\Support\Facades\Mail;
class ClientController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function addClient() {

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'date_joined' => 'required',
            'mobile_number' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }

        $token = Str::random(60);

        $client = new User;
        $client->name = $this->request->name;
        $client->email= $this->request->email;
        $client->password = Hash::make($this->request->password);
        $client->date_joined = $this->request->date_joined;
        $client->mobile_number = $this->request->mobile_number;
        $client->api_token = hash('sha256', $token);
        $client->role = 3; //client

        if($client->save()) {
            $client->attachRole('client');
            Mail::to('larry@creativouae.com')->send(New ClientNotification($client, $this->request->password, 'Client Creation Notification'));
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);

    }   
    
    public function getClients() {
        return response()->json(['status' => true, 'clients' => User::where('role' , 3)->get()]);
    }



    public function getClient($client_id) {

        $client = User::where('id', $client_id)->first();

        if($client) {
            return response()->json(['status' => true, 'client' => $client]);
        }

        return response()->json(['status' => false]);
        
    }


    public function editClient() {

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



    public function deleteClient($id) {

            $client = User::where('id', $id)->first();

            if($client) {
                $client->delete();
                return response()->json(['status' => true]);
            }

            return response()->json(['status' => false]);
    }

}
