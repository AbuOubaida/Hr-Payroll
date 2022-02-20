<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_team extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'team_title', 'team_leader_id', 'team_details', 'team_created_id', 'team_updated_id', 'created_at', 'updated_at', 'team_status'];
}
