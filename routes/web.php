<?php

use App\Livewire\AddStudentMarks;
use App\Livewire\EditStaffDetails;
use App\Livewire\EditStudentDetails;
use App\Livewire\RetrieveStaffData;
use App\Livewire\RetrieveStudentData;
use App\Livewire\StudentRegistration;
use App\Livewire\StaffRegistration;
use App\Livewire\StudentMarksDetails;
use App\Livewire\TeacherDashboard;
use App\Livewire\StudentDashboard;
use App\Livewire\StudentReport;
use App\Livewire\StudentProfile;
use App\Livewire\TeacherReport;
use Illuminate\Support\Facades\Route;
use App\Models\Teacher;
use App\Livewire\TeachersProfile;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get("/", \App\Livewire\Home::class)->name('home');
// Route::get("/register", \App\Livewire\AdminRegister::class)->name('register');
// Route::get("/login", \App\Livewire\AdminLogin::class)->name('login');
Route::group(['middleware' => 'checkAuth'], function () {
    Route::get("/AdminLogin",  \App\Livewire\AdminLogin::class)->name('login');

    Route::get("/StaffLogin", \App\Livewire\StaffLogin::class)->name('staff');
    Route::get("/StudentLogin", \App\Livewire\StudentLogin::class)->name('student');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get("/", \App\Livewire\Home::class)->name('home');
Route::get("/register",  \App\Livewire\AdminRegister::class)->name('register');
    Route::get('/StudentRegistration', StudentRegistration::class)->name('student-registration');
    Route::get('/StaffRegistration', StaffRegistration::class)->name('staff-registration');
    Route::get('/RetrieveStaffData', RetrieveStaffData::class)->name('retrieve-staff-data');
    Route::get('/RetrieveStudentData', RetrieveStudentData::class)->name('retrieve-student-data');
    Route::get('/EditStudentDetails/{std_id}', EditStudentDetails::class)->name('edit-student-details');
    Route::get('/EditStaffDetails/{id}', EditStaffDetails::class)->name('edit-staff-details');
    Route::get('/StudentMarksDetails', StudentMarksDetails::class)->name('std-marks-details');
});
Route::get('/teachers',function(){
    return view('teachersdashboard_view');
   });
Route::get('/profile',function(){
    return view('teachersprofile_view');
   });
Route::get('/teacher/edit', function () {
    return view('teachersedit_view',);
});


// Route::get('/TeacherProfile/{id}',TeachersProfile::class)->name('teacher-profile');
Route::get('/teacher/profile/{id}',TeachersProfile::class)->name('teacher-profile');


Route::get('/teacher-dashboard', function () {
    return view('livewire.teacher-dashboard');
})->name('teacher-dashboard');

Route::get('/student-dashboard', function () {
    return view('livewire.student-dashboard');
})->name('student-dashboard');

Route::get('/student-report', function () {
    return view('livewire.student-report');
})->name('student-report');

Route::get('/student-profile', function () {
    return view('livewire.student-profile');
})->name('student-profile');

Route::get('/teacher-report', function () {
    return view('livewire.teacher-report');
})->name('teacher-report');
