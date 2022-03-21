<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Presentations;
use Illuminate\Support\Facades\Validator;


class PresentationController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
        define("YEAR",     date('Y'));
    }


    public function addPresentation($client_id) {

        $validator = Validator::make($this->request->all(), [
            'name' => 'required',
            'description' => 'required',
            'meeting_date' => 'required',
            'filename' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }
        
        $presentation = new Presentations;
        $presentation->name = $this->request->name;
        $presentation->description = $this->request->description;
        $presentation->attachment = $this->request->filename;
        $presentation->date_added = now();
        $presentation->meeting_date = $this->request->meeting_date;
        $presentation->client_id = $client_id;
        $presentation->user_id = auth()->user()->id;

        if($presentation->save()) {
            return response()->json(['status' => true, 'message' => 'Successfully Added']);
        }

        return response()->json(['status' => true, 'message' => 'Successfully Added']);

    }


    public function getPresentation($client_id, $year=YEAR) {
        if($year=='all') {
            $presentations = Presentations::where('client_id', $client_id)->get();
        } else {
            $presentations = Presentations::where('client_id', $client_id)->whereYear('meeting_date', $year)->get();
        }
        
        if($presentations) {
            return response()->json(['status' => true, 'presentations' => $presentations]);
        }
        return response()->json(['status' => false, 'presentations' => $presentations]);
    }


    public function getAllPresentation() {
        $presentations = Presentations::leftjoin('users', 'users.id', 'presentation.client_id')
                                        ->select('presentation.id','presentation.name as filename', 'presentation.description', 'users.name')
                                        ->get();
        return response()->json(['status' => true, 'presentations' => $presentations]);
    }


    public function deletePresentation($presentation_id, $client_id) {
        $presentation = Presentations::where('id', $presentation_id)->where('client_id', $client_id)->first();

        if($presentation) {
            $presentation->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

}
