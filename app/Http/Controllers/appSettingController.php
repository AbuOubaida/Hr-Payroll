<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\day;
use App\Models\weekly_holiday;
use Illuminate\Support\Facades\Auth;
use App\Rules\Html;
use App\Models\weekly_holiday_name;
use App\Models\public_holiday;
use Illuminate\Support\Facades\DB;

class appSettingController extends Controller
{
    private $html = null;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    public function general()
    {
        $days = day::all();
        $no_holiday = weekly_holiday::first();
        $w_h_n = weekly_holiday_name::all();
        $public_holiday = public_holiday::paginate(20);
        $protocol = DB::table('cmp_protocols')->first();
        return view('admin/app/setting/general',compact('days','no_holiday','w_h_n','public_holiday','protocol'));
    }
    public function storeHoliday(Request $request)
    {
        $request->validate(['no_holiday'=>['required','numeric',$this->html]]);
        extract($request->post());
        if (@$no_holiday>3 || $no_holiday<0)
        {
            return back()->with('error','Weekly Holiday can not Greater than 3 Days And Less than 0 Day');
        }
        if (weekly_holiday::first())
        {
            //update
            if (weekly_holiday::where('wk_holiday_id',$wk_h_id)->update(['no_of_holiday'=>@$no_holiday, 'updated_id'=>Auth::user()->id, 'updated_at'=>now(),]))
            {
                weekly_holiday_name::truncate();
                return back()->with('success','Data Update Successful');
            }
            else{
                return back()->with('error','Data Update Not Possible');
            }
        }
        else{
            //insert
            if(weekly_holiday::create(['no_of_holiday'=>@$no_holiday, 'created_id'=>Auth::user()->id, 'updated_id'=>Auth::user()->id, 'created_at'=>now(), 'updated_at'=>now(),]))
            {
                weekly_holiday_name::truncate();
                return back()->with('success','Data Update Successful');
            }
            else{
                return back()->with('error','Data Update Not Possible');
            }
        }
    }
    public function storeHolidayName(Request $request)
    {
        $request->validate(['*' => ['required', $this->html]]);
        $day1 = null;
        $day2 = null;
        $day3 = null;
        $n = extract($request->post());
        $no_holiday = weekly_holiday::first()->no_of_holiday;
        $w_h_n = weekly_holiday_name::all();
        if(count($w_h_n))
        {
            //update
            $i=1;
            foreach ($w_h_n as $name)
            {
                $day = "day".$i++;
                weekly_holiday_name::where('weekly_holida_name_id',$name->weekly_holida_name_id)->update([
                    'holiday_name'=>$$day,
                    'updated_id'=>Auth::user()->id,
                    'updated_at'=>now(),
                ]);
            }
            return back()->with('success','Data Update Successful');
        }
        else{
            //Insert
            for ($i=1;$i<=$n;$i++)
            {
                $day = "day".$i;
                weekly_holiday_name::create([
                    'holiday_name'=>$$day,
                    'created_id'=>Auth::user()->id,
                    'updated_id'=>Auth::user()->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),

                ]);
            }
            return back()->with('success','Data Add Successful');
        }

    }
    //store public holiday
    public function storePublicHoliday(Request $request)
    {
        $request->validate([
            'h_name' => ['required', $this->html],
            'day' => ['required', $this->html],
            'date' => ['required', $this->html],
            'type' => ['sometimes','nullable', $this->html],
            'comment' => ['sometimes','nullable', $this->html],
        ]);
        extract($request->post());
        if (public_holiday::where('p_h_day',$date)->where('p_h_name',$h_name)->first())
        {
            return back()->with('error','This Day already exists in database');
        }
        $store = public_holiday::create([
            'p_h_name'=>$h_name,
            'p_h_day'=>$day,
            'p_h_date'=>$date,
            'p_h_type'=>$type,
            'p_h_comment'=>$comment,
            'created_id'=>Auth::user()->id,
            'updated_id'=>Auth::user()->id,
        ]);
        if ($store)
        {
            return back()->with('success','Data added successful');
        }
        else{
            return back()->with('error','Data add not possible');
        }
    }
    //delete public holiday
    public function deletePublicHoliday($id)
    {
        if (public_holiday::where('p_h_id',$id)->delete())
        {
            return back()->with('success','Data delete successful');
        }
        return back()->with('error','Data delete not possible');
    }
    //Save protocol
    public function saveProtocol(Request $request)
    {
        $request->validate([
            's_date' => ['required','numeric', $this->html],
            'entry_time' => ['required', $this->html],
            'w_hour' => ['required','numeric', $this->html],
            'leave_time' => ['required', $this->html],
            'working_day' => ['required','numeric', $this->html],
        ]);
        extract($request->post());
        if (DB::table('cmp_protocols')->first())
        {
            //update
            if(DB::table('cmp_protocols')->update([
                'salary_date'=>$s_date,
                'daily_entry_time'=>$entry_time,
                'daily_leave_time'=>$leave_time,
                'daily_working_hour'=>$w_hour,
                'monthly_working_day'=>$working_day,
                'created_id'=>Auth::user()->id,
                'updated_id'=>Auth::user()->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]))
            {
                return back()->with('success','Data add successful');
            }
            return back()->with('error','Data add not possible');
        }
        else{
            //create
            if(DB::table('cmp_protocols')->insert([
                'salary_date'=>$s_date,
                'daily_entry_time'=>$entry_time,
                'daily_leave_time'=>$leave_time,
                'daily_working_hour'=>$w_hour,
                'monthly_working_day'=>$working_day,
                'created_id'=>Auth::user()->id,
                'updated_id'=>Auth::user()->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]))
            {
                return back()->with('success','Data add successful');
            }
            return back()->with('error','Data add not possible');
        }
    }
}
