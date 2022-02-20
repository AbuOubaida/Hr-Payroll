<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class public_holiday extends Model
{
    use HasFactory;
    protected $fillable = ['p_h_name','p_h_day','p_h_date','p_h_type','p_h_comment','created_id','updated_id','created_at','updated_at'];
}
