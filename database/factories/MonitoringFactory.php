<?php

namespace Database\Factories;

use App\Models\Monitoring;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MonitoringFactory extends Factory
{
    protected $model = Monitoring::class;

    public function definition()
    {
        return [
            // Standardmäßig wird hier ein zufälliger Wert erzeugt,
            // aber in unserem Seeder überschreiben wir 'see_id', 'datum' und 'pegelstand'
            'see_id'       => $this->faker->randomElement([1, 2]),
            'datum'        => Carbon::now()->format('Y-m-d'),
            'pegelstand'   => $this->faker->randomFloat(2, 0, 100),
            'verdunstung'  => $this->faker->randomFloat(2, 0, 10),
            'niederschlag' => $this->faker->randomFloat(2, 0, 50),
            'temperatur'   => $this->faker->randomFloat(2, -10, 35),
        ];
    }
}
