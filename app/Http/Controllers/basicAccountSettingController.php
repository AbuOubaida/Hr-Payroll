<?php

namespace App\Http\Controllers;

use App\Rules\Html;
use Illuminate\Http\Request;
use App\Models\company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class basicAccountSettingController extends Controller
{
    private $html = null;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    //
    public function index()
    {
        $user = Auth::user();
        $company = company::where('comp_id',1)->where('comp_status',1)->first();
        return view('admin/account/basic-setting',compact('company','user'));
    }
    //change password
    public function changePassword()
    {
        return view('admin/change-password');
    }
    //update
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old'=>['required',$this->html],
            'new'=>['required',$this->html],
            'conform'=>['required',$this->html],
        ]);
        extract($request->post());
        if (!(Hash::check($old, Auth::user()->password))) {
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        else{
            if ($new != $conform)
            {
                return redirect()->back()->with("error","Your new password and conform password can not match");
            }
            else{
                $user = Auth::user();
                $user->password = bcrypt($conform);
                $user->save();
                return redirect()->back()->with("success","Password changed successfully !");
            }
        }
    }
}
