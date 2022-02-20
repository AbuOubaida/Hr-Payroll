<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
//use MongoDB\Driver\Session;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Location;
use App\Rules\Html;


class departmentController extends Controller
{
    private $table = 'department';
    private $profileImagePath = 'image/department/profile/';
    private $coverImagePath = 'image/department/cover/';
    private $html = null;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    //
    public function create()
    {
        $ip = \Request::ip();
        $userLocation = Location::get($ip);
        $country = DB::table('country')->get();
        if (!$country)
            $country = null;
        $departments = $this->getAllActiveDep('desc',10);
        return view('admin/department/add-department',compact('departments','userLocation','country'));
    }
    public function getAllActiveDep($order,$record): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!$order)$order='asc';
        if (!$record)$record=10;
        return DB::table($this->table)->where('status',1)->orderBy('dep_id',$order)->paginate($record);
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'depName'=>['required','max:100',$this->html],
            'depCode'=>['required','digits:3','numeric',$this->html],
            'depEmail'=>['sometimes','nullable','email','max:255',$this->html],
            'countryCode'=>['sometimes','nullable','numeric',$this->html],
            'depPhone'=>['sometimes','nullable','numeric','digits:10',$this->html],
            'depDetails'=>['sometimes','nullable',$this->html],
            'depProfile'=>'mimes:jpeg,jpg,png,gif|max:1024', //file Size max 1mb
            'depCover'=>'mimes:jpeg,jpg,png,gif|max:1536' //file Size max 1mb
        ]);
        $depCode = $request->post('depCode');
        $code = DB::table($this->table)->where('dep_code',$depCode)->first();
        if ($code)
        {
            return back()->with('error',"The cod ($depCode) are already exists");
        }
        $owner_id = Auth::user()->id;
        $profile_img_name = null;
        $cover_img_name = null;
        if ($request->file('depProfile'))
        {
            $profile_img_name = $request->post('depName').'_'.$request->file('depProfile')->getClientOriginalName();
            $request->file('depProfile')->move(public_path($this->profileImagePath),$profile_img_name);
        }
        if ($request->file('depCover'))
        {
            $cover_img_name = $request->post('depName').'_'.$request->file('depCover')->getClientOriginalName();
            $request->file('depCover')->move(public_path($this->coverImagePath),$cover_img_name);
        }
        $phone = $request->post('depPhone');
        $countryCodeID = $request->post('countryCode');
        if (!$phone)
        {
            $phoneCode = null;
        }
        else{
            $country = DB::table('country')->where('id',$countryCodeID)->first('phonecode');
            if ($country)
            $phoneCode = $country->phonecode;
            else
            $phoneCode = null;
        }

        DB::table($this->table)->insert([
            'dep_code'=>$depCode,
            'dep_name'=>$request->post('depName'),
            'dep_email'=>$request->post('depEmail'),
            'country_code'=>$phoneCode,
            'dep_phone'=>$phone,
            'dep_description'=>$request->post('depDetails'),
            'dep_profile_pic'=>$profile_img_name,
            'dep_cover_pic'=>$cover_img_name,
            'owner_id'=>$owner_id,
            'created_at'=>now(),
            'status'=>1
        ]);
        return back()->with('success', 'Data inserted Successfully!');
    }
//    Show All department
    public function show()
    {
        $departments = $this->getAllActiveDep('desc',10);
        return view('admin/department/department-list',compact('departments'));
    }
//    For Single view a Department
    public function singleView($id)
    {
        $departments = $this->getAllActiveDep('desc',10);
        $department = DB::table($this->table)->select('users.name as owner_name',"$this->table.*")->join('users','users.id','=',"$this->table.owner_id")->where("$this->table.dep_id",$id)->where("$this->table.status",1)->first();
        if ($department)
            return view('admin/department/single-view',compact('department','departments'));
        else
            return back();
    }
//    Edit Department
    public function edit($id)
    {
        $country = DB::table('country')->get();
        if (!$country)
            $country = null;
        $departments = $this->getAllActiveDep('desc',10);
        $department = DB::table($this->table)->where('dep_id',$id)->where('status',1)->where('owner_id',Auth::user()->id)->first();
        if ($department)
            return view('admin/department/edit-department',compact('department','country','departments'));
        else
            return back();
    }
