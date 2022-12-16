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
            return response()->json(['message' => $validator->errors(), 'e_code' => "10"], 400);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        $user->roles()->attach(1);
        return response()->json([
            'message' => 'Register Success!',
            'data'    => $user
        ], 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => "Format Email salah",
            'password.required' => 'Password Tidak Boleh Kosong',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'e_code' => "11",
                'message' => 'Login Gagal! Periksa kembali Email / Password',
            ], 400);
        }
        $message = "Selamat Datang " . (string)$user->email;
        return response()->json([
            'message' => $message,
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken
        ], 200);
    }
    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();

        if ($removeToken) {
            return response()->json([
                'message' => 'Logout Success!',
            ], 200);
        }
    }
    public function getUser()
    {
        $user = auth()->user();
        return response()->json($user, 200);
    }
    public function sentToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => "Format Email salah",
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!isset($user->id)) {
            return response()->json(['message' => 'User Tidak Ditemukan', 'e_code' => '12'], 400);
        }
        $token = Str::random(32);
        Mail::to($user)->send(new ResetPasswordUser($token));
        $password_ = new PasswordReset();
        $password_->email = $user->email;
        $password_->token = $token;
        $password_->save();
    }
    public function validateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ], [
            'token.required' => 'Token Tidak Boleh Kosong',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $password = PasswordReset::where('token', $request->token)->first();
        if (!isset($password->email)) {
            return response()->json(['message' => 'Token Salah', 'e_code' => '13'], 400);
        }
        $user = User::where('email', $password->email)->first();
        return response()->json($user, 202);
    }
    public function resetPassword($id)
    { 
        if (base64_encode(base64_decode($id, true)) === $id) {
            $test = base64_decode($id);
            $rule1 = Str::contains($test, '+');
            if (!$rule1) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $array = explode('+', $test);
            $tryAr = array($array);
            $rule2 = count($array);
            if ($rule2 !== 3) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            if ($array[0] !== "email") {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $user = User::where("email", $array[1])->first();
            if (!$user) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            $password_reset = PasswordReset::where("email", $array[1])->where("token", $array[2])->first();
            if (!$password_reset) {
                return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
            }
            return response()->json([ $array], 202);
        } else {
            return response()->json(['message' => 'PERUBAHAN DATA PAKSA TERDETEKSI'], 401);
        }
    }
    public function newPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ], [
            'password.required' => 'Password Tidak Boleh Kosong',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), "e_code" => "10"], 400);
        }
        $getData =  $this->resetPassword($id);
        $data_email = $getData->original[0][1];
        $user = User::where("email", $data_email)->first();
        $password_reset = PasswordReset::where("email",$user->email)->first();
        $password_reset->delete();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['hasil' => $password_reset], 202);
    }
}
