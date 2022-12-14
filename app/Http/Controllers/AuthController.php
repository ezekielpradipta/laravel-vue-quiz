<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordUser;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users|indisposable',
            'password'  => 'required|min:8|confirmed'
        ], [
            'name.required' => 'Nama Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => "Format Email salah",
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min' => 'Password Kurang dari 8 Digit',
            'password.confirmed' => 'Password Tidak Sama',
            'email.indisposable' => "Email Fake",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        $user->roles()->attach(1);
        return response()->json([
            'success' => true,
            'message' => 'Register Success!',
            'data'    => $user
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed!',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Success!',
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken
        ]);
    }
    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();

        if ($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
            ]);
        }
    }
    public function getUser()
    {
        $user = auth()->user();
        return response()->json($user, 200);
    }
    public function sentToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!isset($user->id)) {
            return response()->json(['message' => 'User Tidak Ditemukan','e_code'=>'11'],404);
        }
        $token = Str::random(32);
        Mail::to($user)->send(new ResetPasswordUser($token));
        $password_ = new PasswordReset();
        $password_->email= $user->email;
        $password_->token= $token;
        $password_->save();
    }
    public function validateToken(Request $request){
        $password = PasswordReset::where('token', $request->token)->first();
        if(!isset($password->email)){
            return response()->json(['error'=>'Token Salah'],404);
        }
        $user = User::where('email',$password->email)->first();
        return response()->json($user,200);
    }
    public function resetPassword(Request $request){
        $user = User::find($request->user_id);
        $password_reset = PasswordReset::where("email",$user->email)->first();
        $password_reset->delete();

        $user->password = Hash::make($request->password);
        $user->save();
    }
}
