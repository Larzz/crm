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
    
    public function __construct() {

    }

    public function addDocument() {

    }

    public function getDocuments() {

    }

    public function getDocument() {

    }

    public function editDocument() {

    }

    public function deleteDocument() {

    }

    public function getDocumentTypes() {
        return response()->json(['status' => true, 'types' => DocumentType::get()]);
    }


}
