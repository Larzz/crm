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
    }


    public function addPresentation() {

        $validator = Validator::make($this->request->all(), [
            'website' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }
        
        $website = new Website;
        $website->domain_name = $this->request->website;
        $website->notes = $this->request->content;
        $website->is_active = $this->request->is_active;

        if($website->save()) {
            return response()->json(['status' => true, 'message' => 'Successfully Added']);
        }
    }

    public function getPresentation($id) {
        $presentations = Presentations::where('id', $id)->first();
        if($presentations) {

        }
        return response()->json(['status' => true, 'presentations' => $presentations]);
    }

    public function getAllPresentation() {
        $presentations = Presentations::leftjoin('users', 'users.id', 'presentation.client_id')
                                        ->select('presentation.id','presentation.name as filename', 'presentation.description', 'users.name')
                                        ->get();
        return response()->json(['status' => true, 'presentations' => $presentations]);
    }

    public function deletePresentation() {
    }
}
