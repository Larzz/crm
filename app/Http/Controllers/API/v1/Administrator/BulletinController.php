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
        $bulletin->active = $this->request->active == 'yes' ? true : false;
        $bulletin->added_by = auth()->user()->id;

        if($bulletin->save()) {
            return response()->json(['status' => true], 201);
        }

        return response()->json(['status' => true], 500);
    }

    public function getBulletins() {
        return response()->json(['status' => true, 'bulletins' => Bulletin::get()], 201);
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

            $validated = $this->request->validate([
                'title' => 'required',
                'message' => 'required',
                'active' => 'required',
            ]);

            if ($validator->fails()) {    
                return response()->json(['status' => false, 'messages' => $validated->messages()], 422);
            }

            $bulletin->title = $this->request->title;
            $bulletin->message = $this->request->message;
            $bulletin->active = $this->request->active;
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
            $bulletin->destroy();
            return response()->json(['status' => true], 201);
        }   

        return response()->json(['status' => false], 404);
    }


}
