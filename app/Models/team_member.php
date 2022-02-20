<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team_member extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'user_id', 'created_id'];
}
