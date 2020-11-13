<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{

    public function login(Request $request)
    {
        if (Staff::where(['email' => $request->email, 'password' => $request->password])->exists()) {
            $id = Staff::where(['email' => $request->email, 'password' => $request->password])->first()['id'];
            Session::put('id', $id);
            Session::remove('isAdmin');
            return redirect('home');
        } else {
            return redirect()->back()->withErrors(['Invalid username or password']);
        }
    }

    public function getStaffListView()
    {
        $staff = Staff::all();
        return view('staff')->with(['staff' => $staff]);
    }

    public function getAddStaffView()
    {
        return view('add-staff');
    }

    public function saveStaff(Request $request)
    {
        $staff = new Staff();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->password = $request->password;
        $result = $staff->save();
        if ($result == true) {
            return redirect('staff')->with('message', "Staff Saved Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }

    public function deleteStaff($staffId)
    {
        Staff::where('id', $staffId)->delete();
        return redirect()->back();
    }

    public function editStaff($staffId)
    {
        $staff = Staff::where('id', $staffId)->first();
        return view('edit-staff')->with(['staff' => $staff]);
    }

    public function saveEditedStaff(Request $request)
    {
        $staff = Staff::where('id', $request->staffId)->first();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->password = $request->password;
        $result = $staff->update();
        if ($result == true) {
            return redirect('staff')->with('message', "Staff updated Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }
}
