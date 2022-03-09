<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Tutorials;

class TutorialController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    public function addTutorial() {

        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);


        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }

        $tutorial = new Tutorials;
        $tutorial->slug = Str::slug($this->request->title, '-');
        $tutorial->title = $this->request->title;
        $tutorial->content = $this->request->content;
        $tutorial->added_by = auth()->user()->id;

        if ($tutorial->save()) {
           return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);

    } 

    public function getTutorials() {
        return response()->json(['status' => true, 'tutorials' => Tutorials::orderBy('created_at', 'desc')->get()]);
    }

    public function getTutorial() {
    }

    public function deleteTutorial($tutorial_id) {
        
        $tutorial = Tutorials::where('id', $tutorial_id)->first();

        if($tutorial) {
            $tutorial->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);

        
    }

    public function editTutorial($tutorial_id) {

        $tutorial = Tutorials::where('id', $tutorial_id)->first();

        if($tutorial) {

            $tutorial->slug = Str::slug($this->request->title, '-');
            $tutorial->title = $this->request->title;
            $tutorial->content = $this->request->content;

            if($tutorial->update()) {
                return response()->json(['status' => true]);
            }

        }

        return response()->json(['status' => false]);
    }


}
