<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    use HasFactory;
    protected $fillable = ['grade_title','grade_short_title','grade_status','grade_details','grade_basic','grade_ta','grade_da','grade_hra','grade_mda','grade_bonus','grade_bonus_no','grade_prd_fund','grade_pro_tax','created_at','updated_at','create_id','update_id'];
}
