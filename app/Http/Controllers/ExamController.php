<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use App\Models\CourseExam;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Traits\ExamEligibility;
use App\Traits\AttendancePercentage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    use AttendancePercentage;
    use ExamEligibility;
    
    public function indexExamPage()
    {
        $this->authorize('attendance-view-exam');

        return view('verification.index', [
            'exams' => Exam::all(),
        ]);
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

        $request->validate([
            'venue' => ['required', 'string', 'max:255'],
            'sit_date' => ['required', 'date'],
            'courses' => ['required', 'array']
        ]);

        $academicYear = AcademicYear::current();


        // Check course if they are free for exam
        $examTaken = CourseExam::whereIn('course_id', $request->courses)->whereHas('exam', function (Builder $query) use ($academicYear)
        {
            $query->where('academic_year_id', $academicYear->id);
        })->get();

        if ($examTaken->count()) {
            $message = $examTaken->pluck('course.slug')->implode(', ').' exam session already created for this academic year';
            toastr()->error('Something went wrong!');
            return back()->withInput()->withErrors(['courses' => $message]);
        }

        $coursesSlugs = Course::query()->whereIn('id', $request->courses)->get()->pluck('slug')->implode(', ');

        $name = $coursesSlugs. ' | ' .$academicYear->slug;
        // Logics for creating a exam session
        $exam = Exam::firstOrcreate([
            'name' => $name,
            'venue' => $request->venue,
            'sit_date' => $request->sit_date,
            'academic_year_id' => $academicYear->id
        ]);

        $exam->courses()->sync($request->courses);


        toastr()->success('Exam session created successfully');
        return redirect()->route('exam.verification.fingerprint', $exam->slug);
    }

    public function examFingerprintPage(Exam $exam)
    {
        $this->authorize('attendance-take-exam');

        return view('verification.exam-fingerprint', [
            'exam' => $exam,
        ]);
    }

    public function percentage()
    {
        if (is_bool($eligible = $this->checkStudentEligibility('62486499738', 1))) {
            if ($eligible) {
                return $this->takeAttendance('62486499738', 1);
            } else {
                return 0;
            }
        } else {
            return $eligible;
        }
    }
}
