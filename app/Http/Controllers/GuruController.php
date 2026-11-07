<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    function index(){
        echo 'Selamat datang <h1>'.Auth::user()->nama.'</h1>';
        echo '<br><a href="logout">Logout</a>';
    }
}
