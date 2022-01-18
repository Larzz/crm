<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsLetterController extends Controller
{
    //
    public function index() {
        $meta = ['title' => 'Newsletter'];
        return view('general.newsletter', $meta);
    }

}
