<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsLettersController extends Controller
{
    //
    public function index() {
        $meta = ['title' => 'Newsletter', 'active' => 'newsletter'];
        return view('general.newsletter', $meta);
    }

    
}
