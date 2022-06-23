<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Models\Period;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AttendanceImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable;

    private $course_id;
    private $period_time;
    private $venue;

    public function __construct($course_id, $period_time, $venue = null)
    {
        $this->period_time = $period_time;
        $this->course_id = $course_id;
        $this->venue = $venue;
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Period([
            'attendance_id' => Attendance::firstOrCreate([
                                    'academic_year_id' => AcademicYear::current()->id,
                                    'student_id' => Student::where('username', $row['reg_number'])->first()->id,
                                    'course_id' => $this->course_id
                                ])->id,

            'venue' => $this->venue,
            'period_time' => $this->period_time,
            'name' => Carbon::parse($this->period_time)->getTimestamp()
        ]);
    }

    public function rules(): array
    {
        return [
            'reg_number' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                if (!(Student::where('username', $value)->hasCourse($this->course_id)->first())) {
                        $fail('The '.$attribute.' of a student is not enrolled to the course selected.');
                    }
                },
            ],
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
