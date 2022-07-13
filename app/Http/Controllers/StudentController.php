<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function studentList()
    {
        return view('students.index', [
            'students' => Student::all(),
        ]);
    }

    public function studentFingerprintEnrollPage(Student $student)
    {
        return view('students.enroll-page', [
            'students' => $student::all(),
            'student' => $student
        ]);
    }
}
