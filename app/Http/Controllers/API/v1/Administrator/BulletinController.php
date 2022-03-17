<?php

namespace App\Http\Controllers\Api\v1\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Bulletin;

class BulletinController extends Controller
{   
    private $request;
    //
    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function addBulletin() {


        $validator = Validator::make($this->request->all(), [
            'title' => 'required',
            'message' => 'required',
            'active' => 'required',
        ]);

        if ($validator->fails()) {    
            return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
        }

        $bulletin = new Bulletin;
        
        $bulletin->title = $this->request->title;
        $bulletin->message = $this->request->message;
        $bulletin->active = true;
        $bulletin->added_by = auth()->user()->id;

        if($bulletin->save()) {
             Bulletin::where('id', '!=', $bulletin->id)->update(['active' => false]);
            return response()->json(['status' => true], 201);
        }

        return response()->json(['status' => true], 500);
    }


    public function getAllBulletin() {
        return response()->json(['status' => true, 'bulletins' => Bulletin::orderBy('created_at', 'desc')->get() ], 200);
    }

    public function getBulletins() {
        return response()->json(['status' => true, 'bulletins' => Bulletin::orderBy('created_at', 'desc')->where('active', true)->first() ], 200);
    }

    public function getBulletin($bulletin_id) {

        if($bulletin_id) {

            $bulletin = Bulletin::where('id', $bulletin_id)->first();

            if($bulletin) {
                return response()->json(['status' => true, 'bulletin' => $bulletin], 201);
            }

            return response()->json(['status' => false], 404);
        }

        return response()->json(['status' => false], 404);
    }

    public function editBulletin($bulletin_id) {

        $bulletin = Bulletin::where('id', $bulletin_id)->first();

        if($bulletin) {

            $validator = Validator::make($this->request->all(), [
                'title' => 'required',
                'message' => 'required',
                'active' => 'required',
            ]);
    
            if ($validator->fails()) {    
                return response()->json(['status' => false, 'messages' => $validator->messages()], 422);
            }

            $bulletin->title = $this->request->title;
            $bulletin->message = $this->request->message;
            $bulletin->active = $this->request->active == 'Yes' ? true:false;
            $bulletin->added_by = auth()->user()->id;

            if($bulletin->save()) {
                return response()->json(['status' => true], 200);
            }

            return response()->json(['status' => false, 500]);
        }

        return response()->json(['status' => false], 404);

    }

    public function deleteBulletin($bulletin_id) {

        $bulletin = Bulletin::where('id', $bulletin_id)->first();

        if($bulletin) {
            $bulletin->delete();
            return response()->json(['status' => true], 200);
        }   

        return response()->json(['status' => false], 404);
    }

    public function postBulletin($bulletin_id) {
        $bulletin = Bulletin::where('id', $bulletin_id)->update(['active' => true]);
        if($bulletin) {
            Bulletin::where('id', '!=', $bulletin_id )->update(['active' => false]);
            return response()->json(['status' => true]);
        }
        return respose()->json(['status' => false]);
    }


}
