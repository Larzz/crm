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


    /**
     * Save Domain
     * @param  array $data
     * @return website
    */
    public function saveDomain() {
        return response()->json(['status' => false]);
    }

    
    
    /**
     * get Domain
     * @param  integer $unique_id
     * @return websites
    */
    public function getDomain() {
        return response()->json(['status' => true]);
    }
}
