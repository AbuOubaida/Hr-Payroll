<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Rules\Html;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\project_team;
use App\Models\team_member;
use App\Models\set_team;
use Throwable;

class projectAdminController extends Controller
{
    private $html = null;
    private $record = 10;
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
        return view('admin/project/list',compact('projects'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $projects = $this->allProject();
        $departments = $this->departments();
        return view('admin/project/add-new',compact('departments','projects'));
    }
    private function departments()
    {
        return DB::table('department')->where('status',1)->get();
    }
    private function allProject()
    {
        return project::paginate($this->record);
    }
    private function allActiveProject()
    {
        return project::where('p_status',1)->get();
    }
    private function validation(Request $request): array
    {
        return $request->validate([
            'title'=>['required','max:100',$this->html],
            'duration'=>['required','numeric','max:100',$this->html],
            'monthYear'=>['required',$this->html],
            'start'=>['required',$this->html],
            'end'=>['required',$this->html],
            'location'=>['required',$this->html],
            'dep'=>['required','numeric',$this->html],
            'details'=>['sometimes','nullable',$this->html],
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $this->validation($request);
        extract($validate);
        $start = date('Y-m-d',strtotime($start));
        $end = date('Y-m-d',strtotime($end));
        $department = DB::table('department')->where('dep_id',$dep)->first();
        if (!$department)
            return back()->with('error',"Department Dose not exists");
        $y = 0;
        $m = 0;
        if ($monthYear == 'years')
            $y = 1;
        else
            $m = 1;
        $this->duplicateCheck($validate);
        if (project::create(['p_title'=>$title,'p_description'=>$details, 'p_duration'=>$duration, 'p_year'=>$y, 'p_month'=>$m, 'p_start_date'=>$start, 'p_end_date'=>$end, 'p_location'=>$location, 'p_dep_id'=>$dep, 'p_created_id'=>Auth::user()->id, 'p_status'=>1]))
            return back()->with('success','Data add successfully');
        else
            return back()->with('error','Data add not possible');
    }
    private function duplicateCheck($request)
    {
//        ->where('p_year',$y)->where('p_month',$m)
        extract($request);
        $y = 0;
        $m = 0;
        if ($monthYear == 'years')
            $y = 1;
        else
            $m = 1;
        if (project::where('p_title',$title)->where('p_start_date',$start)->where('p_end_date',$end)->where('p_location',$location)->where('p_dep_id',$dep)->where('p_status',1)->when($y !=0, function ($query) use ($y){$query->where('p_year',$y);})->when($m !=0, function ($query) use ($m){$query->where('p_month',$m);})->first())
        {
            back()->with('warning', 'This project already exists');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id)
    {
        //
        $departments = $this->departments();
        $projects = $this->allProject();
        $project = project::where('project_id',$id)->first();
        if ($project)
        {
            return view('admin/project/view',compact('project','projects','departments'));
        }
        else{
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit($id)
    {
        $departments = $this->departments();
        $projects = $this->allProject();
        $project = project::where('project_id',$id)->first();
        if ($project)
        {
            return view('admin/project/edit',compact('project','projects','departments'));
        }
        else{
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param projects $projects
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $validate = $this->validation($request);
        $request->validate([
            'projectID'=>['required','numeric',$this->html],
            'status'=>['required','numeric',$this->html],
            ]);
        extract($request->post());
        $status == 1? $s=1: $s=0;
        $start = date('Y-m-d',strtotime($start));
        $end = date('Y-m-d',strtotime($end));
        $department = DB::table('department')->where('dep_id',$dep)->first();
        if (!$department)
            return back()->with('error',"Department Dose not exists");
        $y = 0;
        $m = 0;
        if ($monthYear == 'years') $y = 1;
        else $m = 1;
        $this->duplicateCheck($validate);
        if (project::where('project_id',$projectID)->update(['p_title'=>$title,'p_description'=>$details, 'p_duration'=>$duration, 'p_year'=>$y, 'p_month'=>$m, 'p_start_date'=>$start, 'p_end_date'=>$end, 'p_location'=>$location, 'p_dep_id'=>$dep, 'p_updated_id'=>Auth::user()->id,'p_status'=>$s]))
            return back()->with('success','Data update successfully');
        else
            return back()->with('error','Data update not possible');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        if ($id && (project::where('project_id',$id)->delete()))
        {
            return redirect('admin/project/project-list')->with('success','Data delete successfully');
        }
        else{
            return back()->with('error','Data delete not possible');
        }
    }

    //Search project small list
    public function projectSmSearch(Request $request)
    {
        $validate = $request->validate([
            'project'=>['required',$this->html],
        ]);
        extract($validate);
        $projects = project::leftjoin('department as dep', 'projects.p_dep_id','dep.dep_id')
        ->where(function ($query) use($project){
            $query->where('projects.p_title','LIKE',"%{$project}%");
            $query->orWhere('projects.p_location','LIKE',"%{$project}%");
            $query->orWhere('dep.dep_name','LIKE',"%{$project}%");
        })
        ->get();
        return view('layouts/admin/project/_project_sm_list',compact('projects'));
    }
    //Team section
    public function createTeam()
    {
        $project_managers = $this->projectManagers();
        $teams = $this->allTeams();
//        dd($project_managers);
        return view('admin/project/team/add-new',compact('project_managers','teams'));
    }
    private function projectManagers()
    {
        return User::leftjoin('role_user as r_u','users.id','r_u.user_id')->leftjoin('roles as rl','r_u.role_id','rl.id')->where('rl.name','project-manager')->where('users.status',1)->select('users.id as user_id','users.name')->get();
    }
    private function employees()
    {
        return User::leftjoin('role_user as r_u','users.id','r_u.user_id')
            ->leftjoin('roles as rl','r_u.role_id','rl.id')
            ->leftjoin('department as dep','users.dep_id','dep.dep_id')
            ->where('rl.id','>',2)
            ->where('users.status',1)
            ->select('users.id as user_id','users.name as user_name','users.employee_id','dep.dep_name')
            ->orderBy('users.name','asc')
            ->get();
    }
    private function allTeams()
    {
        return project_team::leftjoin('users as u','project_teams.team_leader_id','u.id')->select('project_teams.*','u.name as user_name','u.id as user_id')->paginate($this->record);
    }
    private function allActiveTeams()
    {
        return project_team::leftjoin('users as u','project_teams.team_leader_id','u.id')->where('team_status',1)->select('project_teams.*','u.name as user_name','u.id as user_id')->get();
    }
    //Save Team
    private function teamValidation($request)
    {
        return $request->validate([
            'title'=>['required',$this->html],
            'leader'=>['required',$this->html],
            'details'=>['sometimes','nullable',$this->html],
        ]);
    }
    private function duplicateAndLeader($request)
    {
        $team_id = null;
        extract($request);
        if (project_team::where('team_leader_id',$leader)->first())
        {
            return 'This team leader already admitted in a team';
        }
        if (project_team::where('team_title',$title)->where('team_leader_id',$leader)->when($team_id != null,function ($query) use($team_id){$query->where('team_id','!=',$team_id);})->first())
        {

            return 'This team already exists in database';
        }
        if (!(user::where('id','=',$leader)->where('status','=',1)->first()))
        {
            return 'Invalid project manager info';
        }
        return null;
    }
    private function insertTeam($request): RedirectResponse
    {
        extract($request);
        if (project_team::create(['team_title'=>$title,'team_leader_id'=>$leader,'team_details'=>$details,'team_created_id'=>Auth::user()->id]))
            return back()->with('success','Team Create Successfully');
        else
            return back()->with('error','Team Create not possible')->withInput();
    }
    public function saveTeam(Request $request): RedirectResponse
    {
        $validate = $this->teamValidation($request);
        if ($m = $this->duplicateAndLeader($validate))
            return back()->with('error',$m)->withInput();
        return $this->insertTeam($validate);
    }
    //search team
    public function searchSmTeam(Request $request)
    {
        if ($request->ajax())
        {
            $validate = $request->validate(['team'=>['required',$this->html]]);
            extract($validate);
            $teams = project_team::leftjoin('users as u','project_teams.team_leader_id','u.id')
                ->where(function ($query) use ($team){
                    $query->where('project_teams.team_title','LIKE',"%$team%");
                    $query->orWhere('u.name','LIKE',"%$team%");
                })
                ->select('project_teams.*','u.name as user_name','u.id as user_id')->get();
            return view('layouts/admin/project/team/_sm_list',compact('teams'));
        }
    }
    //Edit team
    public function editTeam($id)
    {
        if (!($team = project_team::where('team_id',$id)->first()))
        {
            return back();
        }
        $project_managers = $this->projectManagers();
        $teams = $this->allTeams();
        $employees = $this->employees();
        $projectLeader = user::where('id',$team->team_leader_id)->where('status',1)->select('name as projectLeader','id as leaderID')->first();
        $teamMembers = team_member::leftjoin('users as u','team_members.user_id','u.id')
            ->leftjoin('project_teams as pt','team_members.team_id','pt.team_id')
            ->where('team_members.team_id',$id)
            ->select('u.name as member_name','u.id as user_id','pt.team_id as team_id','pt.team_title as team_name','team_members.team_members_id')
        ->get();
        return view('admin/project/team/edit-view',compact('teams','project_managers','team','employees','teamMembers','projectLeader'));
    }
    private function teamUpdate($request): RedirectResponse
    {
        extract($request);
        if (!($team = project_team::where('team_id',$team_id)->first()))
            return back();
        if (project_team::where('team_id',$team_id)->update(['team_title'=>$title,'team_leader_id'=>$leader,'team_details'=>$details,'team_updated_id'=>Auth::user()->id,'team_status'=>$status]))
            return back()->with('success','Team Update Successfully');
        else
            return back()->with('error','Team Update not possible');
    }
    public function updateTeam(Request $request): RedirectResponse
    {
        $this->teamValidation($request);
        $request->validate(['team_id'=>['required','numeric',$this->html],'status'=>['required','numeric',$this->html],]);
        if($m = $this->duplicateAndLeader($request->post()))
            return back()->with('error',$m);
        return $this->teamUpdate($request->post());
    }
    //show team list
    public function teamList()
    {
        $teams = $this->allTeams();
        return view('admin/project/team/all-list',compact('teams'));
    }
    //Delete Team
    public function destroyTeam($id)
    {
        try {
            project_team::where('team_id',$id)->delete();
            team_member::where('team_id',$id)->delete();
            return redirect('admin/project/team-list')->with('success','Team Delete Successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error','Data delete not possible');
        }
    }
    //Save team member
    public function saveTeamMember(Request $request)
    {
        $validate = $request->validate([
            'memberInfo'=>['required','numeric',$this->html],
            'team_id'=>['required','numeric',$this->html],
        ]);
        extract($validate);
        $memberID = $memberInfo;
        if (!(user::where('status',1)->where('id',$memberID)->first()))
            return back()->with('error','Member not found!');
        if (!(project_team::where('team_status',1)->where('team_id',$team_id)->first()))
            return back()->with('error',"Team not found");
        if (team_member::where('team_id',$team_id)->where('user_id',$memberID)->first())
            return back()->with('warning','This member already in this team');
        if ($a=team_member::where('user_id',$memberID)->first())
        {
            return back()->with('warning','This member already in a team');
        }

        if (team_member::create(['team_id'=>$team_id,'user_id'=>$memberID,'created_id'=>Auth::user()->id]))
            return back()->with('success','Member add successfully');
        else
            return back()->with('error','Member add not possible');
    }
    //Delete Team Member
    public function destroyTeamMember($id)
    {
        if (team_member::where('team_members_id',$id)->delete())
            return back()->with('success','Delete successfully');
        else
            return back()->with('error','Data delete not possible');
    }
    //show all project+team
    private function showAllProjectTeam()
    {
        return set_team::leftjoin('projects as prj','set_teams.project_id','prj.project_id')
            ->leftjoin('project_teams as prjTeam','set_teams.team_id','prjTeam.team_id')
            ->leftjoin('users as u','prjTeam.team_leader_id','u.id')
            ->select('set_teams.set_teams_id','prj.project_id as p_id','prj.p_title as project_name','prjTeam.team_id as t_id','prjTeam.team_title as team_name','prjTeam.team_leader_id as leader_id','u.name as leader_name','prj.p_start_date as start_date','prj.p_end_date as end_date','set_teams.complete_status','set_teams.status')->get();
    }
    //->raw('count(*) as total')->groupBy('team_id')
    //Set team for project
    public  function setTeam()
    {
        $teamMembers = team_member::groupBy('team_id')->select('team_id',DB::raw('count(*) as total'))->get();
        $set_team_info = $this->showAllProjectTeam();
        $teams = $this->allActiveTeams();
        $projects = $this->allActiveProject();
//        dd($set_team_info);
        return view('admin/project/team/set-team',compact('teams','projects','teamMembers','set_team_info'));
    }
    //save set team
    public function saveSetTeam(Request $request)
    {
        $validate = $request->validate([
            'teamID'=>['required','numeric',$this->html],
            'projectID'=>['required','numeric',$this->html],
        ]);
        extract($validate);
        if (!(project_team::where('team_id',$teamID)->where('team_status',1)->first()))
            return back()->with('error','Team not found');
        if (!(project::where('project_id',$projectID)->where('p_status',1)->first()))
            return back()->with('error','Project not found');
        if (set_team::where('team_id',$teamID)->where('project_id',$projectID)->first())
            return back()->with('warning','Data already exist');

        if (set_team::where('status',1)->where(function ($q) use($projectID,$teamID){$q->where('team_id',$teamID);$q->orWhere('project_id',$projectID);})->first())
            return back()->with('warning','This team/project already assign');

        if (set_team::create(['team_id'=>$teamID,'project_id'=>$projectID,'created_id'=>Auth::user()->id]))
            return back()->with('success','Team create successfully');
        else
            return back()->with('error','Team create not possible');
    }
    //delete set team
    public function setTeamDelete($id)
    {
        try {
            set_team::where('set_teams_id',$id)->where('complete_status','!=',1)->update([
                'status'=>0,
                'complete_status'=>2,
            ]);
            return back()->with('success','Data delete successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
