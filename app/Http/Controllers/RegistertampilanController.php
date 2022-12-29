<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistertampilanController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'registertampilan'
        ]);
    }

    public function store(Request $request)
    {
       $request->validate([
           'nama' => 'required|max:255',
           'Email' => 'required|email|unique:users',
           'password' => 'required|min:8|max:255'
       ]);

      User::create([
        'name'=>$request->nama,
        'email' =>$request->Email,
        'password'=>$request->password,
        'random_key'=>mt_rand(000000000, 999999999)

      ]);
      return redirect('/tampilan');

    }
}
