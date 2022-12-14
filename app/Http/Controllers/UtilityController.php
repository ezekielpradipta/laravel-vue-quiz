<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    public function cekEmail(Request $request)
    {
        $cek = $request->email;
        if ($cek != "") {
            $cek = $cek;
        }
        $data = DB::table('users')->where("email", $cek)->count();
        if ($data > 0) {
            return response()->json(['message'=>'not_unique'],202);
        } else {
            return response()->json(['message'=>'unique'],202);
        }
    }
}