//    Update Department
    public function update(Request $request,$id): RedirectResponse
    {
        $owner_id = Auth::user()->id;
        $department = DB::table($this->table)->where('owner_id',$owner_id)->where('status',1)->where('dep_id',$id)->first();
        if (!$department)
        {
            return back();
        }
        $depCode = $request->post('depCode');
        $code = DB::table($this->table)->where('dep_code',$depCode)->where('dep_id','!=',$id)->first();
        if ($code)
        {
            return back()->with('error',"The cod ($depCode) are already exists");
        }
        $validated = $request->validate([
            'depName'=>['required','max:100',$this->html],
            'depCode'=>['required','digits:3','numeric',$this->html],
            'depEmail'=>['sometimes','nullable','email','max:255',$this->html],
            'countryCode'=>['sometimes','nullable','numeric',$this->html],
            'depPhone'=>['sometimes','nullable','numeric','digits:10',$this->html],
            'depDetails'=>['sometimes','nullable',$this->html],
            'depProfile'=>'mimes:jpeg,jpg,png,gif|max:1024', //file Size max 1mb
            'depCover'=>'mimes:jpeg,jpg,png,gif|max:1536' //file Size max 1mb
        ]);
        $profile = $request->file('depProfile');
        $cover = $request->file('depCover');
        if (!$request->post('depPhone')) {
            $phoneCode = null;
        }
        else {
            $country = DB::table('country')->where('id',$request->post('countryCode'))->first();
            $phoneCode = $country->phonecode;
        }
        $updateValue = [
            'dep_name'=>$request->post('depName'),
            'dep_code'=>$depCode,
            'dep_email'=>$request->post('depEmail'),
            'country_code'=>$phoneCode,
            'dep_phone'=>$request->post('depPhone'),
            'dep_description'=>$request->post('depDetails'),
            'dep_profile_pic'=>$department->dep_profile_pic,
            'dep_cover_pic'=>$department->dep_cover_pic,
            'update_at'=>now()
        ];
        if ($profile)
        {
            $profile_img_name = $request->post('depName').'_'.$profile->getClientOriginalName();
            $updateValue['dep_profile_pic'] = $profile_img_name;
            if ($department->dep_profile_pic && file_exists($name=$this->profileImagePath.$department->dep_profile_pic)) {
                unlink(public_path($name));
            }
            $profile->move(public_path($this->profileImagePath),$profile_img_name);
        }
        if ($cover)
        {
            $cover_img_name = $request->post('depName').'_'.$cover->getClientOriginalName();
            $updateValue['dep_cover_pic'] = $cover_img_name;
            if ($department->dep_cover_pic && file_exists($name=$this->coverImagePath.$department->dep_cover_pic)) {
                unlink(public_path($name));
            }
            $cover->move(public_path($this->coverImagePath),$cover_img_name);
        }
        $update = DB::table($this->table)->where('owner_id',$owner_id)->where('status',1)->where('dep_id',$id)->update($updateValue);
        if (!$update)
        {
            return back()->with('error', 'Something want wrong! Data Update Not Possible!');
        }
        return back()->with('success', 'Data Update Successfully!');
    }
//    For Inactive a Department Status
    public function makeInactive($id): RedirectResponse
    {
        $owner_id = Auth::user()->id;
        $department = DB::table($this->table)->where('owner_id',$owner_id)->where('status',1)->where('dep_id',$id)->first();
        if (!$department)
        {
            return back();
        }
        $delete = DB::table($this->table)->where('dep_id',$id)->where('owner_id',$owner_id)->update(['status'=>0]);
        if ($delete)
            return redirect('admin/department-list')->with('success','Data delete successful');
        else
            return back()->with('error','Data delete are not possible');
    }
//    For ajax show by filter request
    public function ajaxShowByFilter(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v'=>['required',$this->html]
            ]);
            $orderId = $request->post('v');
            if ($orderId == 1)$order = 'asc';
            else $order = 'desc';
            $departments = DB::table($this->table)->where('status',1)->orderBy('dep_name',$order)->get();
            return view('layouts/admin/department/_dep-list',compact('departments'));
        }
    }
//    For ajax show by search request
    public function ajaxShowBySearch(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v'=>['required',$this->html]
            ]);
            $value = $request->post('v');
            $departments = DB::table($this->table)->where('status',1)->where(function ($query) use($value){
                $query->where('dep_name','like',"%{$value}%");
                $query->orWhere('dep_email','like',"%{$value}%");
                $query->orWhere('dep_phone','like',"%{$value}%");
                $query->orWhere('dep_code','like',"%{$value}%");
            })->orderBy('dep_name','asc')->get();
            return view('layouts/admin/department/_dep-list',compact('departments'));
        }
    }
    public function depCodeCheck(Request $request): bool
    {
        $value = $request->post('v');
        if (DB::table($this->table)->where('dep_code',$value)->first())
        {
            return true;
        }
        else{
            return false;
        }
    }
}
