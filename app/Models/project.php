<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'p_title','p_description',  'p_duration', 'p_year', 'p_month', 'p_start_date', 'p_end_date', 'p_location', 'p_dep_id', 'p_created_id', 'p_updated_id', 'created_at', 'updated_at', 'p_status'];
}
