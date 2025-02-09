<?php

namespace Database\Seeders;

use App\Models\ChemicAnalytics;
use App\Models\Monitoring;
use App\Models\FluidManagment;
use App\Models\See;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Stefan Laggner',
            'email' => 'stefan@web.de',
            'password' => Hash::make('123')
        ]);

        See::factory(2)->create();
        \Database\Factories\ChemicAnalyticsFactory::resetDayOffset();

        // Für see_id = 1: 30 Datensätze
        ChemicAnalytics::factory()
            ->count(30)
            ->state([
                'see_id' => 1
            ])
            ->create();

        // Erneut zurücksetzen (damit Tag 0 wieder "vor 29 Tagen" ist)
        \Database\Factories\ChemicAnalyticsFactory::resetDayOffset();

        // Für see_id = 2: ebenfalls 30 Datensätze
        ChemicAnalytics::factory()
            ->count(30)
            ->state([
                'see_id' => 2
            ])
            ->create();
        for ($day = 0; $day < 30; $day++) {
            // Berechne das Datum: Heute minus $day Tage
            $date = Carbon::now()->subDays($day)->format('Y-m-d');

            // Für jeden See (ID 1 und 2)
            foreach ([1, 2] as $seeId) {
                // Für jeden gewünschten pegelstand-Wert (1, 3, 5)
                foreach ([1, 3, 5] as $pegelstand) {
                    Monitoring::factory()->create([
                        'see_id'     => $seeId,
                        'datum'      => $date,
                        'pegelstand' => $pegelstand,
                    ]);
                }
            }
        }
        FluidManagment::factory(10)->create();
    }
}
