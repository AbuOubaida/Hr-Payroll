<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class professional_tax extends Model
{
    use HasFactory;
    protected $fillable = ['sa_id','emp_id','pt_amount','pt_month','pt_year','created_at','updated_at','created_id','updated_id'];
}
