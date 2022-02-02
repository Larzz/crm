<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tutorials;
class TutorialController extends Controller
{
    //
    public function index() {
        $meta = ['title' => 'Tutorial', 'active' => 'tutorial'];
        return view('general.tutorial', $meta);
    }

    public function viewTutorial($sluq) {
        $tutorial = Tutorials::where('slug', $sluq)->first();
        $meta = ['title' => 'Tutorial', 'tutorial' => $tutorial, 'active' => 'tutorial'];
        return view('general.view_tutorial', $meta);
    }
}
