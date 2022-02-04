<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    //
    protected $request;

    public function __construct(Request $request) {
        $this->requets = $request;
    }

    public function saveNewsletter() {

    }

    public function getNewsletter() {

    }

    public function getAllNewsletter() {

    }

    public function deleteNewsletter() {

    }
}
