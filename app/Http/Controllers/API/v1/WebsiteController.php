<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Website;

class WebsiteController extends Controller
{
    //

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }



    public function saveDomain() {

    }


    
    public function getDomain() {

    }
}
