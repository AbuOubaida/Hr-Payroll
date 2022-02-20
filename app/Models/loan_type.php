<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan_type extends Model
{
    use HasFactory;
    protected $fillable = ['loan_type_title', 'loan_type_duration', 'loan_type_month', 'loan_type_year', 'loan_type_installment', 'loan_type_add_id', 'loan_type_update_id', 'loan_type_status',];
}
