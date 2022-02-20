<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_position extends Model
{
    use HasFactory;
    protected $fillable = ['position_status','position_name','position_details'];
}
