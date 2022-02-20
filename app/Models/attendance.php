<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id','working_hour_in_day','year','month','month_name','date','day_name','entry_hour','entry_minute','entry_second','leave_hour','leave_minute','leave_second','entry_time','leave_time','attend_entry_id','attend_leave_id','created_at','updated_at'];
}
