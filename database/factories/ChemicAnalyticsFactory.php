<?php

namespace Database\Factories;

use App\Models\ChemicAnalytics;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChemicAnalyticsFactory extends Factory
{
    protected $model = ChemicAnalytics::class;

    /**
     * Statischer Zähler für 30 fortlaufende Tage (von vor 29 Tagen bis heute).
     */
    protected static int $dayOffset = 0;

    public static function resetDayOffset()
    {
        // Dient dazu, den dayOffset zurückzusetzen, damit wir erneut
        // bei Tag 0 beginnen können (z.B. für see_id=2).
        static::$dayOffset = 0;
    }

    public function definition()
    {
        if (static::$dayOffset >= 30) {
            // Wenn mehr als 30 Datensätze nacheinander erstellt werden,
            // klemmen wir fest auf Tag 29 (heute).
            static::$dayOffset = 29;
        }

        // Beispiel: Heute minus (29 - dayOffset)
        // => erster Datensatz vor 29 Tagen, letzter Datensatz heute
        $date = Carbon::now()->subDays(29 - static::$dayOffset)->startOfDay();
        static::$dayOffset++;

        return [
            // Wir setzen see_id hier nicht direkt (wird per state überschrieben)
            // 'see_id' => 1 oder 2 kommt aus dem Seeder-Block.

            'datum' => $date->format('Y-m-d'),
            'wetter' => $this->faker->randomElement(['Sonnig', 'Wolkig', 'Regen', 'Stürmisch']),
            'sonderzustand' => $this->faker->randomElement(['giftiges wasser', 'HIV', 'Blaualgen', 'Stürmisch']),
            'temperatur' => $this->faker->randomFloat(1, -5, 35),
            'sauerstoffgehalt' => $this->faker->randomFloat(2, 0, 15),
            'ph' => $this->faker->randomFloat(2, 5, 9),
            'el' => $this->faker->randomFloat(2, 0, 1000),
            'ung_stoffe' => $this->faker->randomFloat(2, 0, 100),
            'ammonium' => $this->faker->randomFloat(2, 0, 10),
            'nitrit' => $this->faker->randomFloat(2, 0, 10),
            'nitrat' => $this->faker->randomFloat(2, 0, 100),
            'ortho_p' => $this->faker->randomFloat(2, 0, 10),
            'gesamt_p' => $this->faker->randomFloat(2, 0, 10),
            'np_verhaltnis' => $this->faker->randomFloat(2, 0, 10),
            'doc' => $this->faker->randomFloat(2, 0, 10),
            'chlorid' => $this->faker->randomFloat(2, 0, 1000),
            'chlorophyll' => $this->faker->randomFloat(2, 0, 200),
        ];
    }
}
