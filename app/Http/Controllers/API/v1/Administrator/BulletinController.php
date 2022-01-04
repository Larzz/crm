<?php

namespace App\Http\Controllers\Api\v1\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bulletin;

class BulletinController extends Controller
{
    //
    public function __construct() {
    }

    public function addBulletin() {
        return response()->json(['status' => true], 200);
    }

    public function getBulletins() {
    }

    public function getBulletin() {
    }

    public function editBulletin() {
    }

    public function deleteBulletin() {

    }


}
