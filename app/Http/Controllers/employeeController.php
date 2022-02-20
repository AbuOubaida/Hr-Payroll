<?php

namespace App\Http\Controllers;

use App\Models\project_team;
use App\Models\set_team;
use App\Models\team_member;
use App\Models\User;
use App\Rules\Html;
use Illuminate\Http\Request;
use App\Models\employee_position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Location;
use App\Models\Role;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use App\Models\recruitments_list;
use App\Models\recruitments_admit_list;

class employeeController extends Controller
{
    //
    private $html = null;
    private $profileImagePath = 'image/employee/profile/';
    private $coverImagePath = 'image/employee/cover/';
    private $record = 10;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    private function employees()
    {
        return User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')
            ->leftJoin('roles as r','r_user.role_id','r.id')
            ->leftJoin('department as d','users.dep_id','d.dep_id')
            ->leftJoin('employee_positions as p','users.position_id','=','p.position_id')
            ->select('users.name as emp_name','r.name as role_name','users.phone','users.email','users.status as emp_status','users.profile_pic as profile','users.phone_code','users.id as emp_id','users.employee_id as emp_no','r.id as role_id','d.dep_name','p.position_name as p_name')->paginate($this->record);
    }
    private function getActiveDepartments(): \Illuminate\Support\Collection
    {
        return DB::table('department')->where('status',1)->select('dep_name as d_name','dep_id as d_id')->get();
    }
    private function getActivePost()
    {
        return employee_position::where('position_status',1)->select('position_name as p_name','position_id as p_id')->get();
    }
    public function create()
    {
        $ip = \Request::ip();
        $userLocation = Location::get($ip);
        $countries = DB::table('country')->get();
        if (!$countries)
            $countries = null;
        $employees = $this->employees();
        $positions = $this->getActivePost();
        $departments = $this->getActiveDepartments();
        $roles = $this->roles();
        return view('admin/employee/add-new',compact('employees','positions','departments','userLocation','countries','roles'));
    }
    //Set employee id
    private function generateEmpId($dep_id): string
    {
        $data = User::where('dep_id',$dep_id)->groupBY('dep_id')->count();
        $dep = DB::table('department')->where('dep_id',$dep_id)->select('dep_code')->first();
        $emp_id = date('y').date('m').$dep->dep_code;
        if (strlen($data) == 1) $emp_id .= '00'.++$data;
        elseif (strlen($data)==2) $emp_id .= '0'.++$data;
        else $emp_id .= $data;
        while(User::where('employee_id',$emp_id)->first())
        {
            $emp_id++;
        }
        return $emp_id;
    }
    //Insert data
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name'          =>  ['required','max:100',$this->html],
            'countryCode'   =>  ['required','numeric',$this->html],
            'emp_phone'     =>  ['required','digits:10',$this->html],
            'emp_email'     =>  ['required','email','max:100',$this->html],
            'emp_gender'    =>  ['required','numeric','digits:1',$this->html],
            'emp_dob'       =>  ['sometimes','nullable',$this->html],
            'emp_dep'       =>  ['required','numeric',$this->html],
            'emp_position'  =>  ['required','numeric',$this->html],
            'emp_role'      =>  ['required','numeric',$this->html],
            'emp_address'   =>  ['required',$this->html],
            'postcode'      =>  ['required',$this->html],
            'emp_country'   =>  ['required',$this->html],
            'emp_profile'   =>  'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:1024', //file Size max 1mb
            'emp_cover'     =>  'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:1536', //file Size max 1mb
            'emp_npass'     =>  ['required','min:8'],
            'emp_cpass'     =>  ['required','min:8'],
        ]);
        extract($request->post());
        extract($request->file());
        if ($emp_npass != $emp_cpass )
        {
            return back()->with('error','New password and conform password dose not match')->withInput();
        }
        if ($this->checkEmailDB($emp_email)){
            return back()->with('error',$emp_email.' already use')->withInput();
        }
        $c = DB::table('country')->where('id',$countryCode)->select('phonecode')->first();
        if (!$c)
        {
            return back()->with('error','Country Code not found')->withInput();
        }
        if (!DB::table('department')->where('dep_id',$emp_dep)->first())
        {
            return back()->with('error','Department not found')->withInput();
        }
        if (!employee_position::where('position_id',$emp_position)->first())
        {
            return back()->with('error','Position not found')->withInput();
        }
        if (!Role::where('id',$emp_role)->first())
        {
            return back()->with('error','Role not found')->withInput();
        }
        //image
        $owner_id = Auth::user()->id;
        $profile_img_name = null;
        $cover_img_name = null;
        if (@$emp_profile)
        {
            $profile_img_name = $emp_email.'_'.$emp_profile->getClientOriginalName();
            $emp_profile->move(public_path($this->profileImagePath),$profile_img_name);
        }
        if (@$emp_cover)
        {
            $cover_img_name = $emp_email.'_'.$emp_cover->getClientOriginalName();
            $emp_cover->move(public_path($this->coverImagePath),$cover_img_name);
        }
        //Set employee id
        $emp_id = $this->generateEmpId(@$emp_dep);
        $insert = User::create([
            'status'=>'1',
            'name'      => $name,
            'email'     => $emp_email,
            'phone'     => $emp_phone,
            'phone_code'=> $c->phonecode,
            'profile_pic'=> $profile_img_name,
            'cover_pic' => $cover_img_name,
            'gender'    => $emp_gender,
            'dob'       => $emp_dob,
            'position_id'=> $emp_position,
            'dep_id'    => $emp_dep,
            'address'   => $emp_address,
            'postcode'  => $postcode,
            'country'   => $emp_country,
            'password'  => Hash::make($emp_cpass),
            'employee_id'=>$emp_id,
            'created_at'=> now(),
            'created_by'=> Auth::user()->id,
            'approved_by'=> Auth::user()->id,
        ]);
        if (@$emp_role == 1)$role = 'admin';
        elseif (@$emp_role == 2)$role = 'project-manager';
        else $role='employee';
        $insert->attachRole($role);
        if ($insert)
        {
            return back()->with('success','Data Insert Successful');
        }
        else{
            return back()->with('error','Data Insert are not Possible')->withInput();
        }

    }
