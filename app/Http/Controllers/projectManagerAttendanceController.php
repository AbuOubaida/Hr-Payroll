<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\cmp_protocol;
use App\Models\company;
use App\Models\loan_running_lists;
use App\Models\professional_tax;
use App\Models\provident_fund;
use App\Models\salary;
use App\Rules\Html;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class projectManagerAttendanceController extends Controller
{
    private $html = null;
    private $record = 10;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    //Show all attendance list
    public function list()
    {
        $year = attendance::select('year')->distinct()->orderby('year','desc')->get();
        $month = attendance::select('month_name','month')->orderby('month','asc')->distinct()->get();
        $date = attendance::select('date')->distinct()->orderby('date','asc')->get();
        $department = DB::table('department')->where('status',1)->get();
        $attendance = attendance::leftJoin('users', 'attendances.employee_id', 'users.id')
            ->leftJoin('department as d', 'users.dep_id', 'd.dep_id')
            ->leftJoin('employee_positions as p', 'users.position_id', '=', 'p.position_id')
            ->leftJoin('grades as g', 'users.salary_grade_id', '=', 'g.grade_id')
            ->where('users.status', 1)
            ->where('attendances.entry_time', '!=', null)
            ->where('attendances.employee_id',Auth::user()->id)
            ->select(
                'attendances.*',
                'users.id as emp_id',
                'users.status as emp_status',
                'users.name as emp_name',
                'users.phone',
                'users.phone_code',
                'users.email',
                'users.profile_pic as profile',
                'users.employee_id as emp_no',
                'd.dep_name',
                'd.dep_code',
                'p.position_name as p_name',
                'g.grade_title as grd_name',
                'g.grade_short_title as grd_short')
            ->orderby('attendances.updated_at',"desc")
            ->paginate($this->record);
        return view('project-manager/attendance/attendance-list',compact('attendance','year','month','date','department'));
    }
    public function filterAttendance(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'year'=>['sometimes','nullable','numeric',$this->html],
                'month'=>['sometimes','nullable',$this->html],
                'date'=>['sometimes','nullable','numeric',$this->html],
            ]);
            $year = null;
            $month = null;
            $date = null;
            extract($request->post());
            $attendance = attendance::leftJoin('users', 'attendances.employee_id', 'users.id')
                ->leftJoin('department as d', 'users.dep_id', 'd.dep_id')
                ->leftJoin('employee_positions as p', 'users.position_id', '=', 'p.position_id')
                ->leftJoin('grades as g', 'users.salary_grade_id', '=', 'g.grade_id')
                ->where('users.status', 1)
                ->where('attendances.entry_time', '!=', null)
                ->where('attendances.employee_id',Auth::user()->id)
                ->when($year != null,function ($query) use ($request){
                    $query->where('attendances.year','=',$request->post('year'));
                })
                ->when($month != null,function ($query) use ($request){
                    $query->where('attendances.month_name','=',$request->post('month'));
                })
                ->when($date != null,function ($query) use ($request){
                    $query->where('attendances.date','=',$request->post('date'));
                })
                ->select(
                    'attendances.*',
                    'users.id as emp_id',
                    'users.status as emp_status',
                    'users.name as emp_name',
                    'users.phone',
                    'users.phone_code',
                    'users.email',
                    'users.profile_pic as profile',
                    'users.employee_id as emp_no',
                    'd.dep_name',
                    'd.dep_code',
                    'p.position_name as p_name',
                    'g.grade_title as grd_name',
                    'g.grade_short_title as grd_short')
                ->orderby('attendances.updated_at',"desc")
                ->get();
            return view('layouts/project-manager/attendance/_filter_list',compact('attendance'));
        }
    }
    public function singleViewAtt($id)
    {
        $data = $this->singleView($id);
        if (!$data)
        {
            return back()->with('error','Data not found!');
        }
        $workingHour = DB::table('cmp_protocols')->select('daily_entry_time as det','daily_leave_time as dlt','daily_working_hour as dwh')->first();
        $late = null;
        $first = null;
        $entryRuleTime = date('H:i:s',strtotime($workingHour->det));
        $entryTime = date('H:i:s',strtotime($data->entry_time));
        if ($entryTime > $entryRuleTime)
        {
            //late entry
            $time = $this->timeToHour($entryRuleTime,$entryTime);
            if ($time['min'] > 30 || $time['hour'] >= 1)
            {
                $late = $time;
            }
        }
        else{
            // Note late
            $time = $this->timeToHour($entryTime,$entryRuleTime);
            if ($time['min'] > 30 || $time['hour'] >= 1)
            {
                $first = $time;
            }
        }
        return view('project-manager/attendance/single-view',compact('data','first','late'));
    }
    private function timeCalculation($date2)
    {
        $d1 =  strtotime(date('H:i:s'));
        $d2 =  strtotime($date2) ;
        $tsec = abs($d2-$d1);
        $hour = (int)($tsec/3600);
        $ext = $tsec%3600;
        $minute = (int)($ext/60);
        $sec = $ext%60;
        return ['sec'=>$sec,'min'=>$minute,'hour'=>$hour];
    }
    private function timeToHour($smallTime,$bigTime)
    {
        $d1 =  strtotime($smallTime);
        $d2 =  strtotime($bigTime) ;
        $tsec = abs($d2-$d1);
        $hour = (int)($tsec/3600);
        $ext = $tsec%3600;
        $minute = (int)($ext/60);
        $sec = $ext%60;
        return ['sec'=>$sec,'min'=>$minute,'hour'=>$hour];
    }
    private function singleView($id)
    {
        return attendance::leftJoin('users', 'attendances.employee_id', 'users.id')
            ->leftJoin('department as d', 'users.dep_id', 'd.dep_id')
            ->leftJoin('employee_positions as p', 'users.position_id', '=', 'p.position_id')
            ->leftJoin('grades as g', 'users.salary_grade_id', '=', 'g.grade_id')
            ->where('users.status', 1)
            ->where('attendances.entry_time', '!=', null)
            ->where('attendances.attend_id', '=', $id)
            ->where('attendances.employee_id',Auth::user()->id)
            ->select(
                'attendances.*',
                'users.id as emp_id',
                'users.status as emp_status',
                'users.name as emp_name',
                'users.phone',
                'users.phone_code',
                'users.email',
                'users.profile_pic as profile',
                'users.employee_id as emp_no',
                'd.dep_name',
                'd.dep_code',
                'p.position_name as p_name',
                'g.grade_title as grd_name',
                'g.grade_short_title as grd_short')
            ->first();
    }

    //
    public function salaryList()
    {
        $protocol = cmp_protocol::first();
        $year = salary::select('sa_year')->distinct()->orderby('sa_year','desc')->get();
        $month = salary::select('sa_month')->orderby('sa_month','asc')->distinct()->get();
        $department = DB::table('department')->where('status',1)->get();
        $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
            ->leftJoin('department as d','d.dep_id','salaries.dep_id')
            ->where('salaries.emp_id',Auth::user()->id)
            ->select('salaries.*','d.dep_name','u.name','u.email','u.employee_id','u.profile_pic')
            ->paginate($this->record);
        return view('project-manager/payroll/salary-list',compact('year','month','department','protocol','salary'));
    }
    //search All List
    public function searchAllList(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'year'=>['sometimes','nullable','numeric',$this->html],
                'month'=>['sometimes','nullable',$this->html],
            ]);
            $dep = null;
            $emp = null;
            $year = null;
            $month = null;
            extract($request->post());
            if ($dep == 0) $dep = null;
            $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
                ->leftJoin('department as d','d.dep_id','salaries.dep_id')
                ->select('salaries.*','d.dep_name','u.name','u.email','u.employee_id','u.profile_pic')
                ->where('u.id',Auth::user()->id)
                ->where('salaries.emp_id',Auth::user()->id)
                ->when($year != null, function ($query) use ($request){
                    $query->where('salaries.sa_year','=',$request->post('year'));
                })
                ->when($month != null, function ($query) use ($request){
                    $query->where('salaries.sa_month','=',$request->post('month'));
                })
                ->get();
            return view('layouts/admin/payroll/_last_salary_table',compact('salary'));
        }
    }
    //for account setting
    public function accountSetting()
    {
        $user = Auth::user();
        $company = company::where('comp_id',1)->where('comp_status',1)->first();
        return view('project-manager/account/basic-setting',compact('company','user'));
    }
    //change password
    public function changePassword()
    {
        return view('project-manager/change-password');
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
    //view single salary
    public function singleSalaryView($id)
    {
        $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
            ->where('salaries.sa_id',$id)
            ->where('salaries.emp_id',Auth::user()->id)
            ->select('salaries.*','u.name','u.email','u.employee_id','u.salary_grade_id')
            ->first();
        if (!$salary)
        {
            return back();
        }
        $pf =   provident_fund::where('sa_id',$id)->first();
        $pt =   professional_tax::where('sa_id',$id)->first();
        $runningLoan = null;
        $companyProtocol = cmp_protocol::first();
        if ($salary->add_loan || $salary->add_loan_installment)
        {
            $runningLoan = loan_running_lists::where('invoice_id',$salary->loan_invoice_id)->first();
        }
//        dd($salary,$runningLoan);
        return view("project-manager/payroll/single-view",compact('salary','pf','pt','runningLoan','companyProtocol'));
    }
}
