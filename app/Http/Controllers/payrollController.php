<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\grade;
use App\Models\grade_allowance;
use App\Models\loan_application_list;
use App\Models\loan_installment;
use App\Models\loan_running_lists;
use App\Rules\Html;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\cmp_protocol;
use App\Models\User;
use App\Models\salary;
use App\Models\provident_fund;
use App\Models\professional_tax;
use Throwable;

class payrollController extends Controller
{
    private $html = null;
    private $record = 15;
    private $startDate =null;
    private $endDate =null;
    private $fakeEndDate = null;
    public function __construct()
    {
        $this->fakeEndDate = date('2021-12-27');
        $this->html = new Html;//Rule for check html spatial character
        $protocol = cmp_protocol::first();
        $date = $protocol->salary_date;
        $date1 = $protocol->salary_date + 1;
        $thisMonth = date('m',strtotime(now()));
        $thisYear = date('Y',strtotime(now()));
        $this->startDate = date('Y-m-d',strtotime($date1.'-'.($thisMonth-1).'-'.$thisYear));
        $this->endDate = date('Y-m-d',strtotime($date.'-'.($thisMonth).'-'.$thisYear));
    }
    //create payroll
    public function create()
    {
        $protocol = cmp_protocol::first();
        $year = attendance::select('year')->distinct()->orderby('year','desc')->get();
        $month = attendance::select('month_name','month')->orderby('month','asc')->distinct()->get();
        $date = attendance::select('date')->distinct()->orderby('date','asc')->get();
        $m = date('m',strtotime(now()));
        $pm = date('F',strtotime('1-'.$m-1 .'-'.date('Y')));
        $y = date('Y',strtotime('1-'.$m-1 .'-'.date('Y')));
        $department = DB::table('department')->where('status',1)->get();
        $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
            ->leftJoin('department as d','d.dep_id','salaries.dep_id')
            ->select('salaries.*','d.dep_name','u.name','u.email','u.employee_id','u.profile_pic')
            ->where('sa_month',$pm)
            ->where('sa_year',$y)
            ->paginate($this->record);
        return view('admin/payroll/prepare-salary',compact('year','month','date','department','protocol','salary'));
    }
    //Salary List Show
    public function show()
    {
        $protocol = cmp_protocol::first();
        $year = salary::select('sa_year')->distinct()->orderby('sa_year','desc')->get();
        $month = salary::select('sa_month')->orderby('sa_month','asc')->distinct()->get();
        $department = DB::table('department')->where('status',1)->get();
        $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
            ->leftJoin('department as d','d.dep_id','salaries.dep_id')
            ->select('salaries.*','d.dep_name','u.name','u.email','u.employee_id','u.profile_pic')
            ->paginate($this->record);
        return view('admin/payroll/salary-list',compact('year','month','department','protocol','salary'));
    }
    //Store Salary
    public function store(Request $request)
    {
        $request->validate([
            'year'=>['required','numeric',$this->html],
            'month'=>['required',$this->html],
            'dep'=>['sometimes','nullable','numeric',$this->html],
        ]);
        $bonus = 0;
        extract($request->post());
        if ($year)
            $y = $year;
        else
            $y = date('Y',strtotime(now()));
        $protocol = cmp_protocol::first();
        $date = $protocol->salary_date;
        $date1 = $protocol->salary_date + 1;
        $startDate = $year."-".(date('m',strtotime($month)) - 1)."-".($date1 < 10?'0'.$date1:$date1);
        $startDate = date('Y-m-d H:i:s',strtotime($startDate));
        $salaryMonth = date('F',strtotime($startDate));
        $salaryYear  = date('Y',strtotime($startDate));
        $endDate = $this->endDate;

        $user = User::where('status',1)->where('employee_id','!=',null)->where('salary_grade_id','!=',null)->where('dep_id','!=',null)
            ->when($dep != 0, function ($query) use ($request){
                $query->where('dep_id',$request->post('dep'));
            })->get();
        if (count($user) <= 0)
        {
            return back()->with('error',"Data Not Found!");
        }

        $total_monthly_working_hour = ($protocol->daily_working_hour * $protocol->monthly_working_day);
        $error =0;
        $success=0;
        foreach ($user as $u)
        {
            if ($dep && $dep != 0)
                $dep_id = $dep;
            else
                $dep_id = $u->dep_id;

            $pf = 0;
            $pt = 0;
            $total = 0;
            $salaryGrade = grade::leftJoin('grade_allowances as ga','grades.grade_id','ga.grade_id')
                ->where('grades.grade_id',$u->salary_grade_id)
                ->select('grades.*','ga.*')->first();
            if (!$salaryGrade)
            {
                return back()->with('error',"Salary Grade Not Define!");
            }
            $total = $salaryGrade->grade_basic;
            if ($salaryGrade->grade_hra) $total += $salaryGrade->hra;
            if ($salaryGrade->grade_mda) $total += $salaryGrade->mda;
            $includeBonus = 0;
            $bonus_number = 0;
            if ($salaryGrade->grade_bonus && $bonus)
            {
                $previousSalary = salary::where('emp_id',$u->id)->where('sa_year',date('Y',strtotime(now())))->where('include_bonus',1)->get();
                if (count($previousSalary)<$salaryGrade->grade_bonus_no)
                {
                    $includeBonus = 1;
                    $bonus_number = count($previousSalary)+1;
                    $total += $salaryGrade->bonus;
                }
            }
            if ($salaryGrade->grade_prd_fund) $pf=$salaryGrade->pf;
            if ($salaryGrade->grade_pro_tax) $pt=$salaryGrade->pt;

            $perHourRate = ceil($total/$total_monthly_working_hour);
            $perHourRatePf = ceil($pf/$total_monthly_working_hour);
            $perHourRatePt = ceil($pt/$total_monthly_working_hour);
            if (count(attendance::where('employee_id',$u->id)->where('working_hour_in_day','!=',null)->whereBetween('entry_time',[$startDate,$endDate])->get()))
            {
                $success++;
                $total_working_time = attendance::where('employee_id',$u->id)->whereBetween('entry_time',[$startDate,$endDate])
                    ->sum(DB::raw('TIME_TO_SEC(working_hour_in_day)'));
                $secToHour = $this->secToHour($total_working_time);
                $total_working_hour = (float)($secToHour['h'].'.'.($secToHour['m'] + ($secToHour['s']?1:0)));

                $totalWorkPrice = ceil((float)($total_working_hour * $perHourRate));
                $totalPfPrice = ceil((float)($total_working_hour * $perHourRatePf));
                $totalPtPrice = ceil((float)($total_working_hour * $perHourRatePt));

                if ($totalPfPrice)
                {
                    $totalWorkPrice = $totalWorkPrice-$totalPfPrice;
                }
                if ($totalPtPrice)
                {
                    $totalWorkPrice = $totalWorkPrice - $totalPtPrice;
                }

                //insert salary
                if (!(salary::where('sa_month', $salaryMonth)->where('start_date', date('Y-m-d',strtotime($startDate)))->where('end_date', date('Y-m-d',strtotime($endDate)))->where('emp_id', $u->id)->where('dep_id',$dep_id)->first()))
                {
                    //check loan
                    $thisYear = date('Y',strtotime(now()));
                    $thisMonth = date('F',strtotime(now()));
                    $runningLoanAdd = loan_running_lists::where('client_id',$u->id)->where('loan_complete_status',0)->first();
                    if ($runningLoanAdd && $runningLoanAdd->add_loan_month == $thisMonth && $runningLoanAdd->loan_year <= $thisYear && $runningLoanAdd->many_received_status == 0 && $runningLoanAdd->many_received_date == null && $runningLoanAdd->many_provide_id == null && $runningLoanAdd->loan_status == 1)
                    {
                        $totalWorkPrice = $totalWorkPrice + $runningLoanAdd->loan_amount;
                        $salaryData = [
                            'sa_month' => $salaryMonth,
                            'sa_year'=>$salaryYear,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'include_bonus' => $includeBonus,
                            'bonus_number' => $bonus_number,
                            'sa_amount' => $totalWorkPrice,
                            'total_hour' => $total_working_hour,
                            'per_h_rate' => $perHourRate,
                            'emp_id' => $u->id,
                            'dep_id' => $dep_id,
                            'paid_status' => 0,
                            'created_id' => Auth::user()->id,
                            'updated_id' => Auth::user()->id,
                            'add_loan'  =>  1,
                            'loan_invoice_id'  =>  $runningLoanAdd->invoice_id,
                        ];
                        try {
                            loan_running_lists::where('invoice_id',$runningLoanAdd->invoice_id)->update([
                                'many_received_status'=>1,
                                'many_received_date'=>now(),
                                'many_provide_id'=>Auth::user()->id,
                            ]);
                        }catch (Throwable $exception)
                        {
                            return back()->with('error',$exception->getMessage());
                        }
                    }
                    else if ($runningLoanAdd && $runningLoanAdd->many_received_status == 1 && $runningLoanAdd->many_received_date != null && $runningLoanAdd->many_provide_id != null && $runningLoanAdd->loan_status == 1 && $runningLoanAdd->loan_complete_status == 0)
                    {
                        $installments = loan_installment::where('running_id',$runningLoanAdd->running_id)->where('loan_appl_id',$runningLoanAdd->loan_apply_id)->where('employee_id',$runningLoanAdd->client_id)->where('ins_paid_status',0)->get();
                        if (count($installments))
                        {
                            $givenIns = ($runningLoanAdd->loan_installment - count($installments)+1);
                            try {
                                $loanRunningData = ['complete_installment'=>$givenIns];
                                //if loan installment complete
                                if ($givenIns == $runningLoanAdd->loan_installment)
                                {
                                    try {
                                        $loanRunningData = [
                                            'complete_installment'=>$givenIns,
                                            'loan_complete_status'=>1,
                                        ];
                                        loan_application_list::where('loan_appl_id',$runningLoanAdd->loan_apply_id)->where('loan_appl_uesr_id',$runningLoanAdd->client_id)->update([
                                            'loan_complete_status'=>1
                                        ]);
                                    }catch (Throwable $exception)
                                    {
                                        return back()->with('error',$exception->getMessage());
                                    }
                                }
                                //when loan installment not complete
                                loan_running_lists::where('invoice_id',$runningLoanAdd->invoice_id)->update($loanRunningData);

                            }catch (Throwable $exception)
                            {
                                return back()->with('error',$exception->getMessage());
                            }
                            //installment list update
                            try {
                                loan_installment::where('running_id',$runningLoanAdd->running_id)->where('ins_number',$givenIns)->update([
                                    'ins_paid_status'   =>  1,
                                    'ins_paid_date'   =>  now(),
                                ]);
                            }catch (Throwable $exception)
                            {
                                return back()->with('error',$exception->getMessage());
                            }
                            $totalWorkPrice = $totalWorkPrice - $runningLoanAdd->installment_amount;
                            $salaryData = [
                                'sa_month' => $salaryMonth,
                                'sa_year'=>$salaryYear,
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                                'include_bonus' => $includeBonus,
                                'bonus_number' => $bonus_number,
                                'sa_amount' => $totalWorkPrice,
                                'total_hour' => $total_working_hour,
                                'per_h_rate' => $perHourRate,
                                'emp_id' => $u->id,
                                'dep_id' => $dep_id,
                                'paid_status' => 0,
                                'created_id' => Auth::user()->id,
                                'updated_id' => Auth::user()->id,
                                'add_loan'  =>  0,
                                'loan_invoice_id'  =>  $runningLoanAdd->invoice_id,
                                'add_loan_installment' => 1,
                            ];
                        }
                    }
                    else{
                        $salaryData = [
                            'sa_month' => $salaryMonth,
                            'sa_year'=>$salaryYear,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'include_bonus' => $includeBonus,
                            'bonus_number' => $bonus_number,
                            'sa_amount' => $totalWorkPrice,
                            'total_hour' => $total_working_hour,
                            'per_h_rate' => $perHourRate,
                            'emp_id' => $u->id,
                            'dep_id' => $dep_id,
                            'paid_status' => 0,
                            'created_id' => Auth::user()->id,
                            'updated_id' => Auth::user()->id,
                        ];
                    }
                    $insert_salary = salary::create($salaryData);
                    if ($insert_salary) {
                        $s_data = salary::where('sa_month', $salaryMonth)->where('start_date', date('Y-m-d',strtotime($startDate)))->where('end_date', date('Y-m-d',strtotime($endDate)))->where('sa_amount', $totalWorkPrice)->where('total_hour', $total_working_hour)->where('per_h_rate', $perHourRate)->where('emp_id', $u->id)->where('dep_id',$dep_id)->first();

                        if ($totalPfPrice)
                        {
                            if (!(provident_fund::where('pf_month',$startDate)->where('emp_id',$u->id)->first()))
                            {
                                try {
                                    $pfIns = provident_fund::create([
                                        'sa_id' =>  $s_data->sa_id,
                                        'emp_id' =>  $u->id,
                                        'pf_amount' =>  $totalPfPrice,
                                        'pf_month' =>  $startDate,
                                        'pf_year' =>  $y,
                                        'created_id' => Auth::user()->id,
                                        'updated_id' => Auth::user()->id,
                                    ]);
                                    if (!$pfIns)
                                    {
                                        $error = 2;
                                    }
                                }catch (Throwable $exception)
                                {
                                    return back()->with('error',$exception->getMessage());
                                }
                            }
                        }
                        if ($totalPtPrice)
                        {
                            if (!(professional_tax::where('pt_month',$startDate)->where('emp_id',$u->id)->first()))
                            {
                                $ptIns = professional_tax::create([
                                    'sa_id' =>  $s_data->sa_id,
                                    'emp_id' =>  $u->id,
                                    'pt_amount' =>  $totalPtPrice,
                                    'pt_month' =>  $startDate,
                                    'pt_year' =>  $y,
                                    'created_id' => Auth::user()->id,
                                    'updated_id' => Auth::user()->id,
                                ]);
                                if (!$ptIns)
                                {
                                    $error = 3;
                                }
                            }
                        }
                    }
                    else{
                        $error = 1;
                    }
                }
            }
        }
        if ($success )
        {
            if ($error == 2)
            {
                return back()->with('warning','All Possible Salary list create successful! But Provident fund add not possible');
            }
            if ($error == 3)
            {
                return back()->with('warning','All Possible Salary list create successful! But Professional tax add not possible');
            }
            return back()->with('success','All Possible Salary list create successful');
        }
        else if ($error == 1)
        {
            return back()->with('error','salary list create not possible!');
        }
        else if ($error == 10)
        {
            return back()->with('warning','Unexpected Condition are fetching! Salary list already exists');
        }
        else{
            return back()->with('error','Something want wrong!');
        }
    }
    private function secToHour($second)
    {
        $hour = (int)($second/3600);
        $extra = $second%3600;
        $min = (int)($extra/60);
        $sec = (int)($extra%60);
        return $time=['h'=>$hour,'m'=>$min,'s'=>$sec];
    }
    //search last month
    public function searchListMonth(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'dep'=>['sometimes','nullable','numeric',$this->html],
                'emp'=>['sometimes','nullable',$this->html],
            ]);
            $dep = null;
            $emp = null;
            extract($request->post());
            if ($dep == 0) $dep = null;
            $m = date('m',strtotime(now()));
            $pm = date('F',strtotime('1-'.$m-1 .'-'.date('Y')));
            $y = date('Y',strtotime('1-'.$m-1 .'-'.date('Y')));
            $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
                ->leftJoin('department as d','d.dep_id','salaries.dep_id')
                ->select('salaries.*','d.dep_name','u.name','u.email','u.employee_id','u.profile_pic')
                ->where('sa_month',$pm)
                ->where('sa_year',$y)
                ->when($emp != null and !(filter_var($emp,FILTER_VALIDATE_EMAIL)), function ($query) use ($request){
                    $query->where('u.employee_id','=',$request->post('emp'));
                })
                ->when($emp != null and (filter_var($emp,FILTER_VALIDATE_EMAIL)), function ($query) use ($request){
                    $query->where('u.email','=',$request->post('emp'));
                })
                ->when($dep != null, function ($query) use ($request){
                    $query->where('salaries.dep_id','=',$request->post('dep'));
                })
                ->get();
            return view('layouts/admin/payroll/_last_salary_table',compact('salary'));
        }
    }
    //search All List
    public function searchAllList(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'dep'=>['sometimes','nullable','numeric',$this->html],
                'emp'=>['sometimes','nullable',$this->html],
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
                ->when($emp != null and !(filter_var($emp,FILTER_VALIDATE_EMAIL)), function ($query) use ($request){
                    $query->where('u.employee_id','=',$request->post('emp'));
                })
                ->when($emp != null and (filter_var($emp,FILTER_VALIDATE_EMAIL)), function ($query) use ($request){
                    $query->where('u.email','=',$request->post('emp'));
                })
                ->when($dep != null, function ($query) use ($request){
                    $query->where('salaries.dep_id','=',$request->post('dep'));
                })
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
    //Delete last month
    public function deleteListMonth(Request $request)
    {
        if ($request->ajax())
        {
            $salarys = salary::where('start_date',$this->startDate)
                ->where('end_date',$this->endDate)->get();
            foreach ($salarys as $s)
            {
                if ($s->add_loan && $s->add_loan_installment == 0)
                {
                    try {
                        loan_running_lists::where('invoice_id',$s->loan_invoice_id)->update([
                            'many_received_status'=>0,
                            'many_received_date'=>null,
                            'many_provide_id'=>null,
                        ]);

                    }catch (Throwable $exception)
                    {
                        return "<script>alert('Something want wrong! Data delete not possible!')</script>";
                    }
                }
                elseif ($s->add_loan && $s->add_loan_installment == 1)
                {
                    $running = loan_running_lists::where('invoice_id',$s->loan_invoice_id)->first();
                    if ($running->complete_installment < $running->loan_installment)
                    {
                        $installments = loan_installment::where('running_id',$running->running_id)->where('loan_appl_id',$running->loan_apply_id)->where('employee_id',$running->client_id)->where('ins_paid_status',1)->get();
                        $givenIns = count($installments);
                        try {
                            loan_running_lists::where('invoice_id',$s->loan_invoice_id)->update([
                                'complete_installment'=>($running->loan_installment - 1),
                                'loan_complete_status'=>0,
                            ]);
                            loan_installment::where('running_id',$running->running_id)->where('loan_appl_id',$running->loan_apply_id)->where('employee_id',$running->client_id)->where('ins_paid_status',1)->where('ins_number',$givenIns)->update([
                                'ins_paid_status'   =>  0,
                                'ins_paid_date'   =>  null,
                            ]);
                        }catch (Throwable $exception)
                        {
                            return "<script>alert('Something want wrong! Data delete not possible!')</script>";
                        }

                    }
                    if ($running->complete_installment == $running->loan_installment)
                    {
                        try {
                            loan_running_lists::where('invoice_id',$s->loan_invoice_id)->update([
                                'complete_installment'=>($running->loan_installment - 1),
                                'loan_complete_status'=>0,
                            ]);
                            loan_application_list::where('loan_appl_id',$running->loan_apply_id)->where('loan_appl_uesr_id',$running->client_id)->update([
                                'loan_complete_status'=>0
                            ]);

                        }catch (Throwable $exception)
                        {
                            return "<script>alert('Something want wrong! Data delete not possible!')</script>";
                        }
                    }

                }
            }
            $salary = salary::where('start_date',$this->startDate)
                ->where('end_date',$this->endDate)->delete();
            $pf = provident_fund::where('pf_month',$this->startDate)->delete();
            $pt = professional_tax::where('pt_month',$this->startDate)->delete();
            if ($salary && $pf && $pt)
            {
                return 1;
            }
            else{
                return 0;
            }
        }
    }
    //view single salary
    public function singleSalaryView($id)
    {
        $salary = salary::leftJoin('users as u','u.id','salaries.emp_id')
            ->where('sa_id',$id)
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
        return view("admin/payroll/single-view",compact('salary','pf','pt','runningLoan','companyProtocol'));
    }
    //make salary status paid
    public function paidSalaryStatus(Request $request)
    {
        $validate = $request->validate(['*'=>['required','numeric',$this->html]]);
        extract($validate);
        try {
            salary::where('sa_id',$salary)->update(['paid_status'=>1,'updated_at'=>now()]);
            return back()->with('success','This salary paid status change successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }

    }
}
