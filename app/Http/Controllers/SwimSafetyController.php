<?php

namespace App\Http\Controllers;

use App\Models\ChemicAnalytics;
use App\Models\See;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class SwimSafetyController extends Controller
{
    public function index()
    {
        $lakes = See::all();

        dd($lakes);
        return Inertia::render('Fluid Managment/Edit', [
            'lakes' => $lakes,
        ]);
    }

    public function checkIfGoByChemicals() {
        $danger = 0;

        $todayChemicRecords = ChemicAnalytics::whereDate('date', Carbon::today())->firstOrFail();

        $ammomium = $todayChemicRecords->ammomium;
        $nitrit = $todayChemicRecords->nitrit;
        $nitrat = $todayChemicRecords->nitrat;
        $ortho_phosphat = $todayChemicRecords->ortho_phosphat;
        $ges_phosphor = $todayChemicRecords->ges_phosphor;
        $doc = $todayChemicRecords->doc;
        $ph = $todayChemicRecords->ph;
        $chlorid = $todayChemicRecords->chlorid;
        $temperature = $todayChemicRecords->temperature;

        if ($temperature > 10 or $ph > 9) {
            if ($ammomium > 0.2) {
                $danger = 1;
            }
        }

        if ($temperature < 10) {
            if ($ammomium > 0.4) {
                $danger = 1;
            }
        }

        if ($chlorid < 10) {
            if ($nitrit > 0.02) {
                $danger = 1;
            }
        }

        if ($chlorid > 10 and $chlorid < 20) {
            if ($nitrit > 0.05) {
                $danger = 1;
            }
        }

        if ($chlorid > 20) {
            if ($nitrit > 0.10) {
                $danger = 1;
            }
        }

        if ($nitrat > 5.6) {
            $danger = 1;
        }

        if ($ortho_phosphat > 0.04) {
            $danger = 1;
        }

        if ($ges_phosphor > 0.07) {
            $danger = 1;
        }

        if ($doc > 4) {
            $danger = 1;
        }

        return $danger;
    }
}
