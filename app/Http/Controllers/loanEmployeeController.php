<?php

namespace App\Http\Controllers;

use App\Models\loan_application_list;
use App\Models\loan_installment;
use App\Models\proposed_loan;
use App\Rules\Html;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loanEmployeeController extends Controller
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
        $loans = proposed_loan::leftJoin('loan_types as lnt','lnt.loan_type_id','proposed_loans.proposed_loan_type_id')
            ->where('proposed_loan_status',1)
            ->orderBy('proposed_loans.proposed_loan_id','desc')
            ->paginate($this->record);
        $loanApplications = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
            ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
            ->where('loan_application_lists.loan_appl_uesr_id',Auth::user()->id)
            ->where('loan_application_lists.loan_appl_status',1)
            ->orderBy('loan_application_lists.loan_appl_id','desc')
            ->paginate($this->record);
        return view('employee/loan/create-loan',compact('loans','loanApplications'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'loan'      => ['required','numeric',$this->html],
            'details'   => ['sometimes','nullable',$this->html],
        ]);
        extract($validate);
        if (loan_application_list::where('loan_appl_uesr_id',Auth::user()->id)->where('loan_appl_status',1)->where('loan_complete_status',0)->where('loan_appl_approve_status',1)->first())
        {
            return back()->with('warning','You already get a loan! Pleas try again to complete previous loan');
        }
        try {
            $loanDB = proposed_loan::where('proposed_loan_id',$loan)->where('proposed_loan_status',1)->first();
            if ($loanDB)
            {
                try {
                    loan_application_list::create([
                        'loan_appl_proposed_id' =>  $loan,
                        'apply_date'            =>  date(now()),
                        'loan_appl_deatils'     =>  $details,
                        'loan_appl_uesr_id'     =>  Auth::user()->id,
                        'loan_appl_status'      =>  1,
                    ]);
                    return back()->with('success','Loan application submit successfully');
                }catch (Throwable $exception)
                {
                    return back()->with('error',$exception->getMessage());
                }
            }
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    //view proposed loan
    public function viewProposedLoan($id)
    {
        try {
            $proposedLoan = proposed_loan::leftjoin('loan_types as lt','lt.loan_type_id','proposed_loans.proposed_loan_type_id')->where('proposed_loan_id',$id)->where('proposed_loan_status',1)->first();
            $loans = proposed_loan::leftJoin('loan_types as lnt','lnt.loan_type_id','proposed_loans.proposed_loan_type_id')
                ->where('proposed_loan_status',1)
                ->orderBy('proposed_loans.proposed_loan_id','desc')
                ->paginate($this->record);
            return view('employee/loan/view-proposed-loan',compact('proposedLoan','loans'));
        }catch (Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    //view application loan
    public function viewApplicationLoan($id)
    {
        try {
            $loanApplication = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
                ->leftJoin('loan_running_lists as lrl','lrl.loan_apply_id','loan_application_lists.loan_appl_id')
                ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
                ->leftJoin('users as u','u.id','loan_application_lists.loan_appl_uesr_id')
                ->leftJoin('department as dep','dep.dep_id','u.dep_id')
                ->where('loan_application_lists.loan_appl_status',1)
                ->where('loan_application_lists.loan_appl_id',$id)
                ->where('loan_application_lists.loan_appl_uesr_id',Auth::user()->id)
                ->select('loan_application_lists.*','lrl.*','pl.*','lt.*','u.id as client_id','u.name as client_name','u.employee_id as client_emp_id','u.email as client_email','u.phone_code','u.phone','dep.dep_id as client_dep_id','dep.dep_name as client_dep_name')
                ->first();
            $loanApplications = loan_application_list::leftJoin('proposed_loans as pl','pl.proposed_loan_id','loan_application_lists.loan_appl_proposed_id')
                ->leftJoin('loan_types as lt','lt.loan_type_id','pl.proposed_loan_type_id')
                ->where('loan_application_lists.loan_appl_uesr_id',Auth::user()->id)
                ->where('loan_application_lists.loan_appl_status',1)
                ->orderBy('loan_application_lists.loan_appl_id','desc')
                ->paginate($this->record);
            $installments=null;
            if ($loanApplication->many_received_status)
            {
                $installments = loan_installment::where('loan_appl_id',$loanApplication->loan_appl_id)->get();
            }
            if (!$loanApplication || !$loanApplications)
            {
                return redirect('employee/loan/loan-application');
            }
//        dd($loanApplication);
            return view('employee/loan/view-application-loan',compact('loanApplication','loanApplications','installments'));
        }catch (Throwable $exception)
        {
            return redirect('employee/loan/loan-application')->with('error',$exception->getMessage());
        }

    }
}