//    Show list
    private function roles()
    {
        return Role::select('id as role_id','display_name','name')->get();
    }
    public function show()
    {
        $roles = $this->roles();
        $employees = $this->employees();
        return view('admin/employee/employee-list',compact('employees','roles'));
    }
    //Single View Employee Profile
    private function singleEmployee($id)
    {
        return User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')
            ->leftJoin('roles as r','r_user.role_id','r.id')
            ->leftJoin('department as d','users.dep_id','d.dep_id')
            ->leftJoin('employee_positions as p','users.position_id','=','p.position_id')
            ->leftJoin('grades as g','users.salary_grade_id','=','g.grade_id')
            ->where('users.id',$id)->select(
                'users.id as emp_id',
                'users.status as emp_status',
                'users.name as emp_name',
                'users.phone',
                'users.phone_code',
                'users.email',
                'users.profile_pic as profile',
                'users.cover_pic as cover',
                'users.gender',
                'users.dob',
                'users.address',
                'users.postcode',
                'users.country',
                'users.employee_id as emp_no',
                'users.created_at as emp_create',
                'users.updated_at as emp_update',
                'r.name as role_name',
                'r.id as role_id',
                'd.dep_name',
                'd.dep_id',
                'd.dep_code',
                'p.position_id as p_id',
                'p.position_name as p_name',
                'g.grade_id as grd_id',
                'g.grade_title as grd_name',
                'g.grade_short_title as grd_short',
                'g.grade_basic')->first();
    }
    public function getEmployeeByID($id)
    {
        return $this->singleEmployee($id);
    }
    public function singleView($id)
    {
        $roles = $this->roles();
        $employees = $this->employees();
        $employee = $this->singleEmployee($id);
        if ($employee)
        {
            return view('admin/employee/view',compact('employee','roles','employees'));
        }
        else{
            return redirect('admin/employee/all-list');
        }
    }
    //change employee Role
    public function empRoleChange(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'id' => ['required','numeric',$this->html],
            'role' => ['required','numeric',$this->html],
        ]);
        extract($request->post());
        $roles = Role::where('id',$role)->first();
        if ((User::where('id',$id)->first()) && ($roles) && (Auth::user()->id != $id))
        {
            $before = DB::table('role_user')->where('user_id',$id)->first();
            if(DB::table('role_user')->where('user_id',$id)->update(['role_id'=>$roles->id]))
            {
                User::where('id',$id)->update([
                    'updated_by' => Auth::user()->id,
                    'updated_at' => now(),
                ]);

                if ($before->role_id == 2 && $role != 2)
                {
                    $teamID = project_team::where('team_leader_id',$id)->select('team_id')->first();
                    project_team::where('team_leader_id',$id)->update(['team_status'=>0,]);
                    set_team::where('team_id',$teamID->team_id)->where('complete_status','!=',1)->update(['status'=>0,'complete_status',2]);
                }
                return back()->with('success','Role Change Successful');
            }
            else{
                return back()->with('error','Role Change Not Possible');
            }
        }
        else{
            return back()->with('error','Role Change Not Possible');
        }
    }
    //change status
    private function changeStatus($id, $status)
    {
        return User::where('id',$id)->update([
            'status'=>$status,
            'updated_by'=> Auth::user()->id,
        ]);
    }
    private function getEmployee($id)
    {
        return User::where('id',$id)->first();
    }
    private function getEmpLoginRole($emp_id)
    {
        return DB::table('role_user')->where('user_id',$emp_id)->select('role_id')->first();
    }
    public function empStatusChange(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v' => ['required','numeric',$this->html],
                'status' => ['required','numeric',$this->html],
            ]);
            extract($request->post());
            $id = $v;
            $user = $this->getEmployee($id);
            if (($user) && ($user->employee_id) && (Auth::user()->id != $id) && (Auth::user()->roles()->first()->id < $this->getEmpLoginRole($id)->role_id))
            {
                if ($status == 1)$status = 1;
                else $status = 0;
                if($this->changeStatus($id,$status))
                {
                    return 1;
                }
                else{
                    return 0;
                }
            }
            return 0;
        }
        else return false;
    }
    //Set or Update Employee ID by Department
    public function setIdByDep(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v' => ['required','numeric',$this->html],
                'id' => ['required','numeric',$this->html],
            ]);
            extract($request->post());
            $dep_id = $v;
            $employee = $this->getEmployee($id);
            if ($employee->dep_id != $dep_id)
            {
                //Set employee id
                $emp_id = $this->generateEmpId($dep_id);
               return User::where('id',$id)->update(['employee_id'=>$emp_id,'dep_id'=>$dep_id,'approved_by'=>Auth::user()->id,'updated_by'=>Auth::user()->id,'updated_at'=>now()]);
            }
            return false;

        }
        else return false;
    }
    //Edit Employee
    public function edit($id)
    {
        if((DB::table('role_user')->where('user_id',$id)->select('role_id')->first()->role_id <= Auth::user()->roles()->first()->id) && !($id == Auth::user()->id))
        {
            return redirect("admin/employee/view/{$id}")->with('warning',"Admin Can't edit another admin Info!");
        }
        $ip = \Request::ip();
        $userLocation = Location::get($ip);
        $countries = DB::table('country')->get();
        if (!$countries)
        {
            $countries = null;
        }

        $positions = $this->getActivePost();
        $departments = $this->getActiveDepartments();
        $roles = $this->roles();
        $employee = $this->singleEmployee($id);
        $employees = $this->employees();
        if ($employee && $employees && $roles)
        {
            return view('admin/employee/edit',compact('employee','roles','employees','countries','userLocation','positions','departments'));
        }
        else{
            return redirect('admin/employee/all-list');
        }
    }
    //Update Employee data
    public function update(Request $request)
    {
        $request->validate([
            'name'          =>  ['required','max:100',$this->html],
            'countryCode'   =>  ['required','numeric',$this->html],
            'emp_phone'     =>  ['required','digits:10',$this->html],
            'emp_email'     =>  ['required','email','max:100',$this->html],
            'emp_gender'    =>  ['required','numeric','digits:1',$this->html],
            'emp_dob'       =>  ['sometimes','nullable',$this->html],
            'emp_position'  =>  ['required','numeric',$this->html],
            'emp_address'   =>  ['required',$this->html],
            'postcode'      =>  ['required',$this->html],
            'emp_country'   =>  ['required',$this->html],
            'emp_profile'   =>  'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:1024', //file Size max 1mb
            'emp_cover'     =>  'sometimes|nullable|image|mimes:jpeg,jpg,png,gif|max:1536', //file Size max 1mb
        ]);
        extract($request->post());
        extract($request->file());
        if(($this->getEmpLoginRole($emp_id)->role_id <= Auth::user()->roles()->first()->id) && (Auth::user()->id != $emp_id))
        {
            //error
            return back()->with('error','You can not edit this profile');
        }
        if (User::where('id','!=',$emp_id)->where('email',$emp_email)->first()){
            return back()->with('error',$emp_email.' already use')->withInput();
        }
        $employee = $this->getEmployee($emp_id);
        $updateValue = [
            'name'      => $name,
            'email'     => $emp_email,
            'phone'     => $emp_phone,
            'phone_code'=> $countryCode,
            'profile_pic'=> $employee->profile_pic,
            'cover_pic' => $employee->cover_pic,
            'gender'    => $emp_gender,
            'dob'       => $emp_dob,
            'position_id'=> $emp_position,
            'address'   => $emp_address,
            'postcode'  => $postcode,
            'country'   => $emp_country,
            'updated_at'=> now(),
            'updated_by'=> Auth::user()->id,
        ];
        if (@$emp_profile)
        {
            $profile_img_name = $emp_email.'_'.$emp_profile->getClientOriginalName();
            $updateValue['profile_pic'] = $profile_img_name;
            if ($employee->profile_pic && file_exists($name=$this->profileImagePath.$employee->profile_pic)) {
                unlink(public_path($name));
            }
            $emp_profile->move(public_path($this->profileImagePath),$profile_img_name);
        }
        if (@$emp_cover)
        {
            $cover_img_name = $emp_email.'_'.$emp_cover->getClientOriginalName();
            $updateValue['cover_pic'] = $cover_img_name;
            if ($employee->cover_pic && file_exists($name=$this->coverImagePath.$employee->cover_pic)) {
                unlink(public_path($name));
            }
            $emp_cover->move(public_path($this->coverImagePath),$cover_img_name);
        }
        if (User::where('id',$emp_id)->update($updateValue))
        {
            return back()->with('success','Data Update Successful');
        }
        else{
            return back()-with('error','Data Update Not Possible!');
        }
    }
