<?php

namespace App\Http\Controllers;

use App\Models\project_task;
use App\Models\set_team;
use App\Models\team_member;
use App\Rules\Html;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use function Symfony\Component\String\b;

class projectEmployeeController extends Controller
{
    private $html = null;
    private $record = 10;
    private $filePath = 'file/project-manager/task/';
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        try {
            $myTeam = team_member::where('user_id',Auth::user()->id)->first();
            if (!$myTeam)
                return redirect(url('/employee'));
            $projects = $this->allProject($myTeam->team_id);
//            dd($projects);
            return view('employee/project/list',compact('projects'));
        }catch (Throwable $exception)
        {
            return redirect(url('/employee'))->with('error',$exception->getMessage());
        }
    }
    private function allProject($teamID)
    {
        try {
            return DB::table('set_teams as st')
                ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
                ->leftJoin('users as u','u.id','pt.team_leader_id')
                ->leftJoin('projects as p','p.project_id','st.project_id')
                ->where('st.team_id',$teamID)
                ->where('st.status',1)
                ->where('p.p_status',1)
                ->where('pt.team_status',1)
                ->select('st.*','pt.*','p.*','u.name','u.id as leader_id')
                ->orderBy('st.set_teams_id','desc')
                ->get();
        }catch (Throwable $exception)
        {
            return $exception;
        }

    }
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id /*set team id*/)
    {
        try {
            $myTeam = team_member::where('user_id',Auth::user()->id)->first();
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
        if (!$myTeam)
            return redirect(url('/employee'));
        try {
            $project = $this->getSingleProjectById($id,$myTeam->team_id);
            if (!$project)
            {
                return back();
            }
            $tasks = project_task::where('task_team_set_id',$project->set_teams_id)->where('task_member_id',$myTeam->team_members_id)->orderBy('task_id','desc')->get();
//            dd($tasks);
            return view('employee/project/view',compact('project','tasks'));
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    //get single project
    private function getSingleProjectById($id,$teamID)
    {
        return DB::table('set_teams as st')
            ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
            ->leftJoin('users as u','u.id','pt.team_leader_id')
            ->leftJoin('projects as p','p.project_id','st.project_id')
            ->where('p.project_id',$id)
            ->where('st.team_id',$teamID)
            ->where('st.status',1)
            ->where('p.p_status',1)
            ->where('pt.team_status',1)
            ->select('st.complete_status as st_complete','st.*','pt.*','p.*','u.name','u.id as leader_id')
            ->orderBy('st.set_teams_id','desc')
            ->first();

    }
    //view task
    public function taskView($taskId)
    {
        try {
            $myTeam = team_member::where('user_id',Auth::user()->id)->first();
            try {
                project_task::where('task_id',$taskId)->where('task_member_id',$myTeam->team_members_id)->update(['task_seen_status'=>1]);
                $task = project_task::where('task_id',$taskId)->where('task_member_id',$myTeam->team_members_id)->first();
                return view('employee/project/view-task',compact('task'));
            }catch (Throwable $exception)
            {
                return back()->with('error',$exception->getMessage());
            }
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }

    }
    public function startTask(Request $request)
    {
        $validate = $request->validate(['*'=>['required','numeric',$this->html]]);
        extract($validate);//task_id
        $myTeam = team_member::where('user_id',Auth::user()->id)->first();
        try {
            project_task::where('task_id',$task_id)->where('task_member_id',$myTeam->team_members_id)->update(['task_running_status'=>1]);
            return back()->with('success','Task start successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function completeTask(Request $request)
    {
        $validate = $request->validate(['*'=>['required','numeric',$this->html]]);
        extract($validate);//task_id
        $myTeam = team_member::where('user_id',Auth::user()->id)->first();
        try {
            project_task::where('task_id',$task_id)->where('task_member_id',$myTeam->team_members_id)->where('task_running_status',1)->update([
                'task_complete_status'=>1,
                'task_complete_date'=>now(),
            ]);
            return back()->with('success','Task complete successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
