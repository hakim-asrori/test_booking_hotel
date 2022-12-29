<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogintampilanController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'logintampilan'
        ]);
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($validasi)){

            $request->session()->regenerate();

            return redirect('tampilan');
        }else{
            return back();

        }
    }

}


