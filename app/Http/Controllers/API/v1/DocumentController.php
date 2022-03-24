<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Documents;
use App\Models\DocumentType;
class DocumentController extends Controller
{
    //
    private $request;
    
    public function __construct(Request $request) {

        $this->request = $request;
        define("YEAR",     date('Y'));

    }

    public function addDocument($id) {

        $document = new Documents;
        $document->name = $this->request->name;
        $document->description = $this->request->type;
        $document->attachment = $this->request->filename;
        $document->user_id = $id;
        $document->type = $this->request->type;
        $document->expiration_date = $this->request->expiration_date;
        $document->renewal_date = $this->request->renewal_date;
        $document->open_ended = $this->request->open_ended;

        if($document->save()) {
            $response = ['status' => true, 'success' => true];
            return response()->json($response);
        }

        return response()->json(['status' => false]);

    }

    public function uploadDocument() {
        
        $filename = $this->request->file->getClientOriginalName() .'-'. time() . '.' . $this->request->file->getClientOriginalExtension();
        $filetype = $this->request->file->getClientOriginalExtension();
        $filesize = filesize($this->request->file);

        if($this->request->file->move(public_path('documents'), $filename)) {
            return response()->json(['status' => true, 'filename' => $filename]);
        }

        return response()->json(['status' => false]);
    }

    public function getDocuments($user_id, $year=YEAR) {
        if ($year == 'all') {
            $documents = Documents::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        } else {
            $documents = Documents::where('user_id', $user_id)->whereYear('expiration_date', $year)->orderBy('created_at', 'desc')->get();
        }
        return response()->json(['status' => true, 'documents' => $documents]);
    }

    public function deleteDocument($id) {
        
        $document = Documents::where('id', $id)->first();
        if($document) {
            $document->delete();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);

    }

    public function getDocumentTypes() {
        return response()->json(['status' => true, 'types' => DocumentType::orderBy('created_at', 'desc')->get()]);
    }


    public function deleteExpiration() {
        return response()->json(['status' => true, 'documents' => Documents::where('expiration_date', '<=' , Date.now())->orderBy('created_at', 'desc')->get()]);
    }


}
