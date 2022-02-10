<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class HomeController extends Controller
{
    //
    public function client_page() {
        $meta = array('active' => 'client', 'title' => 'Client', 'active' => 'client', 'users' => User::where('role', 3)->get());
        return view('administrator.pages.client', $meta);
    }

    public function client_index_page($id) {
        $meta = array('active' => 'client', 'title' => 'Client', 'active' => 'client', 'user' => User::where('id', $id)->first());
        return view('administrator.pages.client.view_client', $meta);
    }

}
