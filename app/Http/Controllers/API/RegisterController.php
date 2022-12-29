<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request){
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
       return response()->json(['message' =>'register berhasil'], 201);
    }
}
