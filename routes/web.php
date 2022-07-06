<?php

use App\Models\College;
use App\Models\Programme;
use App\Models\Department;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseManagementController;
use App\Http\Controllers\Auth\WebAuthnLoginController;
use App\Http\Controllers\Auth\WebAuthnRegisterController;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function ()
{
    Route::get('dashboard', function ()
    {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);

    Route::post('roles/{role}/grant-permission', [RoleController::class, 'grant'])->name('role.grant');
    Route::resource('roles', RoleController::class);

    Route::prefix('course-management')->controller(CourseManagementController::class)->group(function ()
    {
        Route::get('/', 'viewCourses')->name('view.courses');
        Route::get('/enroll', 'enrollPage')->name('enroll.students');
        Route::post('/enroll', 'enroll')->name('enroll.students.store');

        Route::get('/allocate', 'allocateLecturersPage')->name('allocate.lecturers');
        Route::post('/allocate', 'allocateLecturer')->name('allocate.lecturers.store');
    });

    Route::middleware('permission:college-view')->get('colleges', function ()
    {
        return view('colleges.index', ['colleges' => College::all()]);
    })
    ->name('college.index');

    Route::middleware('permission:departement-view')->get('departements', function ()
    {
        return view('departments.index', ['departments' => Department::all()]);
    })
    ->name('department.index');

    Route::middleware('permission:programme-view')->get('programmes', function ()
    {
        return view('programmes.index', ['programmes' => Programme::all()]);
    })
    ->name('programme.index');
    
    Route::controller(AttendanceController::class)->group(function ()
    {
        Route::get('/class-attendance-list', 'indexClassPage')->name('attendance.list');
        Route::get('/class-attendance-details/{period_name}/{course_id}', 'detailsClassPage')->name('attendance.details');
        Route::get('/class', 'classForm')->name('attendance.class');
        Route::post('/class', 'classAttend')->name('attendance.class.check');
        Route::get('/class/attendance', 'classFingerprintPage')->name('attendance.class.fingerprint');
    });
    
    Route::controller(ExamController::class)->group(function ()
    {
        Route::get('/exam-verification-list', 'indexExamPage')->name('exam.list');
        Route::get('/exam', 'examForm')->name('verification.exam');
        Route::post('/exam', 'examVerify')->name('verification.exam.check');
        Route::get('/exam/verification', 'examFingerprintPage')->name('exam.verification.fingerprint');
    });

    Route::get('/test', [ExamController::class, 'percentage']);
    Route::get('/fingerprint-test', function ()
    {
        return view('test');
    });


    Route::post('webauthn/register/options', [WebAuthnRegisterController::class, 'options'])
    ->name('webauthn.register.options');
    Route::post('webauthn/register', [WebAuthnRegisterController::class, 'register'])
    ->name('webauthn.register');

    Route::post('webauthn/login/options', [WebAuthnLoginController::class, 'options'])
    ->name('webauthn.login.options');
    Route::post('webauthn/login', [WebAuthnLoginController::class, 'login'])
    ->name('webauthn.login');



});


