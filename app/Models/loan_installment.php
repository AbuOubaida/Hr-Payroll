<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan_installment extends Model
{
    use HasFactory;
    protected $fillable = ['running_id', 'loan_appl_id', 'proposed_loan_id', 'loan_amount', 'ins_amount', 'employee_id', 'ins_paid_status', 'ins_paid_date', 'ins_number', 'created_at', 'updated_at'];
}
