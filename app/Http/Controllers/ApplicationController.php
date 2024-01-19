<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ApplicationController extends Controller
{
    public function __invoke()
    {
        return view('application');
    }
    public function landingPage(){
        return view('landing-page.index');
    }
}
