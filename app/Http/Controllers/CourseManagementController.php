<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Programme;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\CourseLecturer;
use App\Imports\EnrollmentImport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Validators\ValidationException;

class CourseManagementController extends Controller
{
    public function viewCourses()
    {
        $this->authorize('course-management-view');

        $lecturerCourses = request()->user()->myCourses;

        return view('course-management.list-courses', [
            'lecturerCourses' => $lecturerCourses
        ]);
    }

    public function enrollPage()
    {
        $this->authorize('course-management-enroll');

        $programmes = Programme::all();
        $lecturerCourses = request()->user()->myCourses;

        $students = Student::whereHas('programme.programmeCourses', function (Builder $query) use ($lecturerCourses)
        {
            $query->whereIn('course_id', $lecturerCourses->pluck('course_id'));
        })->get();
        
        return view('course-management.enroll-page', [
            'students' => $students,
            'lectureCourses' => $lecturerCourses,
            'programmes' => $programmes,
            'students' => $students
        ]);
    }

    public function enroll(Request $request)
    {
        $this->authorize('course-management-enroll');

        if ($request->method === 'students') {
            $request->validate([
                'students' => ['required', 'array'],
                'course' => ['required', 'integer']
            ]);

            foreach ($request->students as $student_id) {
                Enrollment::firstOrCreate([ // Create enrollment
                    'academic_year_id' => AcademicYear::current()->id,
                    'student_id' => $student_id,
                    'course_id' => $request->course
                ]);
            }
        } else if ($request->method === 'programme') {
            $request->validate([
                'programme_id' => ['required', 'integer'],
                'course' => ['required', 'integer'],
                'level' => ['required', 'integer']
            ]);
            
            foreach (Student::where([['programme_id', $request->programme_id], ['level', $request->level]])->get() as $student) {
                Enrollment::firstOrCreate([
                    'academic_year_id' => AcademicYear::current()->id,
                    'student_id' => $student->id,
                    'course_id' => $request->course
                ]);
            }
        } else if ($request->method === 'file') {
            $request->validate([
                'file' => ['required', 'file', 'mimes:xls,xlsx,ods'],
                'course' => ['required', 'integer']
            ]);

            try {
                (new EnrollmentImport($request->course))->import($request->file);
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

                // return $allErrors;
                // $request->flash(['errors' => $allErrors]);
                return back()->withInput()->withErrors($allErrors);
           }
        } else {
            toastr()->error('Wrong input!');
            return redirect()->back()->withInput();
        }

        toastr()->success('Enrollment completed successfully');
        return redirect()->route('view.courses');
    }

    public function allocateLecturersPage()
    {
        $this->authorize('course-management-allocate');
        
        return view('course-management.allocate-page', [
            'courses' => Course::thisSemester()->get(),
            'lecturers' => User::role('lecturer')->get(),
        ]);
    }
    
    public function allocateLecturer(Request $request)
    {
        $this->authorize('course-management-allocate');

        $request->validate([
            'courses' => ['required', 'array'],
            'lecturer' => ['required', 'integer']
        ]);

        foreach ($request->courses as $course_id) {
            CourseLecturer::firstOrCreate([
                'course_id' => $course_id,
                'lecturer_id' => $request->lecturer
            ]);
        }

        toastr()->success('Courses allocated successfully');
        return redirect()->route('allocate.lecturers');
    }
}
