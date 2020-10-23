<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function signup(Request $request){
        try{
            if(!User::where('email', $request->email)->exists()){
                $user = new User();
                $user->name = $request->firstname;
                $user->email = $request->email;
                $user->password = md5($request->password);
                $result = $user->save();
                Session::put('userId', $user->id);
                return json_encode(['status' => $result, 'message' => 'Signup Successfull!']);
            }else{
                return json_encode(['status' => false, 'message' => 'Email Already Exists']);
            }
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Server Error. Please try again.', 'error' => $exception->getMessage()]);
        }
    }

    public function login(Request $request){
        try{
            if(User::where('email', $request->email)->exists()){
                $user = User::where('email', $request->email)->first();
                if($user->password == md5($request->password)){
                    Session::put('userId', $user->id);
                    return json_encode(['status' => true, 'message' => 'Login Successfull!']);
                }else{
                    return json_encode(['status' => false, 'message' => 'Invalid email or password!']);
                }
            }else{
                return json_encode(['status' => false, 'message' => 'Invalid email or password!']);
            }
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Server Error. Please try again.']);
        }
    }

    public function logout(){
        try{
            Session::remove('userId');
            return json_encode(['status' => true]);
        }catch (\Exception $exception){
            return json_encode(['status'=> false]);
        }
    }
}
