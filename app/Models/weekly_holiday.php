<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weekly_holiday extends Model
{
    use HasFactory;
    protected $fillable =['no_of_holiday','created_id','updated_id'];
}
