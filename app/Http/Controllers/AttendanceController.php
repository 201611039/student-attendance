<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AttendanceImport;
use App\Models\Course;
use Maatwebsite\Excel\Validators\ValidationException;

class AttendanceController extends Controller
{

    public function indexClassPage()
    {
        $this->authorize('attendance-view-class');

        $lectureCourses = request()->user()->myCourses;
        return view('attendance.index', [
            'lectureCourses' => $lectureCourses
        ]);
    }

    public function classForm()
    {
        $this->authorize('attendance-take-class');

        $lectureCourses = request()->user()->myCourses;
        return view('attendance.class', [
            'lectureCourses' => $lectureCourses
        ]);
    }

    public function classAttend(Request $request)
    {
        $this->authorize('attendance-take-class');

        $request->validate([
            'course_id' => ['required', 'integer'],
            'method' => ['required', 'string'],
            'file' => ['required_if:method,file', 'file', 'mimes:xls,xlsx,ods'],
        ]);

        // Logics check  course and methods type
        if ($request->method === 'fingerprint') {

        // TODO: Logics for communication with fingerprint if necessary
            
        return 'fingerprint';
        return redirect()->route('attendance.class.fingerprint');

        } else if ($request->method === 'file') {
            try {
                (new AttendanceImport($request->course_id, $request->datetime, $request->venue))->import($request->file);
            } catch (ValidationException $e) {
                $failures = $e->failures();
                
                $allErrors = collect();
                foreach ($failures as $failure) {
                    $row = $failure->row(); // row that went wrong
                    $attribute = $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $errors = $failure->errors()[0]; // Actual error messages from Laravel validator
                    $values = $failure->values(); // The values of the row that has failed.
                    // toastr()->error("$errors on the $row row");

                    $allErrors->push("On the $row row, $errors");
                }
                return back()->withInput()->withErrors($allErrors);
            }
        } else {
            toastr()->error('Wrong input!');
            return redirect()->back()->withInput();
        }

        toastr('Attendance is taken successfully');
        return redirect()->route('attendance.list');

    }

    public function classFingerprintPage()
    {
        $this->authorize('attendance-take-class');

        return view('attendance.class-fingerprint');
    }

    public function indexExamPage()
    {
        $this->authorize('attendance-view-exam');

        return view('verification.index');
    }

    public function examForm()
    {
        $this->authorize('attendance-take-exam');

        $courses = Course::all();
        return view('verification.exam', [
            'courses' => $courses
        ]);
    }

    public function examVerify(Request $request)
    {
        $this->authorize('attendance-take-exam');

        // TODO: Logics Check course if they are free for exam
        
        // TODO: Logics for creating a exam session

        // TODO: Logics for communication with fingerprint if necessary

        return redirect()->route('exam.verification.fingerprint');
    }

    public function examFingerprintPage()
    {
        $this->authorize('attendance-take-exam');

        return view('verification.exam-fingerprint');
    }
}
