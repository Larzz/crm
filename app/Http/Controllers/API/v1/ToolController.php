<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tools;

class ToolController extends Controller
{
    //
    protected $request;
    public function __construct(Request $request) {
        $this->request = $request;
    }

    
    /**
    * Get Tools
    * @return array
    */
    public function getTools() {
        return response()->json(['status' => true, 'tools' => Tools::all()]);
    }


    /**
     * Post Tool
     * @return array
    */
    public function addTool() {
        
        $tool = New Tools;
        $tool->product = $this->request->product;
        $tool->url = $this->request->url;
        $tool->email = $this->request->email;
        $tool->password = $this->request->password;
        $tool->purpose = $this->request->purpose;
        $tool->added_by = auth()->user()->id;
        $tool->subscription_type = $this->request->subscription_type;
        $tool->frequency_type = $this->request->frequency;
        $tool->price = $this->request->price;
        $tool->expiration = $this->request->expiration;
        $tool->notes = $this->request->notes;
        $tool->type = $this->request->type;

        if($tool->save()) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);

    }


    /**
     * Edit Tool
     * @param int $id
     * @return array
    */
    public function editTool($id) {

        $tool = Tools::where('id', $id)->first();

        if ($tool) {
            
            $tool->product = $this->request->product;
            $tool->url = $this->request->url;
            $tool->email = $this->request->email;
            $tool->password = $this->request->password;
            $tool->purpose = $this->request->purpose;
            $tool->added_by = auth()->user()->id;
            $tool->subscription_type = $this->request->subscription_type;
            $tool->frequency_type = $this->request->frequency;
            $tool->price = $this->request->price;
            $tool->expiration = $this->request->expiration;
            $tool->notes = $this->request->notes;
            $tool->type = $this->request->type;

            if($tool->save()) {
                return response()->json(['status' => true]);
            }

        }

        return response()->json(['status' => false]);

    }

     
    
    /**
     * Delete Tool
     * @param int $tool_id
     * @return status
    */
    public function deleteTool($tool_id) {

        $tool = Tools::where('id', $tool_id)->first();

        if($tool) {
            $tool->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }




}
