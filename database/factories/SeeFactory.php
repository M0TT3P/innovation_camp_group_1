<?php

namespace Database\Factories;

use App\Models\See;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeeFactory extends Factory
{
    protected $model = See::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->city(),
        ];
    }
}
