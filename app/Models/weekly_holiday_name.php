<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weekly_holiday_name extends Model
{
    use HasFactory;
    protected $fillable =['holiday_name','holiday_reason','created_id','updated_id','created_at','updated_at'];
}
