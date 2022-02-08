<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MeetingMinutes;

class MeetingController extends Controller
{
    //
    protected $request;

    public function __construct() {
    }


    /**
     * add meeting
     * @param client_id
     * @param  array $data
     * @return status
    */
    public function addMeeting($client_id) {

        $meeting = New MeetingMinutes;
        $meeting->name = $this->request->name;
        $meeting->description = $this->request->description;
        $meeting->attachment = $this->request->attachment;
        $meeting->client_id = $this->request->client_id;
        $meeting->user_id = auth()->user()->id;

        if($meeting->save()) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }


    /**
     * upload meeting
     * @param  array $file
     * @return status
    */
    public function uploadMeeting() {

    }


    /**
     * get meeting
     * @param  array $file
     * @return status
    */
    public function getMeeting($client_id) {
        return response()->json(['status' => true, 'meetings'=> MeetingMinutes::where('client_id', $client_id)->get()]);
    }


    /**
     * delete meeting
     * @param  $meeting_id
     * @return status
    */
    public function deleteMeeting($meeting_id) {
        
        $meeting = MeetingMinutes::where('id', $meeting_id)->first();
        if($meeting) {
            $meeting->delete();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);

    }


    /**
     * update meeting
     * @param $meeting_id
     * @param $client_id
     * @return status
    */
    public function updateMeeting($client_id, $meeting_id) {
        $meeting = MeetingMinutes::where('id', $meeting_id)->where('client_id', $client_id)->first();

        if($meeting) {
            $meeting->update(['name' => $this->request->name, 
                'description' => $this->request->description,
                'attachment' => $this->request->attachment,
                'meeting_date' => $this->request->meeting_date]);
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

}
