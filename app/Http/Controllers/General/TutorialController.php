<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    //
    public function index() {
        $meta = ['title' => 'Tutorial'];
        return view('general.tutorial', $meta);
    }
}