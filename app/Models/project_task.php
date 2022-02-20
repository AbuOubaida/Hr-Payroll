<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_task extends Model
{
    use HasFactory;
    protected $fillable = ['task_team_set_id', 'task_member_id', 'task_leader_id', 'task_title', 'task_dead_line', 'task_document', 'task_details', 'task_start_at', 'task_seen_status', 'task_running_status', 'task_complete_status', 'task_status', 'task_complete_date', 'created_at', 'updated_at'];
}
