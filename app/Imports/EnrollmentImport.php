<?php

namespace App\Imports;

use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EnrollmentImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable;

    private $course_id;

    public function __construct($course_id)
    {
        $this->course_id = $course_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Enrollment([
            'academic_year_id' => AcademicYear::current()->id,
            'student_id' => $row['reg_number'],
            'course_id' => $this->course_id
        ]);
    }

    public function rules(): array
    {
        return [
            'reg_number' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                if (!Student::where('username', $value)->count()) {
                        $fail('The '.$attribute.' is invalid.');
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
