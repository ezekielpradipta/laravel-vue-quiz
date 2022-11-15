<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAdminController extends Controller
{
    public function index(){
        // $user = User::query()->join('role_user', 'users.id','=','role_user.user_id')->where('role_user.role_id',1)->orderBy('created_at','desc')->get();
        $user = DB::table('role_user')->join('users','users.id','=','role_user.user_id')->where('role_user.role_id',1)->orderBy('users.created_at','desc')->paginate(100);
        // $user = DB::table('role_user')->join('users','users.id','=','role_user.user_id')->where('role_user.role_id',1)->orderBy('users.created_at','desc')->paginate(5)->toArray();
        return response()->json($user,200);
        // return array_reverse($user);
    }
    public function search(Request $request){
        $filter_email = $request->filter_email;
        if($filter_email != ""){
            $filter_email = $filter_email;
         }
        $user = DB::table('role_user')->join('users','users.id','=','role_user.user_id')->where('role_user.role_id',1)->whereRaw("email like '%$filter_email%'")->orderBy('users.created_at','desc')->paginate(100);
        return response()->json($user,200);
    }
}
