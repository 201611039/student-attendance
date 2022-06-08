<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function IndexClassPage()
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

    public function fingerprint()
    {
        return view('attendance.fingerprint');
    }

    public function exam()
    {
        return 0;
    }
}
