<?php

namespace App\Http\Controllers;

use App\AddDomain;
use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin/login');
    }

    public function login(Request $request)
    {
        if (Admin::where(['email' => $request->email, 'password' => $request->password])->exists()) {
            $id = Admin::where(['email' => $request->email, 'password' => $request->password])->first()['id'];
            Session::put('id', $id);
            Session::put('isAdmin', true);
            return redirect('home');
        } else {
            return redirect()->back()->withErrors(['Invalid username or password']);
        }
    }

    public function adminDashboard()
    {
        $domains = AddDomain::all();
        $users= User::all();
        return view('admin.admin-dashboard')->with(['domains' => $domains, 'users' => $users]);
    }

    public function logout(Request $request)
    {
        Session::remove('userId');
        return redirect('/');
    }
}
