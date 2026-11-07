<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index(){
        return view('home');
    }

    function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],
        [
            'username.required' => 'username wajib diisi',
            'password.required' => 'password wajib diisi'
        ]);

        $ceklogin = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if(Auth::attempt($ceklogin)){
            $request->session()->regenerate();

            $user = Auth::user();

            if($user->level=='administrasi'){
                return redirect('/admin');
            } elseif($user->level=='gurubk'){
                return redirect('/guru');
            }
        } else{
            return redirect('/')->withErrors('username dan password salah')->withInput();
        }
    }

    function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
