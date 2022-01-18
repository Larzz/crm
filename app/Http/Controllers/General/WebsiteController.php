<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    //

    public function index() {
        $meta = ['title' => 'Website'];
        return view('general.website', $meta);
    }
}