//  Auto Generate Password
    private function autoPassword()
    {
        $chars = "#abcdefghilkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789~!@#$%^&*()_+";
        return substr(str_shuffle($chars),0, 8);
    }
//  Ajax generate password
    public function generatePass()
    {
        echo $this->autoPassword();
    }
//    Email address duplicate check
    private function checkEmailDB($email)
    {
        return User::where('email',$email)->first();
    }
//    Email address result show using ajax
    public function checkEmail(Request $request)
    {
        $email = $request->post('v');
        if ($this->checkEmailDB($email))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    //Search Employee
    private function empInDb($value)
    {
        return User::leftJoin('grades as g','users.salary_grade_id','=','g.grade_id')->where('status',1)->where(function ($query) use($value){
            $query->where('email','=',"{$value}");
            $query->orWhere('employee_id','=',"{$value}");
        })->select('users.name','users.profile_pic','users.employee_id','users.email','users.id','g.grade_id','g.grade_title','g.grade_short_title')->first();
    }
    public function searchEmployee(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v'=> ['required',$this->html]
            ]);
            extract($request->post());
            $data = $this->empInDb($v);
            return view('layouts/admin/employee/_emp_search_table',compact('data'));
        }
    }
//    Search Employee on employee list page
    private function searchEmpList($value)
    {
        return User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')
            ->leftJoin('roles as r','r_user.role_id','r.id')
            ->leftJoin('department as d','users.dep_id','d.dep_id')
            ->leftJoin('employee_positions as p','users.position_id','=','p.position_id')
            ->where(function ($query) use($value){
                $query->where('users.name','like',"%{$value}%");
                $query->orWhere('users.email','like',"%{$value}%");
                $query->orWhere('users.phone','like',"%{$value}%");
                $query->orWhere('users.phone_code','like',"%{$value}%");
                $query->orWhere('users.employee_id','like',"%{$value}%");
                $query->orWhere('p.position_name','like',"%{$value}%");
                $query->orWhere('d.dep_name','like',"%{$value}%");
            })->select('users.name as emp_name','r.name as role_name','users.phone','users.email','users.status as emp_status','users.profile_pic as profile','users.phone_code','users.id as emp_id','users.employee_id as emp_no','r.id as role_id','d.dep_name','p.position_name as p_name')->get();
    }
    public function searchEmployeeList(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v'=> ['required',$this->html]
            ]);
            extract($request->post());
            $employees = $this->searchEmpList($v);
            return view('layouts/admin/employee/_emp_list',compact('employees'));
        }
    }
    //Filter by Employee Role
    private function filterDb($value)
    {
        if ($value)
        {
            return User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')
                ->leftJoin('roles as r','r_user.role_id','r.id')
                ->leftJoin('department as d','users.dep_id','d.dep_id')
                ->leftJoin('employee_positions as p','users.position_id','=','p.position_id')
                ->where(function ($query) use($value){
                    $query->where('r.id','=',"{$value}");
                })->select('users.name as emp_name','r.name as role_name','users.phone','users.email','users.status as emp_status','users.profile_pic as profile','users.phone_code','users.id as emp_id','users.employee_id as emp_no','r.id as role_id','d.dep_name','p.position_name as p_name')->get();
        }
    }
    public function filterByRole(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v'=> ['required',$this->html]
            ]);
            extract($request->post());
            $employees = $this->filterDb($v);
            return view('layouts/admin/employee/_emp_list',compact('employees'));
        }
    }
    //Delete data employee
    public function destroy($id)
    {
        if(($this->getEmpLoginRole($id)->role_id > Auth::user()->roles()->first()->id) && (Auth::user()->id != $id))
        {
            $employee = $this->getEmployee($id);
            if ($employee->profile_pic && file_exists($name=$this->profileImagePath.$employee->profile_pic)) {
                unlink(public_path($name));
            }
            if ($employee->cover_pic && file_exists($name=$this->coverImagePath.$employee->cover_pic)) {
                unlink(public_path($name));
            }
            if (User::where('id',$id)->delete() && DB::table('role_user')->where('user_id',$id)->delete())
            {
                return redirect('admin/employee/all-list')->with('success','Data delete successful');
            }
            else{
                return back()->with('error','Data delete not possible');
            }
        }
        else{
            return back()->with('error','Data delete not possible');
        }
    }
    //Admit to employee
    public function admitToEmployee(Request $request)
    {
        $validate = $request->validate([
            'id'            => ['required','numeric',$this->html],
            'name'          => ['required','max:100',$this->html],
            'emp_email'     => ['required','email',$this->html],
            'emp_phone'     => ['required','digits:10',$this->html],
            'emp_dep'       => ['required','numeric',$this->html],
            'emp_position'  => ['required','numeric',$this->html],
            'emp_role'      => ['required','numeric',$this->html],
        ]);
        extract($validate);
        if (!($r_list = recruitments_list::where('cv_id',$id)->where('cv_email',$emp_email)->first()))
           return back()->with('error','CV id and email not found!');
        if (user::where('email',$emp_email)->first())
            return redirect('admin/employee/add-new')->with('error',"This email ({$emp_email}) are already exist in database!")->withInput();
        if (user::where('phone',$emp_phone)->first())
            return redirect('admin/employee/add-new')->with('error',"This Phone ({$emp_phone}) are already exist in database!")->withInput();

        if ($user = user::where('name',$name)->where('email',$emp_email)->where('phone',$emp_phone)->where('dep_id',$emp_dep)->where('position_id',$emp_position)->first())
        {
            recruitments_list::where('cv_id',$id)->delete();
            return redirect("admin/employee/edit/{$user->id}")->with('warning','This data are already exist in Database. Please recheck and update if need. Thank you');
        }
        if(!($allData = recruitments_list::leftjoin('recruitments as r', 'recruitments_lists.r_id','r.r_id')->where('recruitments_lists.seen_status',1)->first()))
            return back()->with('error','This CV seen status is unseen, Please make seen the seen status.');
//        if (recruitments_admit_list::where('cv_id',$id)->first())
//        {
////            recruitments_list::where('cv_id',$id)->delete();
//            return back()->with('warning','This data are already exist in Database. Please recheck and update if need. Thank you');
//        }
        if ($admit_no = count($r_a_lists = recruitments_admit_list::where('r_id',$allData->r_id)->get()))
        {
            if ($admit_no >= $allData->r_vacancies)
                return back()->with('error',"Sorry! There are no vacancies for this post ({$allData->r_title}). Already admit the {$admit_no} person, whois is required for this post.");
        }
        //insert admit to employee start
        if (recruitments_admit_list::insert($r_list->toArray()))
        {
            $employee_id = $this->generateEmpId($emp_dep);
            $insData = [
                'status'    => '0',
                'name'      => $name,
                'email'     => $emp_email,
                'phone'     => $emp_phone,
                'position_id'=> $emp_position,
                'dep_id'    => $emp_dep,
                'password'  => Hash::make($this->autoPassword()),
                'employee_id'=>$employee_id,
                'created_at'=> now(),
                'created_by'=> Auth::user()->id,
                'approved_by'=> Auth::user()->id,
            ];
            if ($insert = User::create($insData))
            {
                $insert->attachRole('employee');
                if ($insert)
                {
                    $newUser = User::where('email',$emp_email)->first();
                    recruitments_list::where('cv_id',$id)->delete();
                    return redirect("admin/employee/edit/{$newUser->id}")->with('success','Employee Insert Successfully. Please fill-up the empty required field and update it, otherwise this account do not active. Thank you');
                }
                else
                    return back('error','Data transfer not possible');
            }
            else
                return back('error','Data transfer not possible');
        }
        else{
            return back('error','Data transfer not possible');
        }
    }
//    Change Employee Password by admin
    public function changeEmpPassByAdmin(Request $request)
    {
        extract($request->post());
        if ($emp = User::where('id',$emp_id)->where('status',1)->first())
            return view('admin/employee/change-emp-password',compact('emp'));
        else
            return back()->with('error','Employee not found or employee account not active');
    }
    public function updateEmpPassByAdmin(Request $request)
    {
        $validate = $request->validate(['*' => 'required',$this->html]);
        extract($request->post());
        if ($emp = User::where('id',$id)->where('status',1)->first())
        {
            if (!(Hash::check($admin_pass, Auth::user()->password))) {
                return redirect("admin/employee/edit/{$id}")->with("error","Admin password does not matches with the password you provided. Please try again.");
            }
            else{
                if ($new != $conform)
                {
                    return redirect("admin/employee/edit/{$id}")->with("error","Employee new password and conform password can not match");
                }
                else{
                    $user = User::where('id',$id)->first();
                    $user->password = bcrypt($conform);
                    $user->save();
                    return redirect("admin/employee/edit/{$id}")->with("success","Employee Password changed successfully !");
                }
            }
        }
        else
            return back()->with('error','Employee not found or employee account not active');
    }
}
