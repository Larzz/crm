<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function saveNewsletter() {

        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'notes' => 'required',
            'filename' => 'required'
        ]); 


        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }

        $newsletter = New Newsletter;
        $newsletter->title = $this->request->title;
        $newsletter->notes = $this->request->notes;
        $newsletter->file_url = $this->request->filename;
        $newsletter->added_by = auth()->user()->id;

        if($newsletter->save()) {
            return response()->json(['status' => true]);
        }

        return response()->jso(['status' => false]);
    }

    public function getNewsletter() {
        
    }

    public function getAllNewsletter() {
        return response()->json(['status' => true, 'newsletters' => Newsletter::all()]);
    }

    public function deleteNewsletter($newsletter_id) {
        $newsletter = Newsletter::where('id', $newsletter_id)->first();
        if($newsletter) {
            $newsletter->delete();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
