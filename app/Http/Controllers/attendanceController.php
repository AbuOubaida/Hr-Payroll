<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\cmp_protocol;
use App\Models\User;
use App\Models\weekly_holiday_name;
use App\Rules\Html;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class attendanceController extends Controller
{
    private $html = null;
    private $record = 10;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    private function weeklyHoliday($day)
    {
        return weekly_holiday_name::where('holiday_name',$day)->first();
    }
    private function publicHoliday($date)
    {
        return DB::table('public_holidays')->where('p_h_date',$date)->first();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $day = date('l',strtotime(now()));
        $date = date('Y-m-d',strtotime(now()));
        $weekly_holiday = $this->weeklyHoliday($day);
        $public_holiday = $this->publicHoliday($date);
        $to_day_att = $this->attendanceListOfTheDay();
//        dd($to_day_att);
        return view('admin/attendance/add-attendance',compact('weekly_holiday','public_holiday','to_day_att'));
    }
//Store entry employee
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'v' => ['required', $this->html]
        ]);
        extract($request->post());
        $day = date('l', strtotime(now()));
        $date = date('Y-m-d', strtotime(now()));
        $weekly_holiday = $this->weeklyHoliday($day);
        $public_holiday = $this->publicHoliday($date);
        if ($weekly_holiday || $public_holiday) {
            return back()->with('warning', 'This day is Holiday.No need to attendance call');
        } else {
            $employee = User::where('status', 1)->where('dep_id', '!=', null)->where('salary_grade_id', '!=', null)->where(function ($query) use ($v) {
                $query->where('email', '=', $v);
                $query->orWhere('employee_id', '=', $v);
            })->select('id','name')->first();
            if (!$employee) {
                return back()->with('error', 'Employee not Found')->withInput();
            }
            $toDayAttendance = attendance::where('employee_id', '=', $employee->id)
                ->where('year', '=', date('Y', strtotime(now())))
                ->where('month', '=', date('m', strtotime(now())))
                ->where('date', '=', date('d', strtotime(now())))
                ->first();

            if (@$leave) {

                if (!$toDayAttendance) {
                    return back()->with('error', 'This person attendance is not entry in the day! Please Entry');
                }
                if (attendance::where('employee_id', '=', $employee->id)
                    ->where('year', '=', date('Y', strtotime(now())))
                    ->where('month', '=', date('m', strtotime(now())))
                    ->where('date', '=', date('d', strtotime(now())))
                    ->where('leave_time', '!=', null)
                    ->first())
                {
                    return back()->with('warning', 'This parson already leave in the day');
                }

                $workingHourArr = $this->timeCalculation($toDayAttendance->entry_time);
                $workingHour = $workingHourArr['hour'] . ':' . $workingHourArr['min'] . ':' . $workingHourArr['sec'];
                $workingHour = date('H:i:s',strtotime($workingHour));
                $protocol = cmp_protocol::first();
                $daily_w_h = $protocol->daily_working_hour<10?'0'.$protocol->daily_working_hour:$protocol->daily_working_hour;
                $daily_w_h += 1;
                $daily_w_h .= ':00:00';
                $w_h_max = date('H:i:s',strtotime($daily_w_h));
                if ($workingHour >= $w_h_max)
                {
                    $workingHour = $w_h_max;
                }
                $update = attendance::where('employee_id', '=', $employee->id)
                    ->where('year', '=', date('Y', strtotime(now())))
                    ->where('month', '=', date('m', strtotime(now())))
                    ->where('date', '=', date('d', strtotime(now())))
                    ->where('entry_hour', '!=', null)
                    ->where('entry_minute', '!=', null)
                    ->where('entry_time', '!=', null)
                    ->update([
                        'working_hour_in_day' => @$workingHour,
                        'leave_hour' => date('H', strtotime(now())),
                        'leave_minute' => date('i', strtotime(now())),
                        'leave_second' => date('s', strtotime(now())),
                        'leave_time' => now(),
                        'attend_leave_id' => Auth::user()->id
                    ]);
                if ($update)
                {
                    return back()->with('success',"Attendance Leave Successful for {$employee->name}");
                }
                else{
                    return back()->with('error','Data store not possible');
                }
            } elseif (@$entry) {
                if ($toDayAttendance) {
                    return back()->with('warning', 'This parson attendance already exist');
                }
                $store = attendance::create([
                    'employee_id' => $employee->id,
                    'year' => date('Y', strtotime(now())),
                    'month' => date('m', strtotime(now())),
                    'month_name' => date('F', strtotime(now())),
                    'date' => date('d', strtotime(now())),
                    'day_name' => date('l', strtotime(now())),
                    'entry_hour' => date('H', strtotime(now())),
                    'entry_minute' => date('i', strtotime(now())),
                    'entry_second' => date('s', strtotime(now())),
                    'entry_time' => now(),
                    'attend_entry_id' => Auth::user()->id
                ]);
                if ($store)
                {
                    return back()->with('success',"Attendance Entry Successful for {$employee->name}");
                }
                else{
                    return back()->with('error','Data store not possible');
                }
            } else {
                return back();
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show()
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
            ->paginate(50);
//        dd($attendance);
        return view('admin/attendance/attendance-list',compact('attendance','year','month','date','department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(attendance $attendance)
    {
        //
    }
    //search employee
    private function empInDb($value)
    {
        return User::leftJoin('department as d','users.dep_id','d.dep_id')
        ->leftJoin('employee_positions as p','users.position_id','=','p.position_id')
        ->leftJoin('grades as g','users.salary_grade_id','=','g.grade_id')
        ->where('users.status',1)->where('users.dep_id','!=',null)->where('users.salary_grade_id','!=',null)->where(function ($query) use($value){
            $query->where('email','=',$value);
            $query->orWhere('employee_id','=',$value);
        })->select(
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
            'g.grade_short_title as grd_short')->first();
    }
    public function searchEmp(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'v'=>['required',$this->html]
            ]);

            extract($request->post());
            $employee = $this->empInDb(@$v);
            $workingHour = DB::table('cmp_protocols')->select('daily_entry_time as det','daily_leave_time as dlt','daily_working_hour as dwh')->first();
            $late = null;
            $first = null;
            if (strtotime(date('H:i:s')) > strtotime($workingHour->det))
            {
                //late entry
                $time = $this->timeCalculation($workingHour->det);
                if ($time['min'] > 30 || $time['hour'] >= 1)
                {
                    $late = $time;
                }
            }
            else{
                // Note late
                $first = $this->timeCalculation($workingHour->det);
            }
            return view('layouts/admin/attendance/_view_employee_info',compact('employee','workingHour','late','first'));
        }
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

    //Show Attendance List of the day
    private function attendanceListOfTheDay()
    {
        return attendance::leftJoin('users', 'attendances.employee_id', 'users.id')
            ->leftJoin('department as d', 'users.dep_id', 'd.dep_id')
            ->leftJoin('employee_positions as p', 'users.position_id', '=', 'p.position_id')
            ->leftJoin('grades as g', 'users.salary_grade_id', '=', 'g.grade_id')
            ->where('users.status', 1)
            ->where('attendances.entry_time', '!=', null)
            ->select(
                'attendances.attend_id',
                'attendances.entry_time',
                'attendances.leave_time',
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
            ->whereRaw('Date(attendances.entry_time) = CURDATE()')
            ->orderby('attendances.updated_at',"desc")
            ->paginate($this->record);
    }
    //single view of attendance
    private function singleView($id)
    {
        return attendance::leftJoin('users', 'attendances.employee_id', 'users.id')
            ->leftJoin('department as d', 'users.dep_id', 'd.dep_id')
            ->leftJoin('employee_positions as p', 'users.position_id', '=', 'p.position_id')
            ->leftJoin('grades as g', 'users.salary_grade_id', '=', 'g.grade_id')
            ->where('users.status', 1)
            ->where('attendances.entry_time', '!=', null)
            ->where('attendances.attend_id', '=', $id)
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
        return view('admin/attendance/single-view',compact('data','first','late'));
    }
    //
    public function filterAttendance(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'emp'=>['sometimes','nullable',$this->html],
                'year'=>['sometimes','nullable','numeric',$this->html],
                'month'=>['sometimes','nullable',$this->html],
                'date'=>['sometimes','nullable','numeric',$this->html],
                'dep'=>['sometimes','nullable','numeric',$this->html],
            ]);
            $emp = null;
            $year = null;
            $month = null;
            $date = null;
            $dep = null;
            extract($request->post());
            $attendance = attendance::leftJoin('users', 'attendances.employee_id', 'users.id')
                ->leftJoin('department as d', 'users.dep_id', 'd.dep_id')
                ->leftJoin('employee_positions as p', 'users.position_id', '=', 'p.position_id')
                ->leftJoin('grades as g', 'users.salary_grade_id', '=', 'g.grade_id')
                ->where('users.status', 1)
                ->where('attendances.entry_time', '!=', null)
                ->when($emp != null and !(filter_var($emp,FILTER_VALIDATE_EMAIL)),function ($query) use ($request){
                    $query->where('users.employee_id','=',$request->post('emp'));
                })
                ->when($emp != null and (filter_var($emp,FILTER_VALIDATE_EMAIL)),function ($query) use ($request){
                    $query->where('users.email','=',$request->post('emp'));
                })
                ->when($year != null,function ($query) use ($request){
                    $query->where('attendances.year','=',$request->post('year'));
                })
                ->when($month != null,function ($query) use ($request){
                    $query->where('attendances.month_name','=',$request->post('month'));
                })
                ->when($date != null,function ($query) use ($request){
                    $query->where('attendances.date','=',$request->post('date'));
                })
                ->when($dep != null,function ($query) use ($request){
                    $query->where('d.dep_id','=',$request->post('dep'));
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
            return view('layouts/admin/attendance/_employee_filter_list',compact('attendance'));
        }
    }
}
