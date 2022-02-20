<?php

namespace App\Http\Controllers;

use App\Rules\Html;
use Illuminate\Http\Request;
use App\Models\employee_position;
class employeePositionController extends Controller
{
    //
    private $html = null;
    public function __construct()
    {
        $this->html = new Html;//Rule for check html spatial character
    }
    public function create()
    {
        $positions = employee_position::orderBy('position_id','desc')->paginate(10);
        return view('admin/employee/add-position',compact('positions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'positionTitle'=>['required','max:100',$this->html],
            'positionDescription'=>['sometimes','nullable',$this->html]
        ]);
        if (employee_position::where('position_name',$request->post('positionTitle'))->first())
        {
            return back()->with('error',"{$request->post('positionTitle')} are already exists")->withInput();
        }
        $store = employee_position::create([
            'position_status'=>1,
            'position_name'=>$request->post('positionTitle'),
            'position_details'=>$request->post('positionDescription')

        ]);
        if ($store) return back()->with('success','Data Insert Successful');
        else return back()->with('error','Data Insert Not Possible');
    }
    public function searchPosition(Request $request)
    {
        if ($request->ajax())
        {
            $value = $request->post('v');
            $positions = employee_position::where('position_name','like',"%{$value}%")->get();
            return view('layouts/admin/employee/_position-table',compact('positions'));
        }
    }
//    Edit Position
    public function edit($id)
    {
        $positions = employee_position::orderBy('position_id','desc')->paginate(10);
        $position = employee_position::where('position_id',$id)->first();
        if (!$position)return redirect('admin/employee/add-position');
        return view('admin/employee/edit-position',compact('positions','position'));
    }
//    Update Position
    public function update(Request $request,$id)
    {
        $request->validate([
            'positionTitle'=>['required','max:100',$this->html],
            'positionStatus' => ['required','max:1','numeric',$this->html],
            'positionDescription'=>['sometimes','nullable',$this->html]
        ]);
        $title = $request->post('positionTitle');
        $status = $request->post('positionStatus');
        if ($status >= 1)$status =1;else $status = 0;
        $details = $request->post('positionDescription');
        $position = employee_position::where('position_name',$title)->where('position_id','!=',$id)->first();
        if ($position)
        {
            return back()->with('error',"{$request->post('positionTitle')} are already exists")->withInput();
        }
        $update = employee_position::where('position_id',$id)->update([
            'position_name'=>$title,
            'position_status'=>$status,
            'position_details'=>$details,
            'updated_at'=>now()
        ]);
        if ($update)
        {
            return back()->with('success','Data Update Successful');
        }
        return back()->with('error','Data update Not Possible!');
    }
//    Delete position
    public function destroy($id)
    {
        $delete = employee_position::where('position_id',$id)->delete();
        if ($delete)
        {
            return redirect('admin/employee/position-list')->with('success','Data Delete Successful');
        }
        return back()->with('error','Data Delete are not possible');
    }
//    For position List
    public function show()
    {
        $positions = employee_position::orderBy('position_id','desc')->paginate(10);
        return view('admin/employee/position-list',compact('positions'));
    }
}
