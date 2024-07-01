<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Logs;

class LogsController extends Controller
{
    //

    public function __construct()
    {
        
    }

    public function getLogs() {
        $logs = Logs::leftjoin('users', 'users.id', '=', 'logs.user_id')->select('users.name','users.role', 'logs.*')->orderBy('logs.created_at', 'desc')->get();
        return response()->json(['status' => true, 'logs' => $logs]);
    }
}
