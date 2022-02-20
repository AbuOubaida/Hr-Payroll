<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\loan_application_list;
use App\Models\loan_installment;
use App\Models\loan_running_lists;
use App\Models\proposed_loan;
use App\Rules\Html;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\loan_type;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class loanController extends Controller
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
        $proposedLoans = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->paginate($this->record);

        return view('admin/loan/loan-list',compact('proposedLoans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //
        $loan_types = loan_type::all();
        $proposedLoans = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->paginate($this->record);
//        dd($proposedLoan);
        return view('admin/loan/add-loan',compact('loan_types','proposedLoans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'title'     =>['required',$this->html],
            'amount'    =>['required','numeric',$this->html],
            'type_id'   =>['required','numeric',$this->html],
            'details'   =>['sometimes','nullable',$this->html],
        ]);
        extract($validate);
        if (!(loan_type::where('loan_type_id',$type_id)->where('loan_type_status',1)->first())) return back()->with('error','Loan type not found!')->withInput();

        if ($amount <= 0) return back()->with('error','Loan amount can not < 1');

        if (proposed_loan::where('proposed_loan_title',$title)->where('proposed_loan_type_id',$type_id)->where('proposed_loan_amount',$amount)->first()) return back()->with('error','This Loan already exist in database');
        $data = [
            'proposed_loan_title'   =>  $title,
            'proposed_loan_type_id' =>  $type_id,
            'proposed_loan_amount'  =>  $amount,
            'proposed_loan_status'  =>  1,
            'proposed_loan_details'  =>  $details,
            'proposed_loan_add_id'  =>  Auth::user()->id,
        ];
        if (proposed_loan::create($data)) return back()->with('success','Proposed loan add successfully');
        else return back()->with('error','Data add not possible')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id)
    {
        if ($proposedLoan = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->where('proposed_loan_id',$id)->first())
        {
            $loan_types = loan_type::all();
            $proposedLoans = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->paginate($this->record);
//            dd($proposedLoan);
            return view('admin/loan/view-proposed-loan',compact('proposedLoan','loan_types','proposedLoans'));
        }
        else
            return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function edit($id)
    {
        if ($proposedLoan = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->where('proposed_loan_id',$id)->first())
        {
            $loan_types = loan_type::all();
            $proposedLoans = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->paginate($this->record);
            return view('admin/loan/edit-proposed-loan',compact('proposedLoan','loan_types','proposedLoans'));
        }
        else
            return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'title'     =>['required',$this->html],
            'amount'    =>['required','numeric',$this->html],
            'type_id'   =>['required','numeric',$this->html],
            'status'    =>['required','numeric',$this->html],
            'id'        =>['required','numeric',$this->html],
            'details'   =>['sometimes','nullable',$this->html],
        ]);
        extract($validate);
        if (!proposed_loan::where('proposed_loan_id',$id)->first()) return back();
        if (!(loan_type::where('loan_type_id',$type_id)->where('loan_type_status',1)->first())) return back()->with('error','Loan type not found!')->withInput();

        if ($amount <= 0) return back()->with('error','Loan amount can not < 1');

        if (proposed_loan::where('proposed_loan_title',$title)->where('proposed_loan_type_id',$type_id)->where('proposed_loan_amount',$amount)->where('proposed_loan_id','!=',$id)->first()) return back()->with('error','This Loan already exist in database');
        $data = [
            'proposed_loan_title'       =>  $title,
            'proposed_loan_type_id'     =>  $type_id,
            'proposed_loan_amount'      =>  $amount,
            'proposed_loan_status'      =>  $status,
            'proposed_loan_details'     =>  $details,
            'proposed_loan_update_id'   =>  Auth::user()->id,
        ];
        if (proposed_loan::where('proposed_loan_id',$id)->update($data)) return back()->with('success','Proposed loan Update successfully');
        else return back()->with('error','Data Update not possible')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Request $request)
    {
        extract($request->post());
        $id = $p_loan_id;
        if (proposed_loan::where('proposed_loan_id',$id)->delete())
            return redirect('admin/loan/loan-list')->with('success','Data delete successfully');
        else
            return back()->with('error','Data delete not possible');
    }

    public function searchProposedLoan(Request $request)
    {
        if ($request->ajax())
        {
            $validate = $request->validate(['*'=>'nullable','sometime',$this->html]);
            extract($validate);
            $proposedLoans = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')
                ->when($data,function ($query) use ($data){
                    $query->orWhere('proposed_loan_title','LIKE',"%$data%");
                    $query->orWhere('proposed_loan_amount','LIKE',"%$data%");
                })
                ->get();
            return view('layouts/admin/loan/_proposed_loan_list',compact('proposedLoans'));
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeLoanType(Request $request): RedirectResponse
    {
        $validate = $request->validate(['*'=>['required',$this->html]]);
        $y=0;
        $m=0;
        extract($validate);
        if ($monthYear == 'years')
        {
            $y = 1;
            $totalMonth = $duration * 12;
        }
        else
        {
            $m = 1;
            $totalMonth = $duration;
        }
        $installment = $totalMonth;
        if (loan_type::where('loan_type_title',$type)->where('loan_type_installment',$installment)->first())
            return back()->with('warning','This Data already exist in Database');
        $data = [
            'loan_type_title'       =>  $type,
            'loan_type_duration'    =>  $duration,
            'loan_type_month'       =>  $m,
            'loan_type_year'        =>  $y,
            'loan_type_installment' =>  $installment,
            'loan_type_add_id'      =>  Auth::user()->id,
            'loan_type_status'      =>  1,
        ];
        if (loan_type::create($data))
            return back()->with('success','Type add successfully');
        else
            return back()->with('error','Type add not possible');
    }

    //Edit loan Type
    public function editLoanType($id)
    {
        $loan_types = loan_type::all();
        $loanType = loan_type::where('loan_type_id',$id)->first();
        return view('admin/loan/edit-loan-type',compact('loanType','loan_types'));
    }
    //Update loan type
    public function updateLoanType(Request $request)
    {
        $validate = $request->validate(['*'=>['required',$this->html]]);
        $y=0;
        $m=0;
        extract($validate);
        if ($monthYear == 'years')
        {
            $y = 1;
            $totalMonth = $duration * 12;
        }
        else
        {
            $m = 1;
            $totalMonth = $duration;
        }
        $installment = $totalMonth;
        $s = 0;
        if ($status == 1)
            $s = 1;
        if (loan_type::where('loan_type_id', '!=', $loan_type_id)->where('loan_type_title',$type)->where('loan_type_installment',$installment)->first())
            return back()->with('warning','This Data already exist in Database');
        $data = [
            'loan_type_title'       =>  $type,
            'loan_type_duration'    =>  $duration,
            'loan_type_month'       =>  $m,
            'loan_type_year'        =>  $y,
            'loan_type_installment' =>  $installment,
            'loan_type_update_id'   =>  Auth::user()->id,
            'loan_type_status'      =>  $s,
        ];
        if (loan_type::where('loan_type_id', $loan_type_id)->update($data))
            return back()->with('success','Type update successfully');
        else
            return back()->with('error','Type update not possible');
    }
    //Delete Loan type
    public function destroyLoanType(Request $request)
    {
        if (loan_type::where('loan_type_id',$request->typeDeleteID)->delete())
            return redirect('admin/loan/add-loan')->with('success','Loan type delete successfully');
        else
            return back()->with('error','Data delete not possible');
    }
    // loan Request ==============================================
    private function getLoanRequests()
    {
        return loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
            ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
            ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
            ->leftJoin('department as dep','dep.dep_id','u.dep_id')
            ->where('loan_application_lists.loan_appl_status',1)
            ->where('loan_application_lists.loan_appl_approve_status','!=',1)
            ->select('loan_application_lists.*','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
            ->orderBy('loan_application_lists.loan_appl_id','desc')
            ->paginate($this->record);
    }
    private function getLoanRunnings()
    {
        return loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
            ->leftJoin('loan_running_lists as lrl','lrl.loan_apply_id','loan_application_lists.loan_appl_id')
            ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
            ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
            ->leftJoin('department as dep','dep.dep_id','u.dep_id')
            ->where('loan_application_lists.loan_appl_status',1)
            ->where('loan_application_lists.loan_appl_approve_status',1)
//            ->select('loan_application_lists.*','lrl.running_id','lrl.invoice_id','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
            ->select('loan_application_lists.*','lrl.running_id','lrl.invoice_id','lrl.many_received_status','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','u.email as client_email','u.phone_code','u.phone','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
            ->orderBy('loan_application_lists.loan_appl_id','desc')
            ->paginate($this->record);
    }
    //Show all loan Request list
    public function showRequestLoanList()
    {
        $loans = proposed_loan::where('proposed_loan_status',1)->select('proposed_loan_id','proposed_loan_title')->get();
        $requests = $this->getLoanRequests();
        return view('admin/loan/application-loan-list',compact('requests','loans'));
    }
    //Show all loan Running list
    public function showRunningLoanList()
    {
        $loans = proposed_loan::where('proposed_loan_status',1)->select('proposed_loan_id','proposed_loan_title')->get();
        $requests = $this->getLoanRunnings();
        return view('admin/loan/running-loan-list',compact('requests','loans'));
    }
    //Search application loan
    public function searchApplicationLoan(Request $request)
    {
        if ($request->ajax())
        {
            $validate = $request->validate(['*'=>['sometimes','nullable',$this->html]]);
            $user = null;
            $order = null;
            $title = null;
            $status = null;
            extract($validate);
            $requests = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
                ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
                ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
                ->leftJoin('department as dep','dep.dep_id','u.dep_id')
                ->where('loan_application_lists.loan_appl_status',1)
                ->where('loan_application_lists.loan_appl_approve_status','=',$status)
                ->when($user != null && !is_numeric($user) , function ($query) use($user){
                    $query->where('u.name','LIKE',"%{$user}%");
                })
                ->when($user != null && is_numeric($user) , function ($query) use($user){
                    $query->where('u.employee_id','LIKE',"%{$user}%");
                })
                ->when($title != null, function ($query) use($title){
                    $query->where('pl.proposed_loan_title','LIKE',"%{$title}%");
                })
                ->select('loan_application_lists.*','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
                ->when($order != null, function ($query) use ($order){
                    $query->orderBy('loan_application_lists.loan_appl_id',$order);
                })
                ->get();
            return view('layouts.admin.loan._application_loan_list',compact('requests'));
        }
        return false;
    }
    //Search Running loan
    public function searchRunningLoan(Request $request)
    {
        if ($request->ajax())
        {
            $validate = $request->validate(['*'=>['sometimes','nullable',$this->html]]);
            $user = null;
            $order = null;
            $title = null;
            $status = 1;
            extract($validate);
            $requests = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
                ->leftJoin('loan_running_lists as lrl','lrl.loan_apply_id','loan_application_lists.loan_appl_id')
                ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
                ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
                ->leftJoin('department as dep','dep.dep_id','u.dep_id')
                ->where('loan_application_lists.loan_appl_status',1)
                ->where('loan_application_lists.loan_appl_approve_status','=',$status)
                ->when($user != null && !is_numeric($user) , function ($query) use($user){
                    $query->where('u.name','LIKE',"%{$user}%");
                    $query->orWhere('lrl.invoice_id','LIKE',"%{$user}%");
                })
                ->when($user != null && is_numeric($user) , function ($query) use($user){
                    $query->where('u.employee_id','LIKE',"%{$user}%");
                })
                ->when($title != null, function ($query) use($title){
                    $query->where('pl.proposed_loan_title','LIKE',"%{$title}%");
                })
                ->select('loan_application_lists.*','lrl.running_id','lrl.invoice_id','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
                ->when($order != null, function ($query) use ($order){
                    $query->orderBy('loan_application_lists.loan_appl_id',$order);
                })
                ->get();
            return view('layouts.admin.loan._running_loan_list',compact('requests'));
        }
        return false;
    }

    //single view loan
    public function singleViewApplicationLoan($id)
    {
        $loans = proposed_loan::where('proposed_loan_status',1)->select('proposed_loan_id','proposed_loan_title')->get();
        $requests = $this->getLoanRequests();
        try {
            loan_application_list::where('loan_appl_id',$id)->where('admin_seen_status',0)->update(['admin_seen_status'=>1]);
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
        $request = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
            ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
            ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
            ->leftJoin('department as dep','dep.dep_id','u.dep_id')
            ->where('loan_application_lists.loan_appl_status',1)
            ->where('loan_application_lists.loan_appl_id',$id)
            ->where('loan_application_lists.loan_appl_approve_status','!=',1)
            ->select('loan_application_lists.*','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','u.email as client_email','u.phone_code','u.phone','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
            ->first();
//        dd($request);
        return view('admin/loan/view-application-loan',compact('request','requests','loans'));
    }
    public function singleViewRunninglicationLoan($id)
    {
        $loans = proposed_loan::where('proposed_loan_status',1)->select('proposed_loan_id','proposed_loan_title')->get();
        $requests = $this->getLoanRunnings();
        $request = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
            ->leftJoin('loan_running_lists as lrl','lrl.loan_apply_id','loan_application_lists.loan_appl_id')
            ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
            ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
            ->leftJoin('department as dep','dep.dep_id','u.dep_id')
            ->where('loan_application_lists.loan_appl_status',1)
            ->where('loan_application_lists.loan_appl_id',$id)
            ->where('loan_application_lists.loan_appl_approve_status',1)
            ->select('loan_application_lists.*','lrl.*','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','u.email as client_email','u.phone_code','u.phone','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
            ->first();
        $installments = loan_installment::where('loan_appl_id',$id)->get();
//        dd($installments);
        return view('admin/loan/view-running-loan',compact('request','requests','loans','installments'));
    }
    //Approve loan Request
    public function approveLoanRequest(Request $request)
    {
        $dt = Carbon::now();
        $nextMonth = $dt->addMonths(1);
        $nextAfter = $nextMonth;
        $addLoanMonth = date('F',strtotime($nextMonth));
        $addInsMonth = date('F',strtotime($nextAfter->addMonth(1)));
        $company = company::first();

        $validate = $request->validate(['*'=>['required','numeric',$this->html]]);
        extract($validate);
        try {
            $loanRequest = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
                ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
                ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
                ->leftJoin('department as dep','dep.dep_id','u.dep_id')
                ->where('loan_application_lists.loan_appl_status',1)
                ->where('loan_application_lists.loan_appl_id',$loan_req_id)
                ->where('loan_application_lists.loan_appl_uesr_id',$client_id)
                ->select('loan_application_lists.*','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','u.email as client_email','u.phone_code','u.phone','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
                ->first();
            $runningLoan = loan_running_lists::where('loan_id',$loanRequest->loan_appl_id)->where('loan_amount',$loanRequest->proposed_loan_amount)->where('loan_installment',$loanRequest->loan_type_installment)->where('loan_complete_status',0)->where('client_id',$loanRequest->client_id)->first();

        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
        if($runningLoan)
        {
            return back()->with('error','This client already has a running loan');
        }
        if(!$loanRequest)
        {
            return back()->with('error','Loan data not found!');
        }
        $invioceID = Str::random(8);
        $installmentAmount = ceil($loanRequest->proposed_loan_amount/$loanRequest->loan_type_installment);

        try {
            if (loan_running_lists::where('client_id',$loanRequest->client_id)->where('loan_status',1)->where('loan_complete_status',0)->first())
            {
                return back()->with('warning','This employee already has a lone. Please try again after complete that previous loan. Thank You');
            }
//            dd($addInsMonth);
            loan_running_lists::create([
                'client_id'     =>  $loanRequest->client_id,
                'invoice_id'    =>  $invioceID,
                'loan_year'     =>  date('Y',strtotime(now())),
                'add_loan_month'=>  $addLoanMonth,
                'add_installment_month'=>  $addInsMonth,
                'loan_apply_id' =>  $loan_req_id,
                'loan_id'       =>  $loanRequest->proposed_loan_id,
                'loan_amount'   =>  $loanRequest->proposed_loan_amount,
                'loan_installment'=>$loanRequest->loan_type_installment,
                'installment_amount'=>$installmentAmount,
                'loan_status'   =>  1,
            ]);
            $running = loan_running_lists::where('invoice_id',$invioceID)->first();
            $ins = $loanRequest->loan_type_installment;
            for ($i=1;$i<=$ins;$i++)
            {
                loan_installment::create([
                    'running_id'        =>  $running->running_id,
                    'loan_appl_id'      =>  $running->loan_apply_id,
                    'proposed_loan_id'  =>  $running->loan_id,
                    'loan_amount'       =>  $running->loan_amount,
                    'ins_amount'        =>  $running->installment_amount,
                    'employee_id'       =>  $running->client_id,
                    'ins_paid_status'   =>  0,
                    'ins_paid_date'     =>  null,
                    'ins_number'        =>  $i,
                ]);
            }
            loan_application_list::where('loan_appl_proposed_id',$loanRequest->proposed_loan_id)->where('loan_appl_uesr_id',$loanRequest->client_id)->where('loan_appl_status',1)->update([
                'response_date'=>date(now()),
                'loan_appl_approve_date'=>date(now()),
                'loan_appl_approve_status'=>1,
                'loan_appl_approve_id'=>Auth::user()->id,
            ]);
            $mailData = [
                'client_name'   =>    $loanRequest->client_name,
                'apply_date'    =>    $loanRequest->apply_date,
                'nextMonth'     =>    $addLoanMonth,
                'invoiceID'     =>    $invioceID,
                'comp_name'     =>    $company->comp_name,
                'comp_email'    =>    $company->comp_email,
                'comp_phone'    =>    $company->comp_phone,
                'proposed_loan_amount'      =>    $loanRequest->proposed_loan_amount,
                'proposed_loan_title'       =>    $loanRequest->proposed_loan_title,
                'loan_type_title'           =>    $loanRequest->loan_type_title,
                'loan_type_installment'     =>    $loanRequest->loan_type_installment,
                'loan_type_duration'        =>    $loanRequest->loan_type_duration . $loanRequest->loan_type_year?'Years':'months',
            ];
            $user['to'] = $loanRequest->client_email;
            $user['from'] = $company->comp_email;
            $user['company'] = $company->comp_name;
            Mail::send('admin/loan/loan_invoice_1',$mailData,function ($message) use ($user){
                $message->to($user['to']);
                $message->from($user['from'],$user['company']);
                $message->subject("Loan Invoice From ".$user['company']);
            });
            return redirect("admin/loan/loan-request-list")->with('success','Loan Approved Successfully');
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
