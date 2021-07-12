<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    public function register(Request $request) {
        $this->validate($request, [
            'username'=>'required|min:4',
            'email'=>'required|email',
            'steamId'=>'required|min:4',
            'password'=>'required|min:8'
        ]);

        $user = User::create([
            'username'=>$request->username,
            'steamId'=>$request->steamId,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' =>$token], 200);
        } else {
            return response()->json(['error'=>'Tu puta Unauthorised'], 401);
        }
    }
}
