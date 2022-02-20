<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan_application_list extends Model
{
    use HasFactory;
    protected $fillable = ['loan_appl_proposed_id','apply_date', 'loan_appl_deatils', 'loan_appl_uesr_id', 'loan_appl_status', 'loan_appl_approve_status', 'loan_appl_approve_id', 'loan_appl_approve_date'];
}
