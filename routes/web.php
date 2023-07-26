<?php

use App\Models\Holiday;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\AwardTypeController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SetSalaryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\IpRestrictController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SetAllowanceController;
use App\Http\Controllers\SetComissionController;
use App\Http\Controllers\SetDeductionController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\MonthlySalaryController;
use App\Http\Controllers\SetCommissionController;
use App\Http\Controllers\AllowanceOptionController;
use App\Http\Controllers\TerminationTypeController;
use App\Http\Controllers\ManualAttendanceController;
use App\Http\Controllers\PayrollDatatableController;
use App\Http\Controllers\PerformanceMetricController;
use App\Http\Controllers\AttendanceEmployeeController;
use App\Http\Controllers\SetSalaryDatatableController;
use App\Http\Controllers\EmployeePerformanceController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\PerformanceCriterionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimetrackerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', 'HomeController@home')
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/', 'HomeController@home')
    ->name('index')
    ->middleware(['auth']);
Route::get('/home', 'HomeController@home')
    ->name('home')
    ->middleware(['auth']);

Route::middleware(['auth'])->group(function () {

    Route::resource('user', 'UserController');

    Route::resource('roles', 'RoleController');

    Route::resource('branch', 'BranchController');

    Route::resource('department', 'DepartmentController');

    Route::get('department-branch/{branch}', 'DepartmentController@fetchDepartment')->name('department.get');
    Route::get('department-branches', 'DepartmentController@fetchDepartmentFromBranches')->name('department.branches');

    Route::resource('designation', 'DesignationController');

    Route::resource('document', 'DocumentController');

    Route::resource('allowance-option', 'AllowanceOptionController');

    Route::resource('leavetype', 'LeaveTypeController');

    Route::resource('terminationtype', 'TerminationTypeController');

    Route::resource('award', 'AwardController');

    Route::resource('awardtype', 'AwardTypeController');

    Route::resource('trainingtype', 'TrainingTypeController');

    Route::resource('jobcategory', 'JobCategoryController');

    Route::resource('jobstage', 'JobStageController');

    Route::post('job-stage/order', 'JobStageController@order')->name('jobstage.order');

    Route::resource('employee', 'EmployeeController');
    Route::get('employee-search', [EmployeeController::class, 'employeeSearch'])->name('employee.search');
    Route::get('employee/document/{employeeDocument}', [EmployeeController::class, 'getDocument'])->name('employee.document');
    Route::get('/file-import', [ImportController::class, 'importView'])->name('import.view');
    Route::post('/import', [ImportController::class, 'import'])->name('import');

    Route::resource('leave', 'LeaveController');

    Route::get('leave/{id}/action', 'LeaveController@action')->name('leave.action');

    Route::post('leave/changeaction', 'LeaveController@changeaction')->name('leave.changeaction');

    Route::resource('shift', 'ShiftController');

    Route::resource('meeting', 'MeetingController');

    Route::resource('trainer', 'TrainerController');

    Route::resource('training', 'TrainingController');

    Route::resource('transfer', 'TransferController');

    Route::resource('travel', 'TravelController');

    Route::resource('promotion', 'PromotionController');

    Route::resource('resignation', 'ResignationController');

    Route::resource('termination', 'TerminationController');

    Route::resource('ip-restrict', 'IpRestrictController');

    Route::resource('announcement', 'AnnouncementController');

    Route::resource('overview', 'OverviewController');

    Route::resource('setting', 'SettingController');
    Route::post('business-setting', 'SettingController@saveBusinessSettings')->name('business.setting');

    Route::get('profile/{user?}', 'UserController@profile')->name('user.profile');
    Route::get('change-password', 'UserController@changePassword')->name('user.change-password');

    Route::post('profile-update/{profile}', 'UserController@profile_update')->name('profile.update');
    Route::post('change-password', 'UserController@updatePassword')->name('update.password');

    Route::resource('attendance', 'AttendanceEmployeeController');
    Route::patch('manual-attendance/{attendance}', [ManualAttendanceController::class, 'update'])->name('manual.attendance.update');

    Route::resource('employee-performance', 'EmployeePerformanceController');
    Route::post('branch/employee/json', 'EmployeePerformanceController@employeeJson')->name('branch.employee.json');

    Route::resource('performance-metric', 'PerformanceMetricController');

    Route::post('training/status', 'TrainingController@updateStatus')->name('training.status');

    Route::get('set-salary', [SetSalaryController::class, 'index'])->name('set.salary.index');
    Route::get('set-salary/{employee}', [SetSalaryController::class, 'create'])->name('set.salary.create');

    Route::get('set-salary', [SetSalaryController::class, 'index'])->name('set.salary.index');

    Route::prefix('set-allowance')->group(function () {
        Route::get('/show/{allowance}', [SetAllowanceController::class, 'show'])->name('set.allowance.show');
        Route::post('{employee}', [SetAllowanceController::class, 'store'])->name('set.allowance.store');
        Route::patch('{allowance}', [SetAllowanceController::class, 'update'])->name('set.allowance.store');
        Route::delete('{allowance}', [SetAllowanceController::class, 'destroy'])->name('set.allowance.destroy');
    });

    Route::prefix('set-commission')->group(function () {
        Route::get('/show/{commission}', [SetCommissionController::class, 'show'])->name('set.commission.show');
        Route::post('{employee}', [SetCommissionController::class, 'store'])->name('set.commission.store');
        Route::patch('{commission}', [SetCommissionController::class, 'update'])->name('set.commission.store');
        Route::delete('{commission}', [SetCommissionController::class, 'destroy'])->name('set.commission.destroy');
    });

    Route::prefix('set-deduction')->group(function () {
        Route::get('/show/{deduction}', [SetDeductionController::class, 'show'])->name('set.deduction.show');
        Route::post('{employee}', [SetDeductionController::class, 'store'])->name('set.deduction.store');
        Route::patch('{deduction}', [SetDeductionController::class, 'update'])->name('set.deduction.store');
        Route::delete('{deduction}', [SetDeductionController::class, 'destroy'])->name('set.deduction.destroy');
    });

    Route::prefix('loan')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('loan.index');
        Route::post('/', [LoanController::class, 'store'])->name('loan.store');
    });

    Route::prefix('data')->group(function () {
        Route::get('employee-allowance/{employee}', [SetSalaryDatatableController::class, 'employeeAllowance'])->name('employee.allowance.data');
        Route::get('training', [TrainingController::class, 'loadDatatable'])->name('training.data');
        Route::get('trainer', [TrainerController::class, 'loadDatatable'])->name('trainer.data');
        Route::get('training-type', [TrainingTypeController::class, 'loadDatatable'])->name('training.type.data');
        Route::get('department', [DepartmentController::class, 'loadDatatable'])->name('department.data');
        Route::get('designation', [DesignationController::class, 'loadDatatable'])->name('designation.data');
        Route::get('award', [AwardController::class, 'loadDatatable'])->name('award.data');
        Route::get('awardType', [AwardTypeController::class, 'loadDatatable'])->name('award.type.data');
        Route::get('leavetype', [LeaveTypeController::class, 'loadDatatable'])->name('leave.type.data');
        Route::get('allowance-option', [AllowanceOptionController::class, 'loadDatatable'])->name('allowance.option.data');
        Route::get('terminationtype', [TerminationTypeController::class, 'loadDatatable'])->name('termination.type.data');
        Route::get('jobcategory', [JobCategoryController::class, 'loadDatatable'])->name('job.category.data');
        Route::get('branch', [BranchController::class, 'loadDatatable'])->name('branch.data');
        Route::get('document', [DocumentController::class, 'loadDatatable'])->name('document.data');
        Route::get('meeting', [MeetingController::class, 'loadDatatable'])->name('meeting.data');
        Route::get('transfer', [TransferController::class, 'loadDatatable'])->name('transfer.data');
        Route::get('travel', [TravelController::class, 'loadDatatable'])->name('travel.data');
        Route::get('promotion', [PromotionController::class, 'loadDatatable'])->name('promotion.data');
        Route::get('resignation', [ResignationController::class, 'loadDatatable'])->name('resignation.data');
        Route::get('termination', [TerminationController::class, 'loadDatatable'])->name('termination.data');
        Route::get('employee', [EmployeeController::class, 'loadDatatable'])->name('employee.data');
        Route::get('leave', [LeaveController::class, 'loadDatatable'])->name('leave.data');
        Route::get('user', [UserController::class, 'loadDatatable'])->name('user.data');
        Route::get('role', [RoleController::class, 'loadDatatable'])->name('role.data');
        Route::get('ip-restrict', [IpRestrictController::class, 'loadDatatable'])->name('ip.data');
        Route::get('attendance', [AttendanceEmployeeController::class, 'loadDatatable'])->name('attendance.data');
        Route::get('employee-allowance/{employee}', [PayrollDatatableController::class, 'employeeAllowance'])->name('employee.allowance.data');
        Route::get('employee-commission/{employee}', [PayrollDatatableController::class, 'employeeCommission'])->name('employee.commission.data');
        Route::get('employee-deduction/{employee}', [PayrollDatatableController::class, 'employeeDeduction'])->name('employee.deduction.data');
        Route::get('loan', [LoanController::class, 'data'])->name('loan.data');
        Route::get('loan-type', [LoanTypeController::class, 'data'])->name('loan.type.data');
        Route::get('employee-performance', [EmployeePerformanceController::class, 'loadDatatable'])->name('employee.performance.data');
        Route::get('performance-criterion', [PerformanceCriterionController::class, 'data'])->name('performance.criterion.data');
        Route::get('performance-metric', [PerformanceMetricController::class, 'loadDatatable'])->name('performance.metric.data');
        Route::get('announcement', [AnnouncementController::class, 'loadDatatable'])->name('announcement.data');
        Route::get('set-salary', [SetSalaryController::class, 'data'])->name('set-salary.data');
        Route::get('monthly-salary/{year}/{month}', [MonthlySalaryController::class, 'data'])->name('monthly.salary.data');
        Route::get('notice', [NoticeController::class, 'data'])->name('notice.data');
        Route::get('holiday', [HolidayController::class, 'data'])->name('holiday.data');
        Route::get('employee-leave', [LeaveController::class, 'leaveReportDatatable'])->name('leave.report.data');
        Route::get('shifts', [ShiftController::class, 'loadDatatable'])->name('shift.data');
    });

    Route::get('calender-notice', [CalendarController::class, 'futureNotice'])->name('future.notice');
    Route::post('notice/clear-all', [NoticeController::class, 'clearAll'])->name('notice.clear.all');
    Route::patch('notice/{notice}', [NoticeController::class, 'update'])->name('notice.update');

    Route::prefix('monthly-salary')->group(function () {
        Route::get('', [MonthlySalaryController::class, 'index'])->name('monthly.salary.index');
        Route::get('/show', [MonthlySalaryController::class, 'showGenerated'])->name('monthly.salary.show');
        Route::get('create', [MonthlySalaryController::class, 'create'])->name('monthly.salary.create');
        Route::post('', [MonthlySalaryController::class, 'store'])->name('monthly.salary.store');
        Route::get('/show/{paySlip}', [MonthlySalaryController::class, 'show'])->name('monthly.salary.payslip');
    });

    Route::prefix('loantype')->group(function () {
        Route::get('', [LoanTypeController::class, 'index'])->name('loan.type.index');
        Route::get('{loanType}/edit', [LoanTypeController::class, 'edit'])->name('loan.type.edit');
        Route::patch('{loanType}', [LoanTypeController::class, 'update'])->name('loan.type.store');
        Route::post('', [LoanTypeController::class, 'store'])->name('loan.type.store');
        Route::delete('{loanType}', [LoanTypeController::class, 'destroy'])->name('loan.type.destroy');
    });

    Route::prefix('performance-criterion')->group(function () {
        Route::get('', [PerformanceCriterionController::class, 'index'])->name('performance.criterion.index');
        Route::get('{performanceCriterion}/edit', [PerformanceCriterionController::class, 'edit'])->name('performance.criterion.edit');
        Route::patch('{performanceCriterion}', [PerformanceCriterionController::class, 'update'])->name('performance.criterion.store');
        Route::post('', [PerformanceCriterionController::class, 'store'])->name('performance.criterion.store');
        Route::delete('{performanceCriterion}', [PerformanceCriterionController::class, 'destroy'])->name('performance.criterion.destroy');
    });
    Route::prefix('graph')->group(function () {
        Route::get('department-wise-employee', [GraphController::class, 'departmentWiseEmployee'])->name('department.wise.employee');
        Route::get('designation-wise-employee', [GraphController::class, 'designationWiseEmployee'])->name('designation.wise.employee');
        Route::get('today-employee-attendance', [GraphController::class, 'todayEmployeeAttendance'])->name('todays.employee.attendance');
        Route::get('last-announcements', [GraphController::class, 'lastAnnouncements'])->name('last.announcements');
        Route::get('employee-work-hour', [GraphController::class, 'employeeWorkHour'])->name('employee.work.hour');
    });
    Route::prefix('holiday')->group(function () {
        Route::get('', [HolidayController::class, 'index'])->name('holiday.index');
        Route::get('/{holiday}', [HolidayController::class, 'show'])->name('holiday.show');
        Route::patch('/{holiday}', [HolidayController::class, 'update'])->name('holiday.update');
        Route::delete('/{holiday}', [HolidayController::class, 'destroy'])->name('holiday.destroy');
        Route::post('', [HolidayController::class, 'store'])->name('holiday.store');
    });

    Route::prefix('report')->group(function () {
        Route::get('daily-attendance-report', [AttendanceEmployeeController::class, 'dailyAttendanceReport'])->name('daily.attendance.report');
        Route::get('employee-leave-report', [LeaveController::class, 'employeeLeaveReport'])->name('employee.leave.report');
    });


    Route::get('shedule', [GraphController::class, 'shedule']);

    Route::resource('project', 'ProjectController');
    Route::resource('employee-project', 'EmployeeProjectController');

    Route::patch('/employee/project/remove', [ProjectController::class, 'removeProjectEmployee'])->name('employee.project.remove');
    Route::patch('/employee/project/reassign', [ProjectController::class, 'reassignProjectEmployee'])->name('employee.project.reassign');

    Route::patch('weekend', [HolidayController::class, 'weekendUpdate'])->name('weekend.update');

    Route::get('timetracker/{employee}', [TimetrackerController::class, 'index'])->name('employee.timetracker');
    Route::get('timetracker/project/{employee_project}', [TimetrackerController::class, 'projectWiseEmployee'])->name('employee.project.timetracker');
});

Route::get('/password', function () {
    return bcrypt('Admin@123');
});
