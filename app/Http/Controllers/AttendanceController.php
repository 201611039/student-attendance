<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function indexClassPage()
    {
        return view('attendance.index');
    }

    public function classForm()
    {
        $courses = [];
        return view('attendance.class', [
            'courses' => $courses
        ]);
    }

    public function classAttend(Request $request)
    {
        // TODO: Logics Check  course and methods type

        // TODO: Logics for communication with fingerprint if necessary

        return redirect()->route('attendance.class.fingerprint');
    }

    public function classFingerprintPage()
    {
        return view('attendance.class-fingerprint');
    }

    public function indexExamPage()
    {
        return view('verification.index');
    }

    public function examForm()
    {
        $courses = [];
        return view('verification.exam', [
            'courses' => $courses
        ]);
    }

    public function examVerify(Request $request)
    {
        // TODO: Logics Check course if they are free for exam
        
        // TODO: Logics for creating a exam session

        // TODO: Logics for communication with fingerprint if necessary

        return redirect()->route('exam.verification.fingerprint');
    }

    public function examFingerprintPage()
    {
        return view('verification.exam-fingerprint');
    }
}
