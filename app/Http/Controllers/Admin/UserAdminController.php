<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index(){
        // $user = User::query()->join('role_user', 'users.id','=','role_user.user_id')->where('role_user.role_id',1)->orderBy('created_at','desc')->get();
        $user = DB::table('role_user')->join('users','users.id','=','role_user.user_id')->where('role_user.role_id',1)->orderBy('users.created_at','desc')->paginate(100);
        // $user = DB::table('role_user')->join('users','users.id','=','role_user.user_id')->where('role_user.role_id',1)->orderBy('users.created_at','desc')->paginate(5)->toArray();
        return response()->json($user,202);
        // return array_reverse($user);
    }
    public function search(Request $request){
        $filter_email = $request->filter_email;
        if($filter_email != ""){
            $filter_email = $filter_email;
         }
        $user = DB::table('role_user')->join('users','users.id','=','role_user.user_id')->where('role_user.role_id',1)->whereRaw("email like '%$filter_email%'")->orderBy('users.created_at','desc')->paginate(100);
        return response()->json($user,202);
    }
    public function detail($id)
    {
        $user = DB::table('users')->where('id', $id)->orderBy('users.created_at','desc')->first();
        $data =[];
        if($user){
            $data['name']=$user->name;
            $data['email']=$user->email;
            $data['id']=$user->id;
        }
        return response()->json($data,202);
    }
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users|indisposable',
            'password'  => 'required|min:8|confirmed'
        ],[
            'name.required' => 'Nama Tidak Boleh Kosong', 
            'email.required' => 'Email Tidak Boleh Kosong', 
            'email.email'=>"Format Email salah",
            'email.unique'=>"Email Sudah Terdaftar",
            'email.indisposable'=>"Email Fake",
            'password.required' => 'Password Tidak Boleh Kosong', 
            'password.min' => 'Password Kurang dari 8 Digit', 
            'password.confirmed' => 'Password Tidak Sama', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // if($request->id === null){}
        $user = User::updateOrCreate(['id'=>$request->id],[
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
    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return response('', 202);
    }
}
