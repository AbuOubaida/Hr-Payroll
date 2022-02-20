<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposed_loan extends Model
{
    use HasFactory;
    protected $fillable = ['proposed_loan_title', 'proposed_loan_type_id', 'proposed_loan_amount', 'proposed_loan_status','proposed_loan_details', 'proposed_loan_add_id', 'proposed_loan_update_id', 'created_at', 'updated_at'];
}
