<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Leave;

class HomeController extends Controller
{
    //
    public function index() {
        $meta = array('active' => 'dashboard', 'title' => 'Dashboard', 'leave' => Leave::where('user_id', auth()->user()->id)->first());
        return view('staff.pages.index', $meta);
    }
}
