<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseManagementController extends Controller
{
    public function viewCourses()
    {
        $courses = [];
        return view('course-management.list-courses', [
            'courses' => $courses
        ]);
    }

    public function enrollPage()
    {
        $programmes = [];
        $tudents = [];
        return view('course-management.enroll-page', [
            'programmes' => $programmes
        ]);
    }

    public function enroll(Request $request)
    {
        return $request;
    }
}
