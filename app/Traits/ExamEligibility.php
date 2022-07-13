<?php
namespace App\Traits;

use App\Models\Exam;
use App\Models\Student;
use App\Models\AcademicYear;
use Carbon\Carbon;

/**
 * ExamEligibility
 */
trait ExamEligibility
{
    use AttendancePercentage;
    protected $exam;
    protected $username;
    protected $year;
    protected $eligiblePercentage = 75;

    public function checkStudentEligibility(string $username, int $examId, AcademicYear $year = null)
    {
        if (!$year) {
            $this->year = AcademicYear::current();
        } else {
            $this->year = $year;
        }

        $this->student = Student::where('username', $username)->first();
        $this->exam = Exam::where('id', $examId)->first();

        $courseId = $this->findStudentCourse();

        if ($courseId) {
            $studentPercentages = $this->getPercentageByStudent($courseId, $this->student, $year);
        
            if ($studentPercentages >= $this->eligiblePercentage) return true; else return false;
        } else {
            return 'Student is not selected to sit for this exam';
        }
        
    }

    public function findStudentCourse()
    {
        $courseIds = $this->exam->examCourses->pluck('course_id');
        return $this->student->enrollments()->where('academic_year_id', $this->year->id)->whereIn('course_id', $courseIds)->pluck('course_id')->first();
    }

    public function takeAttendance(string $studentId, int $examId, AcademicYear $year = null)
    {
        if (!$year) {
            $this->year = AcademicYear::current();
        } else {
            $this->year = $year;
        }

        $this->student = Student::where('username', $studentId)->first();
        $this->exam = Exam::where('id', $examId)->first();

        $courseId = $this->findStudentCourse();
        $examSession = $this->exam->examCourses()->where('course_id', $courseId)->first();
        
        $studentIds = collect($examSession->students_id);

        $examSession->update([
            'students_id' => $studentIds->merge($studentId)->unique()->toArray(),
        ]);
    }
}
