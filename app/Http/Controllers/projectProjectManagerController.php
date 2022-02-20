<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\project_task;
use App\Models\project_team;
use App\Models\set_team;
use App\Models\team_member;
use App\Rules\Html;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use function Symfony\Component\String\b;
use function Symfony\Component\Translation\t;

class projectProjectManagerController extends Controller
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
        $projects = $this->allProject();
        return view('project-manager/project/list',compact('projects'));
    }
    private function allProject()
    {
        return DB::table('set_teams as st')
            ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
            ->leftJoin('projects as p','p.project_id','st.project_id')
            ->where('pt.team_leader_id',Auth::user()->id)
            ->where('st.status',1)->where('p.p_status',1)->where('pt.team_status',1)
            ->orderBy('st.set_teams_id','desc')
            ->get();
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
            $project =  $this->getSingleProjectBySetTeamId($id);
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
        try {
            $teamMembers =  $this->getTeamMemberBySetTeamId($id);
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
        try {
            $tasks = $this->getAllTaskBySetTeamID($id);
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
        if ($project && $teamMembers && $tasks)
        {
            try {
                $team = set_team::leftJoin('project_teams as pt','pt.team_id','set_teams.team_id')
                    ->where('set_teams.set_teams_id',$id)
                    ->where('pt.team_leader_id',Auth::user()->id)
                    ->select('set_teams.team_id')
                    ->first();
                $teamID = $team->team_id;
                try {
                    set_team::where('team_id',$teamID)->where('project_id',$project->project_id)->update(['seen_status'=>1]);
                }catch (Throwable $exception)
                {
                    return back()->with('error',$exception->getMessage());
                }
            }catch (Throwable $exception)
            {
                return back()->with('error',$exception->getMessage());
            }
//            dd($tasks);
            return view('project-manager/project/view',compact('project','teamMembers','tasks'));
        }
        else
            return redirect('project-manager/project/project-list');
    }
    //search task
    public function taskSearch(Request $request)
    {
        if ($request->ajax())
        {
            $validate = $request->validate(['*'=>['sometimes','nullable',$this->html]]);
            extract($validate);
            $id = $abc;
            $tasks = DB::table('project_tasks as ptt')
                ->leftJoin('set_teams as st','st.set_teams_id','ptt.task_team_set_id')
                ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
                ->leftJoin('team_members as tm','tm.team_id','pt.team_id')
                ->leftJoin('users as u', 'u.id','tm.user_id')
                ->where('st.set_teams_id',$id)
                ->when($team, function ($query) use ($team){
                    $query->where('ptt.task_title','LIKE',"%{$team}%");
                    $query->orWhere('u.name','LIKE',"%{$team}%");
                })
                ->select('ptt.*','u.name as member_name')
                ->get();
//            dd($tasks);
            return view('layouts.project-manager.project.task._task_sm_list',compact('tasks'));
        }
    }
    //get single project
    private function getSingleProjectBySetTeamId($id)
    {
        return DB::table('set_teams as st')
            ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
            ->leftJoin('projects as p','p.project_id','st.project_id')
            ->leftJoin('department as d','d.dep_id','p.p_dep_id')
            ->where('pt.team_leader_id',Auth::user()->id)
            ->where('st.status',1)
            ->where('p.p_status',1)
            ->where('pt.team_status',1)
            ->where('st.set_teams_id',$id)
            ->select('st.complete_status as st_complete','st.*','pt.*','p.*','d.dep_name','d.dep_id',
                DB::raw("(SELECT count(*) FROM team_members
                          WHERE team_members.team_id = st.team_id
                        ) as team_member")
            )
            ->first();
    }
    //get team members by project id
    private function getTeamMemberBySetTeamId($id): Collection
    {
        return DB::table('set_teams as st')
            ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
            ->leftJoin('team_members as tm','tm.team_id','pt.team_id')
            ->leftJoin('users as u','tm.user_id','u.id')
            ->leftJoin('department as dep','u.dep_id','dep.dep_id')
            ->where('pt.team_leader_id',Auth::user()->id)
            ->where('st.status',1)
            ->where('pt.team_status',1)
            ->where('st.set_teams_id',$id)
            ->select('tm.*','u.id','u.name','u.employee_id','u.email','u.phone_code','u.phone','dep.dep_name','pt.team_title')
            ->get();
    }
    //get departments
    private function departments(): Collection
    {
        return DB::table('department')->where('status',1)->get();
    }
    //all task
    private function getAllTaskBySetTeamID($id)
    {
        return DB::table('project_tasks as ptt')
            ->leftJoin('set_teams as st','st.set_teams_id','ptt.task_team_set_id')
//            ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
            ->leftJoin('team_members as tm','tm.team_members_id','ptt.task_member_id')
            ->leftJoin('users as u', 'u.id','tm.user_id')
            ->where('st.set_teams_id',$id)
            ->where('ptt.task_leader_id',Auth::user()->id)
//            ->where('ptt.task_member_id','tm.team_members_id')
            ->select('ptt.*','u.name as member_name')
            ->orderBy('ptt.task_id','desc')
            ->paginate($this->record);
    }
    //save task
    public function storeTask(Request $request)
    {
        $validate = $request->validate([
            't_title' => ['required',$this->html],
            'deadline' => ['sometimes','nullable',$this->html],
            'member_id' => ['required','numeric',$this->html],
            'project_set_id' => ['required','numeric',$this->html],
            'team' => ['required','numeric',$this->html],
            'document' => ['sometimes','nullable','mimes:pdf,text,doc,docx'],
            'details' => ['sometimes','nullable',$this->html],
        ]);
        extract($validate);

        //data duplicate validation
        if (project_task::where('task_team_set_id',$project_set_id)->where('task_title',$t_title)->where('task_leader_id',Auth::user()->id)->first())
            return back()->with('warning','This task title for this project already exist in Database')->withInput();

        //project active validation
        $set_team = set_team::where('set_teams_id',$project_set_id)->where('status',1)->where('complete_status',0)->first();
        if (!$set_team)
            return back()->with('error','Project not found');

        //project leader validation
        $projectTeam = project_team::join('set_teams as st','project_teams.team_id','st.team_id')->where('project_teams.team_leader_id',Auth::user()->id)->where('project_teams.team_id',$team)->where('project_teams.team_status',1)->first();
        if (!$projectTeam)
            return back()->with('error','This team leader is not for this project');

        //Team member validation
        $teamMember = team_member::where('user_id',$member_id)->where('team_id',$projectTeam->team_id)->first();
        if (!$teamMember)
            return back()->with('error','This member is not under your team');

        //make data in array
        $data = [
            'task_team_set_id'  =>  $set_team->set_teams_id,
            'task_member_id'    =>  $teamMember->team_members_id,
            'task_leader_id'    =>  $projectTeam->team_leader_id,
            'task_title'        =>  $t_title,
            'task_dead_line'    =>  $deadline,
            'task_document'     =>  null,
            'task_details'      =>  $details,
            'task_start_at'     =>  date(now()),
            'task_status'       =>  1,
        ];
        //if it has documented
        if (@$document)
        {
            $doc_name = $t_title.'_'.Str::random(30).$project_set_id.'_'.$document->getClientOriginalName();
            $document->move(public_path($this->filePath),$doc_name);
            $data['task_document'] = $doc_name;
        }
        //Insert Data
        try {
            project_task::create($data);
            return back()->with('success','Task insert successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }
    //view task
    public function taskView($id)
    {
        $task = DB::table('project_tasks as ptt')
            ->leftJoin('set_teams as st','st.set_teams_id','ptt.task_team_set_id')
            ->leftJoin('projects as p','p.project_id','st.project_id')
            ->leftJoin('project_teams as pt','pt.team_id','st.team_id')
            ->leftJoin('team_members as tm','tm.team_members_id','ptt.task_member_id')
            ->leftJoin('users as u', 'u.id','tm.user_id')
            ->where('ptt.task_id',$id)
            ->where('ptt.task_leader_id',Auth::user()->id)
//            ->where('st.set_teams_id','ptt.task_team_set_id')
//            ->where('ptt.task_member_id','tm.team_members_id')
            ->select('ptt.*','tm.*','pt.*','p.*','u.name as member_name','u.employee_id as member_id')
            ->first();
//        dd($task);
        if ($task)
            return view('project-manager/project/view-task',compact('task'));
        else
            return redirect('project-manager/project/project-list');
    }
    //Delete task
    public function deleteTask(Request $request)
    {
        $validate = $request->validate(['*'=>['required',$this->html]]);
        extract($validate);
        $task = project_task::where('task_id',$task_id)->where('task_leader_id',Auth::user()->id)->first();
        $task_team_set_id = $task->task_team_set_id;
        try {
            project_task::where('task_id',$task_id)->where('task_leader_id',Auth::user()->id)->where('task_running_status',0)->where('task_complete_status',0)->delete();
            return redirect("project-manager/project/view-project/$task_team_set_id")->with('success','Task Delete Successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    //Show Team List
    public function showTeamList()
    {
        $team = project_team::leftJoin('set_teams as st','st.team_id','project_teams.team_id')
            ->where('team_leader_id',Auth::user()->id)
            ->select('st.set_teams_id')
            ->first();
        $id = $team->set_teams_id;
        $teamMembers =  $this->getTeamMemberBySetTeamId($id);
        return view("project-manager/project/team-list",compact('teamMembers'));
    }
    // Project complete status update
    public function updateCompleteStatus(Request $request)
    {
        $validate = $request->validate([
            'project_id'    =>'required','numeric',$this->html,
            'set_team_id'  =>'required','numeric',$this->html,
            ]
        );

        extract($validate);
        try {
            set_team::where('set_teams_id',$set_team_id)->where('project_id',$project_id)->update(['complete_status'=>1]);
            return back()->with('success','Project Complete Status Update Successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
