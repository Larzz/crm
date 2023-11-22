<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Leave;
use App\Models\LeaveDetails;

use App\Models\SickLeave;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

use App\Mail\LeaveMail;
use App\Mail\LeaveMail2;
use App\Mail\LeaveNotification;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    public function addLeave() {

            $validator = Validator::make($this->request->all(), [
                'leave_from' => 'required',
                'leave_to' => 'required',
                'total_day_used' => 'required',
                'used_days' => 'required',
            'leave_id' => 'required'
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }
    
        $leave_details = new LeaveDetails;          
        $leave_details->leave_id = $this->request->leave_id;
        $leave_details->leave_from = Carbon::parse($this->request->leave_from);
        $leave_details->leave_to = Carbon::parse($this->request->leave_to);
        $leave_details->number_of_day = $this->request->used_days;
        $leave_details->balance = $this->request->remaining_days;
        $leave_details->status = false;
        $leave_details->user_id = auth()->user()->id;

        if($leave_details->save()) {
            $leave = Leave::where('id', $this->request->leave_id)->first();
            $leave->available_days = $this->request->remaining_days;
            $leave->used_days = $this->request->used_days;
            if($leave->save()) {
                // Mail::to('manfred@creativouae.com')->send(New LeaveMail2($leave_details, auth()->user(), 'Leave Application Notification'));
                // Mail::to('larry@creativouae.com')->send(New LeaveMail2($leave_details, auth()->user(), 'Leave Application Notification'));
                // Mail::to(auth()->user()->email)->send(New LeaveMail($leave_details, auth()->user(), 'Leave Application Confirmation'));
                return response()->json(['status' => true]);
            }
        }

        return response()->json(['status' => false]);   

    }

    public function getLeaves() {
        $leaves = LeaveDetails::leftjoin('users', 'users.id', '=', 'leave_details.user_id')->select('users.name', 'leave_details.*')->orderBy('leave_details.created_at', 'desc')->get();
        return response()->json(['status' => true, 'leaves' => $leaves]);
    }

    public function getLeave() {
    }

    public function editLeave() {
    }

    public function deleteLeave() {
    }

    public function approved() {
        $leave = LeaveDetails::where('id', $this->request->leave_id)->first();
        if($leave) {
            $user = User::where('id', $leave->user_id)->first();
            $leave_update = LeaveDetails::where('id', $this->request->leave_id)->update(['status' => 1]);
            Mail::to($user->email)->send(New LeaveNotification($leave, $user, 'Leave Application is Approved', 'Leave Application Approved'));
            // Mail::to('larry@creativouae.com')->send(New LeaveNotification($leave, $user, 'Leave Application is Approved', 'Leave Application Approved'));
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function declined() {
        $leave = LeaveDetails::where('id', $this->request->leave_id)->first();
        if($leave) {
            $user = User::where('id', $leave->user_id)->first();
            $leave_update = LeaveDetails::where('id', $this->request->leave_id)->update(['status' => 2]);
            Mail::to($user->email)->send(New LeaveNotification($leave, $user, 'Leave Application is Declined', 'Leave Application Declined'));
            // Mail::to('larry@creativouae.com')->send(New LeaveNotification($leave, $user, 'Leave Application is Declined', 'Leave Application Declined'));
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }


    public function addSickLeave() {

        try {

            $user = User::find($this->request->user_id);

            if ($user) {

                $current_leave = (int) $user->sick_leave;
                $applied_leave = (int) $this->request->number_of_days;

                if ($applied_leave > $current_leave) {
                    return response()->json(['status' => false, 'message' => 'Insufficient Leaves']);
                }

                $user->sick_leave = $current_leave - $applied_leave;
                
                if ($user->save()) {
                    
                    $sickLeave = new SickLeave;
                    $sickLeave->user_id = $this->request->user_id;
                    $sickLeave->leave_from = $this->request->leave_from;
                    $sickLeave->leave_to = $this->request->leave_to;
                    $sickLeave->number_of_days = $this->request->number_of_days;
                    $sickLeave->status = true;
        
                    if ($sickLeave->save()) {
                        return response()->json(['status' => true]);
                    }

                }

            }

            return response()->json(['status' => false]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }

    }

    public function getSickLeaves() {
        $sickLeaves = SickLeave::leftjoin('users', 'users.id', 'sick_leave.user_id')->select('sick_leave.*', 'users.name')->get();
        return response()->json([
            'status' => true,
            'sick_leaves' => $sickLeaves
        ]);
    }

    public function getSickLeave($user_id) {
        $sickLeaves = SickLeave::where('user_id', $user_id)->leftjoin('users', 'users.id', 'sick_leave.user_id')->select('sick_leave.*', 'users.name')->get();
        return response()->json([
            'status' => true,
            'sick_leaves' => $sickLeaves
        ]);
    }

    public function deleteSickLeave($leave_id) {
        $sickLeave = SickLeave::where('id', $leave_id)->delete();
        if ($sickLeave) {
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }


    
}
