<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provident_fund extends Model
{
    use HasFactory;
    protected $fillable = ['sa_id','emp_id','pf_amount','pf_month','pf_year','created_at','updated_at','created_id','updated_id'];
}
