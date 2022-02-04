<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Website;
use Illuminate\Support\Facades\Validator;

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
     * @return status
    */
    public function saveDomain() {

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

        return response()->json(['status' => false]);
    }

    
    
    /**
     * Get all domain
     * @param  
     * @return websites
    */
    public function getAllDomain() {
        return response()->json(['status' => true, 'websites' => Website::get()]);
    }




    /**
     * Get specific domain
     * @param  
     * @return websites
    */
    public function getDomain($id) {
        $domain = Website::where('id', $id)->first();
        if($domain) {
            return response()->json(['status' => true, 'website' => $domain]);
        }
        return response()->json(['status' => false]);
    }




     /**
     * Delete Domain
     * @param  integer $unique_id
     * @return websites
    */
    public function deleteDomain($id) {
        $website = Website::where('id', $id)->first();
        if($website) {
            $website->delete();
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
