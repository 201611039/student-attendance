<?php
namespace App\Traits;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Student;

/**
 * Attendance
 */
trait AttendancePercentage
{
    public function getPercentageByStudent($courseId, Student $student, AcademicYear $year = null)
    {
        if (!$year) {
            $year = AcademicYear::current();
        }

        $course = Course::find($courseId);
        
        // get attendance by year
        $attendances = $course->getAttendancesByYear($year)->get(); 
        
        // get maximum number of period lecturer has attendanded
        $maxNumberOfPeriod = $attendances->map(function ($item, $key)
        {
            return $item->periods->count();
        })->max();

        $studentAttendance = $student->courseAttendance($courseId, $year)->first();

        if ($studentAttendance) {
            $numberOfPeriod = $studentAttendance->periods->count();
        } else {
            $numberOfPeriod = 0;
        }

        return round(($numberOfPeriod/$maxNumberOfPeriod)*100);
        
    }

    
    public function getPercentageByCourse($courseId, AcademicYear $year = null)
    {
        if (!$year) {
            $year = AcademicYear::current();
        }

        $course = Course::find($courseId);
        $enrollments = $course->getEnrollmentsByYear($year)->with('student.programme')->get();

        return $enrollments->map(function ($item, $key) use ($year)
        {
           return [
            'percentage' => $this->getPercentageByStudent($item->course_id, $item->student, $year),
            'student_name' => $item->student->full_name,
            'username' => $item->student->username,
            'student_programme' => $item->student->programme->name,
           ];
        });
        
    }


}
