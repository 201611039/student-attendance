<?php

namespace Database\Factories;

use App\Models\Award;
use App\Models\Programme;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $programmeCount = Programme::count();
        $gender = (['male', 'female']);

        // choose programme id
        $programme_id = $this->faker->numberBetween(1, $programmeCount);

        // Choose level from programme selected
        $level = $this->faker->numberBetween(1, Programme::find($programme_id)->duration);

        // Choose gender for name purpose
        $genderNumber = $this->faker->numberBetween(0,1);
        
        return [
            'first_name' => $this->faker->firstName($gender[$genderNumber]),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->email(),
            'username' => $this->faker->unique()->numberBetween(210230022210, 22102999999),
            'phone' => $this->faker->phoneNumber(),
            'programme_id' => $programme_id,
            'level' => $level,
        ];
    }
}
