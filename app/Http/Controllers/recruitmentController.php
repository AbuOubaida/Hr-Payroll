<?php

namespace App\Http\Controllers;

use App\Models\recruitments;
use App\Rules\Html;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Location;
use App\Models\recruitments_list;

class recruitmentController extends Controller
{
    private $html = null;
    private $record = 10;
    private $filePath = 'file/admin/recruitments/';
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    /**
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $ip = \Request::ip();
        $userLocation = Location::get($ip);
        $country = DB::table('country')->get();
        if (!$country)
            $country = null;
        $departments = $this->getActiveDepartments();
        return view('admin/recruitment/create',compact('userLocation','country','departments'));
    }
    private function getActiveDepartments(): \Illuminate\Support\Collection
    {
        return DB::table('department')->where('status',1)->select('dep_name as d_name','dep_id as d_id')->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'title'=>['required','max:100',$this->html],
            'vacancies'=>['required','numeric',$this->html],
            'start'=>['required',$this->html],
            'end'=>['required',$this->html],
            'email'=>['required','email','max:255',$this->html],
            'countryCode'=>['required','numeric',$this->html],
            'phone'=>['required','numeric','digits:10',$this->html],
            'dep'=>['required','numeric',$this->html],
            'location'=>['required',$this->html],
            'salary'=>['required','numeric',$this->html],
            'details'=>['sometimes','nullable',$this->html],
            'doc'=>'mimes:jpeg,jpg,pdf,text|max:30720', //file Size max 30mb
        ]);
        extract($request->post());
        extract($request->file());
        if (recruitments::where('r_title',$title)->where('r_vacancies',$vacancies)->where('r_start_at',$start)->where('r_end_at',$end)->where('r_c_email',$email)->where('r_dep_id',$dep)->first())
        {
            return back()->with('error','This Data already exeits')->withInput();
        }
        if (@$doc)
        {
            $fileName = $title.'_'.$doc->getClientOriginalName();
            $upload = $doc->move(public_path($this->filePath),$fileName);
            if(!$upload)
            {
                return back()->with('error','Attest file can not be uploaded')->withInput();
            }
        }
        $create = recruitments::create([
            'status'=>1,
            'r_title'=>@$title,
            'r_vacancies'=>@$vacancies,
            'r_start_at'=>@$start,
            'r_end_at'=>@$end,
            'r_c_email'=>@$email,
            'r_c_phone_code'=>@$countryCode,
            'r_c_phone'=>@$phone,
            'r_dep_id'=>@$dep,
            'r_doc'=>@$fileName,
            'r_details'=>@$details,
            'salary_range'=>@$salary,
            'location'=>@$location,
            'created_id'=>Auth::user()->id
        ]);
        if ($create)
            return back()->with('success','Data added successful');
        else
            return back()->with('error','Data added not possible')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\recruitments  $recruitments
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show()
    {
        //
        $recruitments = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')->where('recruitments.status',1)->paginate($this->record);
//        dd($recruitments);
        $departments = $this->getActiveDepartments();
        return view('admin/recruitment/list',compact('departments','recruitments'));
    }
/**
 * Display the specified resource.
 *
 * @param  \App\Models\recruitments  $recruitments
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
 */
    public function cvList()
    {
        //
        $cvList = recruitments_list::leftjoin('recruitments as r','r.r_id','recruitments_lists.r_id')->leftJoin('department as dep','dep.dep_id','r.r_dep_id')->select('recruitments_lists.*','r.*','dep.*','r.r_id as rect_id','recruitments_lists.r_id as cv_r_id')->paginate($this->record);
        $recruitments = recruitments::where('status',1)->select('r_title')->get();
        $departments = $this->getActiveDepartments();
        return view('admin/recruitment/cv-list',compact('departments','cvList','recruitments'));
    }
    //single view CV
    public function singleViewCV($id)
    {
        $cv = recruitments_list::leftjoin('recruitments as r','r.r_id','recruitments_lists.r_id')->leftJoin('department as dep','dep.dep_id','r.r_dep_id')->where('cv_id',$id)->select('recruitments_lists.*','r.*','dep.*','r.r_id as rect_id','recruitments_lists.r_id as cv_r_id')->first();
//        dd($cv);
        return view('admin/recruitment/single-view-cv',compact('cv'));
    }
    //Delete CV
    public function deleteCV($id)
    {
        if (recruitments_list::where('cv_id',$id)->delete())
        {
            return back()->with('success','CV delete successful');
        }
        else{
            return back()->with('error','CV delete not possible');
        }
    }
    //make unseen
    public function makeUnseen($id): \Illuminate\Http\RedirectResponse
    {
        if (recruitments_list::where('cv_id',$id)->update(['seen_status'=>0]))
        {
            return back()->with('success','Data update successful');
        }
        else{
            return back()->with('success','Data update not possible');
        }
    }
    //make seen
    public function makeSeen($id): \Illuminate\Http\RedirectResponse
    {
        if (recruitments_list::where('cv_id',$id)->update(['seen_status'=>1]))
        {
            return back()->with('success','Data update successful');
        }
        else{
            return back()->with('success','Data update not possible');
        }
    }
    //Search CV
    public function searchCV(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'title'=>['sometimes','nullable',$this->html],
                'dep'=>['sometimes','nullable',$this->html],
                'input'=>['sometimes','nullable',$this->html],
            ]);
            $title = null;
            $dep = null;
            $input = null;
            extract($request->post());
            $cvList = recruitments_list::leftjoin('recruitments as r','r.r_id','recruitments_lists.r_id')->leftJoin('department as dep','dep.dep_id','r.r_dep_id')
                ->when($title != null, function ($query) use($title){
                    $query->where('r.r_title','=',$title);
                })
                ->when($dep != null, function ($query) use($dep){
                    $query->where('dep.dep_id','=',$dep);
                })
                ->when($input != null && (filter_var($input,FILTER_VALIDATE_EMAIL)), function ($query) use($input){
                    $query->where('recruitments_lists.cv_email','=',$input);
                })
                ->when($input != null && (is_numeric($input)), function ($query) use($input){
                    $query->where('recruitments_lists.cv_phone','=',$input);
                })
                ->when($input != null && (!is_numeric($input)) && (!filter_var($input,FILTER_VALIDATE_EMAIL)), function ($query) use($input){
                    $query->where('recruitments_lists.cv_name','=',$input);
                })
                ->select('recruitments_lists.*','r.*','dep.*','r.r_id as rect_id','recruitments_lists.r_id as cv_r_id')
                ->get();
            return view('layouts/admin/recruitment/_cv_list',compact('cvList'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\recruitments  $recruitments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $ip = \Request::ip();
        $userLocation = Location::get($ip);
        $country = DB::table('country')->get();
        if (!$country)
            $country = null;
        $departments = $this->getActiveDepartments();
        $recruitment = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')
            ->where('recruitments.status',1)
            ->where('recruitments.r_id',$id)
            ->first();
        return view('admin/recruitment/edit',compact('recruitment','departments','userLocation','country'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\recruitments  $recruitments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, recruitments $recruitments)
    {
        //
        $validated = $request->validate([
            'id'=>['required','numeric',$this->html],
            'title'=>['required','max:100',$this->html],
            'vacancies'=>['required','numeric',$this->html],
            'start'=>['required',$this->html],
            'end'=>['required',$this->html],
            'email'=>['required','email','max:255',$this->html],
            'countryCode'=>['required','numeric',$this->html],
            'phone'=>['required','numeric','digits:10',$this->html],
            'dep'=>['required','numeric',$this->html],
            'location'=>['required',$this->html],
            'salary'=>['required','numeric',$this->html],
            'details'=>['sometimes','nullable',$this->html],
            'doc'=>'mimes:jpeg,jpg,pdf,text|max:30720', //file Size max 30mb
        ]);
        extract($request->post());
        extract($request->file());
        $recruitment = recruitments::where('r_id',$id)->first();
        if (!$recruitment)
        {
            return back()->with('error','ID Not Found!');
        }
        if (@$doc)
        {
            if ($recruitment->r_doc && file_exists($name=$this->filePath.$recruitment->r_doc))
            {
                unlink(public_path($name));
            }
            $fileName = $title.'_'.$doc->getClientOriginalName();
            $upload = $doc->move(public_path($this->filePath),$fileName);
            if(!$upload)
            {
                return back()->with('error','Attest file can not be uploaded')->withInput();
            }
            $data = [
                'r_title'=>@$title,
                'r_vacancies'=>@$vacancies,
                'r_start_at'=>@$start,
                'r_end_at'=>@$end,
                'r_c_email'=>@$email,
                'r_c_phone_code'=>@$countryCode,
                'r_c_phone'=>@$phone,
                'r_dep_id'=>@$dep,
                'r_doc'=>@$fileName,
                'salary_range'=>@$salary,
                'location'=>@$location,
                'r_details'=>@$details,
                'created_id'=>Auth::user()->id
            ];
        }
        else{
            $data = [
                'r_title'=>@$title,
                'r_vacancies'=>@$vacancies,
                'r_start_at'=>@$start,
                'r_end_at'=>@$end,
                'r_c_email'=>@$email,
                'r_c_phone_code'=>@$countryCode,
                'r_c_phone'=>@$phone,
                'r_dep_id'=>@$dep,
                'salary_range'=>@$salary,
                'location'=>@$location,
                'r_details'=>@$details,
                'created_id'=>Auth::user()->id
            ];
        }
        if (recruitments::where('r_id',$id)->update($data))
        {
            return back()->with('success','Data update successful');
        }
        else{
            return back()->with('error','Data update not possible');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\recruitments  $recruitments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (recruitments::where('r_id',$id)->delete())
        {
            return back()->with('success','Data delete successful');
        }
        else{
            return back()->with('error','Data delete not possible');
        }
    }
    public function searchRecruitment(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'title'=> ['sometimes','nullable',$this->html],
                'dep'=> ['sometimes','nullable','numeric',$this->html]
            ]);
            $title = null;
            $dep = null;
            extract($request->post());
            $recruitments = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')
            ->where('recruitments.status',1)
            ->when($title != null, function ($query) use ($title){
                $query->where('recruitments.r_title','like',"%{$title}%");
            })
            ->when($dep != null, function ($query) use ($dep){
                $query->where('recruitments.r_dep_id','like',"%{$dep}%");
            })
            ->get();
            return view('layouts/admin/recruitment/_list',compact('recruitments'));
        }
    }
    public function singleView($id)
    {
        $recruitment = recruitments::leftJoin('department as dep','dep.dep_id','recruitments.r_dep_id')
            ->where('recruitments.status',1)
            ->where('recruitments.r_id',$id)
            ->first();
//        dd($recruitment);
        return view('admin/recruitment/single-view',compact('recruitment'));
    }
}
