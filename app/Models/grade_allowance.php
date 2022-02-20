<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grade_allowance extends Model
{
    use HasFactory;
    protected $fillable = ['grade_id','ta','da','hra','mda','bonus','pf','pt','status','created_at','updated_at'];
}
