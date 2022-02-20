<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;
    protected $fillable = ['sa_month','sa_year','start_date','end_date','include_bonus','bonus_number','sa_amount','total_hour','per_h_rate','emp_id','dep_id','paid_status','created_id','updated_id','add_loan','loan_invoice_id','add_loan_installment','created_at','updated_at',];
}
