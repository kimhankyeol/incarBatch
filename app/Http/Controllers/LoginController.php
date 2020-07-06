<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App;
class LoginController extends Controller
{
    public function loginView(Request $request){
        return view('common.login');
    }
}
