<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recruitments_admit_list extends Model
{
    use HasFactory;
    protected $fillable = ['cv_id', 'r_id', 'seen_status', 'cv_name', 'cv_email', 'cv_phone', 'cv_file', 'cv_details', 'created_at', 'updated_at'];
}
