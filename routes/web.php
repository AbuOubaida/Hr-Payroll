<?php

use App\Http\Controllers\loanEmployeeController;
use App\Http\Controllers\loanProjectManagerController;
use App\Http\Controllers\projectEmployeeController;
use App\Http\Controllers\projectManagerAttendanceController;
use App\Http\Controllers\projectManagerController;
use App\Http\Controllers\projectProjectManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admindashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\employeedashboardController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\departmentController;
use App\Http\Controllers\GeoLocationController;
use App\Http\Controllers\basicAccountSettingController;
use App\Http\Controllers\employeePositionController;
use App\Http\Controllers\salaryGradeController;
use App\Http\Controllers\attendanceController;
use App\Http\Controllers\appSettingController;
use App\Http\Controllers\payrollController;
use App\Http\Controllers\recruitmentController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\projectAdminController;
use App\Http\Controllers\loanController;


#.1. For root directory for general user/Home page+++++++++++++++++++++++++++++++
Route::get('/',[homeController::class,'index']);
Route::group(['prefix'=>'job'],function (){
    Route::get("apply/{rID}",[homeController::class,'viewJob']);
    Route::post('apply-save',[homeController::class,'store'])->name('job.apply');
});
//----------End 1 root directory for general user/Home page----------------------

#.2. Group for Authenticate User Access+++++++++++++++++++++++++++++++++++++++++
Route::group(['middleware' => ['auth']],function (){

    #.2.1.For Redirect Auth of role page++++++++++++++++++++++++++++++++++++++
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    //--------------------End 2.1 Redirect Auth of role page-----------------

    #.2.2.Group For admin role access++++++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth','role:admin'],'prefix'=>'admin'/* admin/ */],function (){

        #.2.2.1.For admin Dashboard root URL+++++++++++++++++++++++++++++++++
        Route::get('dashboard',[admindashboardController::class,'index'])->name('admin');
        Route::get('/',[DashboardController::class,'index']);
        //--------------------End 2.2.1 admin Dashboard Root URL-------------

        #.2.2.2.For Account setting+++++++++++++++++++++++++++++++++++++++++++
        Route::get('account-setting',[basicAccountSettingController::class,'index']);
        //----------------------------End 2.2.2 account setting----------------

        #.2.2.3.Group for employees++++++++++++++++++++++++++++++++++++++++++++
        Route::get('employee',function ()
        {
            return redirect('admin/employee/all-list');
        });
        Route::group(['prefix'=>'employee'],function (){
            Route::get('add-new',[employeeController::class,'create']);
            Route::get('all-list',[employeeController::class,'show']);
            Route::get('view/{ViewEmpId}',[employeeController::class,'singleView']);
            Route::get('edit/{editEmpId}',[employeeController::class,'edit']);
            Route::get('delete/{deleteEmpId}',[employeeController::class,'destroy']);
            Route::post('change-role',[employeeController::class,'empRoleChange'])->name('change.role');
            Route::post('change-employee-status',[employeeController::class,'empStatusChange'])->name('change.status');
            Route::post('set-id',[employeeController::class,'setIdByDep'])->name('set.id');
            Route::post('auto-password',[employeeController::class,'generatePass'])->name('auto-password');
            Route::post('store-employee',[employeeController::class,'store'])->name('store-employee');
            Route::post('update-employee',[employeeController::class,'update'])->name('update.employee');
            Route::post('email-check',[employeeController::class,'checkEmail'])->name('email-check');
            Route::post('search-employee',[employeeController::class,'searchEmployee'])->name('search-employee');
            Route::post('search-employee-list',[employeeController::class,'searchEmployeeList'])->name('search-employee-list');
            Route::post('filter-employee-list',[employeeController::class,'filterByRole'])->name('filter-employee-list');
            Route::post('admit-employee',[employeeController::class,'admitToEmployee']);

            Route::get('add-position',[employeePositionController::class,'create']);
            Route::get('position-list',[employeePositionController::class,'show']);
            Route::post('add-position',[employeePositionController::class,'store'])->name('add-position');
            Route::post('position-search',[employeePositionController::class,'searchPosition'])->name('position-search');
            Route::get('edit-position/{positionId}',[employeePositionController::class,'edit']);
            Route::post('update-position/{id}',[employeePositionController::class,'update'])->name('update.position');
            Route::get('delete-position/{id}',[employeePositionController::class,'destroy']);

            Route::get('set-grade',[salaryGradeController::class,'setSalaryGrade']);
            Route::post('save-set-grade',[salaryGradeController::class,'setSalaryGradeSave'])->name('save.set-grade');
            Route::post('change-emp-pass',[employeeController::class,'changeEmpPassByAdmin'])->name('employee.password.change');
            Route::post('update-emp-pass',[employeeController::class,'updateEmpPassByAdmin'])->name('employee.password.update');
        });
        //-------------------------End 2.2.3 employee group------------------

        #.2.2.4.For Department+++++++++++++++++++++++++++++++++++++++++++++++
        Route::get('add-department',[departmentController::class,'create']);
        Route::post('store-department',[departmentController::class,'store'])->name('addDepartment');
        Route::get('department-list',[departmentController::class,'show']);
        Route::get('view-department/{depId}',[departmentController::class,'singleView']);
        Route::get('edit-department/{editDepId}',[departmentController::class,'edit']);
        Route::get('delete-department/{Id}',[departmentController::class,'makeInactive']);
        Route::post('update-department/{id}',[departmentController::class,'update'])->name('updateDepartment');
        Route::post('department-filter',[departmentController::class,'ajaxShowByFilter'])->name('department-filter');
        Route::post('department-search',[departmentController::class,'ajaxShowBySearch'])->name('department-search');
        Route::post('department-code-check',[departmentController::class,'depCodeCheck'])->name('department-code-check');
        //---------------------End 2.2.4 Department---------------------------
        #.2.2.5.Group For Salary Grade++++++++++++++++++++++++++++++++++++++++
        Route::get('grade',function ()
        {
            return redirect('admin/grade/salary/grade-list');
        });
        Route::get('grade/salary',function ()
        {
            return redirect('admin/grade/salary/grade-list');
        });
        Route::group(['prefix'=>'grade/salary'],function (){
            Route::get('add-grade',[salaryGradeController::class,'create']);
            Route::post('add-grade',[salaryGradeController::class,'store'])->name('add.grade');
            Route::post('edit-grade/{editID}',[salaryGradeController::class,'update'])->name('edit.grade');
            Route::post('add-grade-step-2',[salaryGradeController::class,'addGradeStep2'])->name('add.grade.2');
            Route::get('view-grade/{gradeIdView}',[salaryGradeController::class,'singleView']);
            Route::get('edit-grade/{gradeIdEdit}',[salaryGradeController::class,'edit']);
            Route::get('delete-grade/{gradeIdDelete}',[salaryGradeController::class,'destroy']);
            Route::get('grade-list',[salaryGradeController::class,'show']);
            Route::post('grade-search',[salaryGradeController::class,'ajaxShowBySearch'])->name('grade-search');
        });
        //----------------------End 2.2.5 Group Salary Grade-------------------
        #2..2.6.Group For Attendance+++++++++++++++++++++++++++++++++++++++++++
        Route::group(['prefix'=>'attendance'],function(){
            Route::get('add-attendance',[attendanceController::class,'create']);
            Route::post('search-employee',[attendanceController::class,'searchEmp']);
            Route::post('store-entry',[attendanceController::class,'store'])->name('attendance.entry');
            Route::get('view-attendance/{attId}',[attendanceController::class,'singleViewAtt']);
            Route::get('attendance-list',[attendanceController::class,'show']);
            Route::post('filter-attendance',[attendanceController::class,'filterAttendance']);
        });
        //---------------------------End 2.2.6 Group Attendance----------------
        #2.2.7.Group App setting+++++++++++++++++++++++++++++++++++++++++++++++
        Route::get('app',function ()
        {
            return redirect('admin/app/setting/general');
        });
        Route::get('app/setting',function ()
        {
            return redirect('admin/app/setting/general');
        });
        Route::group(['prefix'=>'app/setting'],function (){
            Route::get('general',[appSettingController::class,'general']);
            Route::post('save-protocol',[appSettingController::class,'saveProtocol'])->name('save.protocol');
            Route::post('holiday-save',[appSettingController::class,'storeHoliday'])->name('store.holiday');
            Route::post('holiday-name-save',[appSettingController::class,'storeHolidayName'])->name('store.holiday.name');
            Route::post('public-holiday-save',[appSettingController::class,'storePublicHoliday'])->name('store.public.holiday');
            Route::get('delete-public-holiday/{id}',[appSettingController::class,'deletePublicHoliday']);
        });
        //--------------------------End 2.2.7 Group App setting----------------
        #2.2.8.Group for payroll+++++++++++++++++++++++++++++++++++++++++++++++
        Route::group(['prefix'=>'payroll'],function (){
            Route::get('prepare-salary',[payrollController::class,'create']);
            Route::get('salary-list',[payrollController::class,'show']);
            Route::post('prepare-save-salary',[payrollController::class,'store'])->name('prepare.save.salary');
            Route::post('search-salary-list',[payrollController::class,'searchListMonth']);
            Route::post('search-all-salary-list',[payrollController::class,'searchAllList']);
            Route::post('delete-salary-list',[payrollController::class,'deleteListMonth']);
            Route::get('salary-view/{sa_id}',[payrollController::class,'singleSalaryView']);
            Route::post('make-salary-paid',[payrollController::class,'paidSalaryStatus'])->name('make.salary.paid');
        });
        //----------------------End 2.2.8 Group for recruitment----------------
        #2.2.9.Group for recruitment+++++++++++++++++++++++++++++++++++++++++++
        Route::group(['prefix'=>'recruitment'],function (){
            Route::get('create',[recruitmentController::class,'create']);
            Route::post('store-recruitment',[recruitmentController::class,'store'])->name('addRecruitment');
            Route::post('update-recruitment',[recruitmentController::class,'update'])->name('updateRecruitment');
            Route::get('recruitment-list',[recruitmentController::class,'show']);
            Route::post('search-recruitment-list',[recruitmentController::class,'searchRecruitment']);
            Route::get('view-recruitment/{recrtID}',[recruitmentController::class,'singleView']);
            Route::get('edit-recruitment/{recrtEditID}',[recruitmentController::class,'edit']);
            Route::get('delete-recruitment/{recrtEditID}',[recruitmentController::class,'destroy']);
            Route::get('cv-list',[recruitmentController::class,'cvList']);
            Route::get('view-cv/{cvID}',[recruitmentController::class,'singleViewCV']);
            Route::get('delete-cv/{cvID}',[recruitmentController::class,'deleteCV']);
            Route::get('unseen-cv/{cvID}',[recruitmentController::class,'makeUnseen']);
            Route::get('seen-cv/{cvID}',[recruitmentController::class,'makeSeen']);
            Route::post('search-cv',[recruitmentController::class,'searchCV']);
        });
        //---------------------End 2.2.9 Group for recruitment----------------
        #2.2.10.Change Password+++++++++++++++++++++++++++++++++++++++++++++++
        Route::get('change-password',[basicAccountSettingController::class,'changePassword']);
        Route::post('admin-update-password',[basicAccountSettingController::class,'updatePassword'])->name('admin.change.password');
        //---------------------End 2.2.10 Change Password----------------
        #2.2.11.Group for Project+++++++++++++++++++++++++++++++++++++++++++++++
        Route::group(['prefix'=>'project'],function (){
            Route::get('add-project',[projectAdminController::class,'create']);
            Route::post('save-project',[projectAdminController::class,'store'])->name('add.project');
            Route::post('project-sm-search',[projectAdminController::class,'projectSmSearch']);
            Route::get('view-project/{pShowID}',[projectAdminController::class,'show']);
            Route::get('edit-project/{pEditID}',[projectAdminController::class,'edit']);
            Route::get('delete/{pDeleteID}',[projectAdminController::class,'destroy']);
            Route::post('update-project',[projectAdminController::class,'update'])->name('update.project');
            Route::get('project-list',[projectAdminController::class,'index']);
            Route::get('create-team',[projectAdminController::class,'createTeam']);
            Route::post('save-team',[projectAdminController::class,'saveTeam'])->name('add.team');
            Route::post('team-sm-search',[projectAdminController::class,'searchSmTeam']);
            Route::get('edit-team/{teamID}',[projectAdminController::class,'editTeam']);
            Route::post('update-team',[projectAdminController::class,'updateTeam'])->name('update.team');
            Route::get('team-list',[projectAdminController::class,'teamList']);
            Route::get('delete-team/{teamID}',[projectAdminController::class,'destroyTeam']);
            Route::post('add-team-member',[projectAdminController::class,'saveTeamMember'])->name('add.team.member');
            Route::get('delete-team-member/{memberID}',[projectAdminController::class,'destroyTeamMember']);
            Route::get('set-team',[projectAdminController::class,'setTeam']);
            Route::post('save-set-team',[projectAdminController::class,'saveSetTeam'])->name('save.set.team');
            Route::get('set-team-delete/{sID}',[projectAdminController::class,'setTeamDelete']);
        });
        //---------------------End 2.2.11 Group for Project----------------
        #2.2.11.Group for Loan+++++++++++++++++++++++++++++++++++++++++++++++
        Route::group(['prefix'=>'loan'],function (){
            Route::get('add-loan',[loanController::class,'create']);
            Route::post('save-loan',[loanController::class,'store'])->name('save.loan');
            Route::delete('proposed-loan-delete',[loanController::class,'destroy'])->name('proposed.loan.delete');
            Route::post('proposed-loan-search',[loanController::class,'searchProposedLoan']);
            Route::get('edit-proposed-loan/{pEditLId}',[loanController::class,'edit']);
            Route::post('update-proposed-loan',[loanController::class,'update'])->name('update.proposed.loan');
            Route::get('view-proposed-loan/{pLId}',[loanController::class,'show']);
            Route::get('loan-list',[loanController::class,'index']);

            Route::post('save-loan-type',[loanController::class,'storeLoanType'])->name('save.loan.type');
            Route::post('update-loan-type',[loanController::class,'updateLoanType'])->name('update.loan.type');
            Route::get("edit-loan-type/{loanTypeID}",[loanController::class,'editLoanType']);
            Route::delete('loan.type.delete',[loanController::class,'destroyLoanType'])->name('loan.type.delete');

            Route::get('loan-request-list',[loanController::class,'showRequestLoanList']);
            Route::get('loan-running-list',[loanController::class,'showRunningLoanList']);
            Route::post('loan-application-search',[loanController::class,'searchApplicationLoan']);
            Route::post('loan-running-search',[loanController::class,'searchRunningLoan']);
            Route::get('view-app-loan/{appLnID}',[loanController::class,'singleViewApplicationLoan']);
            Route::get('view-running-loan/{runningLnID}',[loanController::class,'singleViewRunninglicationLoan']);
            Route::post('loan-request-approve',[loanController::class,'approveLoanRequest'])->name('loan.request.approve');
            Route::post('many-received-approve',[loanController::class,'approveManyReceived'])->name('many.received.approve');

        });
        //---------------------End 2.2.11 Group for Loan----------------
    });
    //--------------------End 2.2 Group For admin role access----------------

    #.2.3.Group For Employee role Access+++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth','role:employee'],'prefix'=>'employee'/* employee/ */],function (){
        Route::get('dashboard',[employeedashboardController::class,'index'])->name('employee');
        Route::get('/',[DashboardController::class,'index']);

        Route::group(['prefix'=>'attendance'],function (){
            Route::get('list',[employeedashboardController::class,'showAttendance']);
            Route::get('view-attendance/{attID}',[employeedashboardController::class,'singleViewAtt']);
            Route::post('filter-attendance',[employeedashboardController::class,'filterAttendance']);
        });

        Route::group(['prefix'=>'salary'],function (){
            Route::get('all',[employeedashboardController::class,'salaryList']);
            Route::post('search-all-salary-list',[employeedashboardController::class,'searchAllList']);
            Route::get('salary-view/{sa_id}',[employeedashboardController::class,'singleSalaryView']);
//            Route::get('salary-view/{sa_id}',[projectManagerAttendanceController::class,'singleSalaryView']);
        });

        Route::group(['prefix'=>'project'],function (){
            Route::get('project-list',[projectEmployeeController::class,'index']);
            Route::get('view-project/{pShowID}',[projectEmployeeController::class,'show']);
            Route::get('view-task/{taskID}',[projectEmployeeController::class,'taskView']);
            Route::post('start-task',[projectEmployeeController::class,'startTask'])->name('start.task.save');
            Route::post('complete-task',[projectEmployeeController::class,'completeTask'])->name('complete.task.save');

            Route::group(['prefix'=>'team'],function (){
                Route::get('team-list',[projectProjectManagerController::class,'showTeamList']);
            });
        });

        Route::group(['prefix'=>'loan'],function (){
            Route::get('loan-application',[loanEmployeeController::class,'index']);
            Route::post('save-loan-application',[loanEmployeeController::class,'store'])->name('save.employee.loan.application');
            Route::get('view-proposed-loan-project/{pId}',[loanEmployeeController::class,'viewProposedLoan']);
            Route::get('view-app-loan/{appLoanID}',[loanEmployeeController::class,'viewApplicationLoan']);
        });

        Route::get('change-password',[employeedashboardController::class,'changePassword']);
        Route::get('account-setting',[employeedashboardController::class,'accountSetting']);
        Route::post('employee-update-password',[employeedashboardController::class,'updatePassword'])->name('employee.change.password');
    });
    //--------------------End 2.3 Group For Employee role Access---------------

    //#.2.4.Group For Project-Manager role Access++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth','role:project-manager'],'prefix'=>'project-manager'/* employee/ */],function (){
        Route::get('dashboard',[projectManagerController::class,'index'])->name('employee');
        Route::get('/',[DashboardController::class,'index']);

        Route::get('attendance',function (){
            return redirect('project-manager/attendance/attendance-list');
        });
        Route::group(['prefix'=>'attendance'],function (){
            Route::get('attendance-list',[projectManagerAttendanceController::class,'list']);
            Route::get('view-attendance/{attID}',[projectManagerAttendanceController::class,'singleViewAtt']);
            Route::post('filter-attendance',[projectManagerAttendanceController::class,'filterAttendance']);
        });

        Route::get('salary',function (){
            return redirect('project-manager/salary/all');
        });
        Route::group(['prefix'=>'salary'],function (){
            Route::get('all',[projectManagerAttendanceController::class,'salaryList']);
            Route::post('search-all-salary-list',[projectManagerAttendanceController::class,'searchAllList']);
            Route::get('salary-view/{sa_id}',[projectManagerAttendanceController::class,'singleSalaryView']);
        });

        Route::group(['prefix'=>'account'],function (){
            Route::get('setting',[projectManagerAttendanceController::class,'accountSetting']);
            Route::get('change-password',[projectManagerAttendanceController::class,'changePassword']);
            Route::post('update-password',[employeedashboardController::class,'updatePassword'])->name('change.password');
        });

        Route::get('project',function ()
        {
            return redirect('project-manager/project/project-list');
        }
        );
        Route::group(['prefix'=>'project'],function (){
            Route::get('project-list',[projectProjectManagerController::class,'index']);
            Route::get('view-project/{pShowID}',[projectProjectManagerController::class,'show']);
            Route::post('save-task',[projectProjectManagerController::class,'storeTask'])->name('save.task');
            Route::post('task-sm-search',[projectProjectManagerController::class,'taskSearch']);
            Route::get('view-task/{taskID}',[projectProjectManagerController::class,'taskView']);
            Route::delete('delete-task',[projectProjectManagerController::class,'deleteTask'])->name('task.delete');
            Route::post('update-complete-status',[projectProjectManagerController::class,'updateCompleteStatus'])->name('update.complete.status');

            Route::group(['prefix'=>'team'],function (){
                Route::get('team-list',[projectProjectManagerController::class,'showTeamList']);
            });
        });

        Route::group(['prefix'=>'loan'],function (){
            Route::get('loan-application',[loanProjectManagerController::class,'index']);
            Route::post('save-loan-application',[loanProjectManagerController::class,'store'])->name('save.loan.application');
            Route::get('view-proposed-loan-project/{pId}',[loanProjectManagerController::class,'viewProposedLoan']);
            Route::get('view-app-loan/{appLoanID}',[loanProjectManagerController::class,'viewApplicationLoan']);
        });


    });
    //-------------End 2.3 Group For Project Manager role Access---------------

    #.2.5.For Logout+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('logout',[AuthenticatedSessionController::class,'destroy']);
    //-----------------End 2.4.For Logout-------------------------------------
});
//---------------End 2 Group for Authenticate User Access---------------------

require __DIR__.'/auth.php';
