<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index() {
        $meta = array('active' => 'dashboard', 'title' => 'Dashboard');
        return view('staff.pages.index', $meta);
    }
}
