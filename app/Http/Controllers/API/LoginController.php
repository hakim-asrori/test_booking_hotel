<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'logintampilan'
        ]);
    }

    public function login(Request $request)
    {
        $validasi = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
       // dd($validasi);
       $user=User::where('email', $request->email )->first();
        if ($user){
            if ($user->password==$request->password) {
                return response()->json(['message'=> 'login sukses', 'data'=>$user], 200);
            }
            //$request->session()->regenerate();

            return response()->json(['message'=> 'login gagal'], 404);

        }else{
             return response()->json(['message'=> 'login gagal'], 404);

        }
    }
}
