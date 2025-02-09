<?php

namespace Database\Factories;

use App\Models\FluidManagment;
use App\Models\See;
use Illuminate\Database\Eloquent\Factories\Factory;

class FluidManagmentFactory extends Factory
{
    protected $model = FluidManagment::class;

    public function definition()
    {
        return [
            'see_id' => $this->faker->randomElement([1, 2]),
            'type' => $this->faker->word,
            'comming_from' => $this->faker->word,
            'going_too' => $this->faker->word,
            'reason' => $this->faker->sentence,
            'started_drain' => $this->faker->date(),
            'ended_drain' => $this->faker->date(),
            'menge' => $this->faker->randomFloat(2, 0, 100),
            'datum' => $this->faker->date(),
            'pegelstand_vor' => $this->faker->randomFloat(2, 0, 100),
            'pegelstand_nach' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
