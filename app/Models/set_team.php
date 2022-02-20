<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class set_team extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'project_id', 'created_id', 'updated_id'];
}
