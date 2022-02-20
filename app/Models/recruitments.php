<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recruitments extends Model
{
    use HasFactory;
    protected $fillable = ['status','r_title','r_vacancies','r_start_at','r_end_at','r_c_email','r_c_phone_code','r_c_phone','r_dep_id','r_doc','salary_range','location','r_details','created_id'];
}
