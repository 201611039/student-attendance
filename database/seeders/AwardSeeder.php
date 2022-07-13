<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete all awards First
    	Award::query()->delete();

        $awards = ['Certificate', 'Diploma', 'Bachelor', 'Post-Graduate Diploma','Masters', 'PhD'];

        foreach ($awards as $award) {
        	Award::firstOrCreate(
                [ 'name' => $award ],
            );
        }
    }
}
