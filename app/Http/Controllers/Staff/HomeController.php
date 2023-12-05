<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Leave;

use App\Models\User;
use App\Models\Notes;

class HomeController extends Controller
{
    public function index() {
        $meta = array('active' => 'dashboard', 'title' => 'Dashboard', 'leave' => Leave::where('user_id', auth()->user()->id)->first());
        return view('staff.pages.index', $meta);
    }
    
    public function client_page() {
        $meta = array('active' => 'client', 'title' => 'Client', 'active' => 'client', 'users' => User::where('role', 3)->get());
        return view('administrator.pages.client', $meta);
    }

    public function client_index_page($id) {
        $meta = array('active' => 'client', 'title' => 'Client', 'active' => 'client', 'user' => User::where('id', $id)->first());
        return view('administrator.pages.client.view_client', $meta);
    }
}
