<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recruitments_list extends Model
{
    use HasFactory;
    protected $fillable = ['r_id','cv_name','cv_email','cv_phone','cv_file','cv_details',];
}
