<?php

namespace App\Http\Controllers;

use App\Rules\Html;
use Illuminate\Http\Request;
use App\Models\company;
use Illuminate\Support\Facades\Auth;
use App\Models\recruitments;
use App\Models\recruitments_list;

class homeController extends Controller
{
    private $html = null;
    private $cvPath = 'file/admin/recruitments/cv/';
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    //
    public function index()
    {
        $user = Auth::user();
        $company = company::where('comp_id',1)->where('comp_status',1)->first();
        $recruitment = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')->where('recruitments.status',1)
            ->orderBY('r_id','desc')->paginate(15);
//        dd($recruitment);
        return view('home/index',compact('company','recruitment'));
    }
    public function viewJob($id)
    {
        $user = Auth::user();
        $company = company::where('comp_id',1)->where('comp_status',1)->first();
        $recruitment = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')->where('recruitments.status',1)
            ->orderBY('r_id','desc')->paginate(15);
        $singleData = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')->where('recruitments.status',1)->where('r_id',$id)->first();
//        dd($singleData);
        return view('home/single-view',compact('company','recruitment','singleData'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id'=>['required','numeric',$this->html],
            'name'=>['required','max:100',$this->html],
            'email'=>['required','email','max:255',$this->html],
            'phone'=>['required','numeric','digits:10',$this->html],
            'details'=>['sometimes','nullable',$this->html],
            'cv'=>'mimes:pdf', //file Size max 1mb
        ]);
        extract($request->post());
        extract($request->file());
        if (recruitments_list::where('cv_email',$email)->where('cv_phone',$phone)->where('r_id',$id)->first())
        {
            return back()->with('error','You are already apply for this post');
        }
        else{
            if ($cv)
            {
                $cv_file_name = $name.'_'.$email.'_'.$id.'_'.$cv->getClientOriginalName();
                $upload = $cv->move(public_path($this->cvPath),$cv_file_name);
                if ($upload)
                {
                    if (recruitments_list::create(['r_id'=>$id,'cv_name'=>$name,'cv_email'=>$email,'cv_phone'=>$phone,'cv_file'=>$cv_file_name,'cv_details'=>$details,]))
                    {
                        return back()->with('success','Apply Successful, we will contact your email or phone as soon as possible. Thank you');
                    }
                    else{
                        return back()->with('error','Account create not possible, please try again!');
                    }
                }
                else{
                    return back()->with('error','CV upload not possible, please try again!');
                }
            }
            else{
                return back()->with('error','Please upload your CV');
            }
        }
    }
}
