<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan_running_lists extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'invoice_id','loan_year','add_loan_month','add_installment_month', 'loan_apply_id', 'loan_id', 'loan_amount', 'loan_installment', 'complete_installment', 'loan_complete_status', 'loan_status', 'installment_amount'];
}
