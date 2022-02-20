<?php

namespace App\Http\Controllers;

use App\Models\grade;
use App\Models\grade_allowance;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\Html;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\compare;

class salaryGradeController extends Controller
{
    private $html = null;
    private $record = 10;
    public function __construct()
    {
        $this->html = new Html;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $grades = grade::orderBy('grade_id','desc')->paginate($this->record);
        if (session()->exists('request_page') && session()->exists('request_id'))
        {
            $id = session('request_id');
            $grade = grade::where('grade_id',$id)->first();
            return view('admin/grade/salary/step-2-add-new',compact('grades','grade'));
        }
        return view('admin/grade/salary/add-new',compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => ["required",'max:50',$this->html],
            'short_name'    => ["required",'max:30',$this->html],
            'basic'         => ["required",'numeric',$this->html],
            'details'       => ['sometimes','nullable',$this->html],
            'ta'            => ['sometimes','nullable',$this->html],
            'da'            => ['sometimes','nullable',$this->html],
            'hra'           => ['sometimes','nullable',$this->html],
            'mda'           => ['sometimes','nullable',$this->html],
            'bonus'         => ['sometimes','nullable',$this->html],
            'pf'            => ['sometimes','nullable',$this->html],
            'pt'            => ['sometimes','nullable',$this->html]
        ]);
        $title = $request->post('title');
        $short_name = $request->post('short_name');
        $basic = $request->post('basic');
        $hra = $request->post('hra');
        $mda = $request->post('mda');
        $bonus = $request->post('bonus');
        $pf = $request->post('pf');
        $pt = $request->post('pt');
        $data = grade::where('grade_title',$title)->orWhere('grade_short_title',$short_name)->first();
        if ($data)
        {
            return back()->with('error','Duplicate Grade Title or Short Name are not allowed!')->withInput();
        }
        $store = grade::create([
            'grade_title'       => $title,
            'grade_short_title' => $short_name,
            'grade_details'     => $request->post('details'),
            'grade_basic'       => $request->post('basic'),
            'grade_ta'          => $request->post('ta'),
            'grade_da'          => $request->post('da'),
            'grade_hra'         => $hra,
            'grade_mda'         => $mda,
            'grade_bonus'       => $bonus,
            'grade_prd_fund'    => $pf,
            'grade_pro_tax'     => $pt,
            'created_at'        => now(),
            'create_id'         => Auth::user()->id
        ]);
        if($store)
        {
            $grades = grade::orderBy('grade_id','desc')->paginate($this->record);
            if ($hra || $mda || $bonus || $pf || $pt)
            {
                $grade = grade::where('grade_title',$title)->where('grade_short_title',$short_name)->first();
                return view('admin/grade/salary/step-2-add-new',compact('grades','grade'));
            }
            $update = grade::where('grade_title',$title)->where('grade_short_title',$short_name)->update(['grade_status'=>1]);
            return back()->with('success',"Salary Grade added successful");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\grade  $grade
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(grade $grade)
    {
        $grades = grade::orderBy('grade_id','desc')->paginate($this->record);
        return view('admin/grade/salary/grade-list',compact('grades'));
    }

    public function singleView($id)
    {
        $createAt = grade::leftJoin('users as u','grades.create_id','=','u.id')->select('u.id','u.name')->where('grade_id',$id)->first();
        $updateAt = grade::leftJoin('users as u','grades.update_id','=','u.id')->select('u.id','u.name')->where('grade_id',$id)->first();
        $grades = grade::orderBy('grade_id','desc')->paginate($this->record);

        $joinGrades = grade::leftJoin('grade_allowances as ga','grades.grade_id','=','ga.grade_id')->select('*','grades.grade_id as root_id','grades.created_at as root_create','grades.updated_at as root_update')->where('grades.grade_id',$id)->where('grades.grade_status',1)->first();
        if ($joinGrades)
        return view('admin/grade/salary/view-grade',compact('grades','joinGrades','createAt','updateAt'));
        else
            return redirect('admin/grade/salary/grade-list');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\grade  $grade
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function edit(grade $grade, $id)
    {
        $grades = grade::orderBy('grade_id','desc')->paginate($this->record);
//        $joinGrades = DB::table('grades')->leftJoin('grade_allowances as ga', 'grades.grade_id', '=', 'ga.grade_id')->select('grades.*','grade_allowances.*')->where('grades.grade_id',$id)->where('grades.grade_status',1)->first();
        $joinGrades = grade::leftJoin('grade_allowances as ga','grades.grade_id','=','ga.grade_id')->select('*','grades.grade_id as root_id','grades.created_at as root_create','grades.updated_at as root_update')->where('grades.grade_id',$id)->where('grades.grade_status',1)->first();
        if ($joinGrades)
        return view('admin/grade/salary/edit-grade',compact('grades','joinGrades'));
        else
            return redirect('admin/grade/salary/grade-list');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, grade $grade, $id)
    {
        $request->validate([
            'title'         => ["required",'max:50',$this->html],
            'short_name'    => ["required",'max:30',$this->html],
            'basic'         => ["required",'numeric',$this->html],
            'details'       => ['sometimes','nullable',$this->html],
            'ta'            => ['sometimes','nullable',$this->html],
            'da'            => ['sometimes','nullable',$this->html],
            'hra'           => ['sometimes','nullable',$this->html],
            'mda'           => ['sometimes','nullable',$this->html],
            'bonus'         => ['sometimes','nullable',$this->html],
            'pf'            => ['sometimes','nullable',$this->html],
            'pt'            => ['sometimes','nullable',$this->html]
        ]);
        $title = $request->post('title');
        $st = $request->post('short_name');
        $basic = $request->post('basic');
        $details = $request->post('details');
        $ta = $request->post('ta');
        $da = $request->post('da');
        $hra = $request->post('hra');
        $mda = $request->post('mda');
        $bonus = $request->post('bonus');
        $pf = $request->post('pf');
        $pt = $request->post('pt');
        if (grade::where('grade_id','!=',$id)->where(function($q) use($title,$st){
            $q->where('grade_title',"$title");
            $q->orWhere('grade_short_title',$st);
        })->first())
        {
            return back()->with('error','Duplicate Grade Title or Short Name are not allowed!');
        }
        $hra_val = null;
        if ($hra)
        {
            $request->validate([
                'hra_val'         => ["required",'numeric',$this->html]
            ]);
            $hra_val = $request->post('hra_val');
        }
        $mda_val = null;
        if ($mda)
        {
            $request->validate([
                'mda_val'         => ["required",'numeric',$this->html]
            ]);
            $mda_val = $request->post('mda_val');
        }
        $b_no_val = null;
        $b_amount_val = null;
        if ($bonus)
        {
            $request->validate([
                'b_no_val'         => ["required",'numeric',$this->html],
                'b_amount_val'         => ["required",'numeric',$this->html]
            ]);
            $b_no_val = $request->post('b_no_val');
            $b_amount_val = $request->post('b_amount_val');
        }
        $pf_val = null;
        if ($pf)
        {
            $request->validate([
                'pf_val'         => ["required",'numeric',$this->html]
            ]);
            $pf_val = $request->post('pf_val');
        }
        $pt_val = null;
        if ($pt)
        {
            $request->validate([
                'pt_val'         => ["required",'numeric',$this->html]
            ]);
            $pt_val = $request->post('pt_val');
        }

        if (grade_allowance::where('grade_id',$id)->first())
        {
            $update_alow = grade_allowance::where('grade_id',$id)->update([
                'hra' =>  $hra_val,
                'mda' =>  $mda_val,
                'bonus' =>  $b_amount_val,
                'pf' =>  $pf_val,
                'pt' =>  $pt_val,
                'status'        =>  1,
                'updated_at'    =>  now()
            ]);
            if (!$update_alow)
            {
                return back()->with('error','Something Want Wrong! Data Update Not Possible');
            }
        }
        else{
            $insert_alow = grade_allowance::create([
                'grade_id'=> $id,
                'hra' =>  $hra_val,
                'mda' =>  $mda_val,
                'bonus' =>  $b_amount_val,
                'pf' =>  $pf_val,
                'pt' =>  $pt_val,
                'status'        =>  1,
                'updated_at'    =>  now()
            ]);
            if (!$insert_alow)
            {
                return back()->with('error','Something Want Wrong! Data Update Not Possible');
            }
        }

        $Update = grade::where('grade_id',$id)->update([
            'grade_title'       => $title,
            'grade_short_title' => $st,
            'grade_details'     => $details,
            'grade_basic'       => $basic,
            'grade_ta'          => $ta,
            'grade_da'          => $da,
            'grade_hra'         => $hra,
            'grade_mda'         => $mda,
            'grade_bonus'       => $bonus,
            'grade_prd_fund'    => $pf,
            'grade_pro_tax'     => $pt,
            'updated_at'        => now(),
            'update_id'         => Auth::user()->id,
            'grade_status'      => 1,
            'grade_bonus_no'    => $b_no_val
        ]);
        if (!$Update)
        {
            return back()->with('error','Something Want Wrong! Data Update Not Possible');
        }
        else{
            return back()->with('success','Data Update Successful!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\grade  $grade
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(grade $grade ,$id)
    {
        grade::where('grade_id',$id)->delete();
        grade_allowance::where('grade_id',$id)->delete();
        return redirect('admin/grade/salary/grade-list')->with('success',"Data delete successful");
    }

    public function addGradeStep2(Request $request)
    {
        $grade_id = $request->post('grade_id');
        $request->session()->flash('request_page', 'step-2');
        $request->session()->flash('request_id', $grade_id);
        $request->validate([
            '*'   =>  ["required",'numeric',$this->html]
        ]);
        $id = $request->post('grade_id');
        $hra = $request->post('hra');
        $mda = $request->post('mda');
        $bonus_no = $request->post('b_no');
        $bonus_amount = $request->post('b_amount');
        $pf = $request->post('pf');
        $pt = $request->post('pt');
        if (grade_allowance::where('grade_id',$id)->where('status',1)->first())
        {
//          Update
            $update = grade_allowance::where('grade_id',$id)->where('status',1)->update([
                'grade_id'  =>  $id,
                'hra' =>  $hra,
                'mda' =>  $mda,
                'bonus' =>  $bonus_amount,
                'pf' =>  $pf,
                'pt' =>  $pt,
                'status'        =>  1,
                'updated_at'    =>  now()
            ]);
        }
        else{
//          Insert
            $store = grade_allowance::create([
                'grade_id'  =>  $id,
                'hra' =>  $hra,
                'mda' =>  $mda,
                'bonus' =>  $bonus_amount,
                'pf' =>  $pf,
                'pt' =>  $pt,
                'status'        =>  1,
                'created_at'    =>  now()
            ]);
        }
        if ($store || $update)
        {
            $updateRoot = grade::where('grade_id',$id)->update([
                'grade_status' => 1,
                'grade_bonus_no' =>  $bonus_no,
                'updated_at' =>  now(),
                'update_id' => Auth::user()->id
            ]);
            if ($updateRoot)
            {
                $request->session()->forget('request_page');
                $request->session()->forget('request_id');
                return back()->with('success','Grade Added successful');
            }
            else{
                return back()->with('error','Something Wont Wrong!');
            }
        }
        else{
            return back()->with('error','Something Wont Wrong!');
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
            $grades = grade::where(function ($query) use($value){
                $query->where('grade_title','like',"%{$value}%");
                $query->orWhere('grade_short_title','like',"%{$value}%");
                $query->orWhere('grade_basic','like',"%{$value}%");
            })->orderBy('grade_title','asc')->get();
            return view('layouts/admin/grade/salary/_grade-table',compact('grades'));
        }
    }
    //set grade for user
    public function setSalaryGrade()
    {
        $roles = Role::select('id as role_id','display_name','name')->get();
        $grades = grade::orderBy('grade_id','desc')->paginate($this->record);
        $activeGrades = grade::where('grade_status',1)->orderBy('grade_short_title','asc')->get();
        $employees = User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')
            ->leftJoin('roles as r','r_user.role_id','r.id')
            ->leftJoin('department as d','users.dep_id','d.dep_id')
            ->leftJoin('employee_positions as p','users.position_id','=','p.position_id')
            ->select('users.name as emp_name','r.name as role_name','users.phone','users.email','users.status as emp_status','users.profile_pic as profile','users.phone_code','users.id as emp_id','users.employee_id as emp_no','r.id as role_id','d.dep_name','p.position_name as p_name')->paginate($this->record);
        return view('admin/employee/set-salary-grade',compact('grades','employees','activeGrades','roles'));
    }
    public function setSalaryGradeSave(Request $request)
    {
        $request->validate([
            'employee_id' => ['required',$this->html],
            'grade' => ['sometimes','nullable','numeric',$this->html],
        ]);
        extract($request->post());
        if ((grade::where('grade_id',$grade)->where('grade_status',1)->first()) && (User::where('status',1)->where(function ($query) use($employee_id){$query->where('email','=',$employee_id);$query->orWhere('employee_id','=',$employee_id);})->first()))
        {
            $update = User::where('email','=',$employee_id)->orWhere('employee_id','=',$employee_id)->update(['salary_grade_id'=>$grade]);
            if ($update)
            {
                return back()->with('success','Data Add successful')->withInput();
            }
            else{
                return back()->with('error','Data add not possible')->withInput();
            }
        }
        elseif ($grade == 0 )
        {
            $update = User::where('email','=',$employee_id)->orWhere('employee_id','=',$employee_id)->update(['salary_grade_id'=>null]);
            if ($update)
            {
                return back()->with('success','Data Add successful')->withInput();
            }
            else{
                return back()->with('error','Data add not possible')->withInput();
            }
        }
        else{
            return back()->with('error','Data add not possible')->withInput();
        }
    }
}
