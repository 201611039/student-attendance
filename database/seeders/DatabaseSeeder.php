<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AwardSeeder::class);

        AcademicYear::firstOrCreate([
            'name' => now()->year.'/'.now()->addYear()->year,
            'semester' => 1,
            'end_date' => now()->endOfYear()
        ]);

        // $this->call(SqlFileSeeder::class);
        
        Student::factory()->count(2000)->create();
    }
}
