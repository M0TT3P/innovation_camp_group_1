<?php

namespace App\Http\Controllers;

use App\Models\ChemicAnalytics;
use App\Models\Monitoring;
use App\Models\See;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;

class LakeController extends Controller
{
    public function index()
    {
        // 1) Lade alle Seen
        $lakes = See::all();

        // 2) Für jeden See:
        $lakes->each(function ($lake) {
            // a) Hole die heutigen (oder jüngsten) Chemie-Daten für diesen See
            //    Du kannst statt 'whereDate' auch 'orderByDesc(...)->first()' nehmen,
            //    wenn du einfach immer den neuesten Eintrag möchtest.
            $todayAnalytics = ChemicAnalytics::where('see_id', $lake->id)
                ->whereDate('datum', Carbon::today())
                ->first();

            $monitoring = Monitoring::where('see_id', $lake->id)
                ->whereDate('datum', Carbon::today())
                ->where('pegelstand', '<', '2')
                ->where('pegelstand', '>', '0')
                ->first();

            // b) Falls Eintrag vorhanden, übernehme Temperatur + Wetter
            if ($todayAnalytics and $monitoring) {
                // Beispiel: Spalten 'temperature' und 'weather'
                $lake->temperatur = $monitoring->temperatur;
                $lake->wetter = $todayAnalytics->wetter;
            } else {
                // Fallback, falls keine Daten für heute vorhanden
                $lake->temperatur = null;
                $lake->wetter = 'Keine Daten';
            }

            // c) dangerzone-Wert bestimmen
            $lake->dangerzone = $this->checkIfGoByChemicals($lake->id);
        });

        // 3) Deine Ausgabe-Map (wenn du Felder reduzieren oder umbenennen willst)
        $lakesData = $lakes->map(function ($lake) {
            return [
                'id' => $lake->id,
                'name' => $lake->name,
                'temperatur' => $lake->temperatur,
                'wetter' => $lake->wetter,
                'dangerzone' => $lake->dangerzone,
                // ggf. Image-Feld etc., je nach DB-Struktur
                'image' => $lake->image,
            ];
        });

        $visual = "Welcome";

        if (auth()->check()) {
            $visual = "Lakes/Index";
        }

        return Inertia::render($visual, [
            'lakes' => $lakesData,
        ]);
    }

    public function checkIfGoByChemicals($lakeId)
    {
        $danger = "Perfekt zum baden";

        // Beispielhaft: Hier wird nach einem Datensatz gesucht,
        // der heute erstellt wurde und der zu einem bestimmten See gehört.
        // Passe die Spalte 'see_id' entsprechend deinem DB-Schema an.
        $todayChemicRecords = ChemicAnalytics::where('see_id', $lakeId)
            ->whereDate('datum', Carbon::today())
            ->first();

        // Falls kein Eintrag für heute existiert, kann man alternativ
        // einen Standardwert zurückgeben oder die Prüfung überspringen.
        if (!$todayChemicRecords) {
            return $danger; // = 0
        }

        $ammomium = $todayChemicRecords->ammomium;
        $sonderzustand = $todayChemicRecords->sonderzustand;
        $nitrit = $todayChemicRecords->nitrit;
        $nitrat = $todayChemicRecords->nitrat;
        $ortho_phosphat = $todayChemicRecords->ortho_phosphat;
        $ges_phosphor = $todayChemicRecords->ges_phosphor;
        $doc = $todayChemicRecords->doc;
        $ph = $todayChemicRecords->ph;
        $chlorid = $todayChemicRecords->chlorid;
        $temperature = $todayChemicRecords->temperature;

        // Deine Überprüfungs-Logik
        if ($temperature > 10 or $ph > 9) {
            if ($ammomium > 0.2) {
                $danger = "Baden heute nicht empfohlen";
            }
        }

        if ($temperature < 10) {
            if ($ammomium > 0.4) {
                $danger = "Baden heute nicht empfohlen";
            }
        }

        if ($chlorid < 10) {
            if ($nitrit > 0.02) {
                $danger = "Baden heute nicht empfohlen";
            }
        }

        if ($chlorid > 10 and $chlorid < 20) {
            if ($nitrit > 0.05) {
                $danger = "Baden heute nicht empfohlen";
            }
        }

        if ($chlorid > 20) {
            if ($nitrit > 0.10) {
                $danger = "Baden heute nicht empfohlen";
            }
        }

        if ($nitrat > 5.6) {
            $danger = "Baden heute nicht empfohlen";
        }

        if ($ortho_phosphat > 0.04) {
            $danger = "Baden heute nicht empfohlen";
        }

        if ($ges_phosphor > 0.07) {
            $danger = "Baden heute nicht empfohlen";
        }

        if ($doc > 4) {
            $danger = "Baden heute nicht empfohlen";
        }

        if($sonderzustand !== null) {
            $danger = "Baden heute nicht empfohlen";
        }

        return $danger;
    }

    public function show($id)
    {
        // Den See (bzw. "Lake") anhand der ID finden
        $lake = See::findOrFail($id);

        // Lade z.B. die letzten 30 Einträge (oder 30 nach Datum sortiert)
        // aus 'chemic_analytics', die sich auf diesen See beziehen.
        // Du kannst per orderBy('datum', 'asc') oder 'desc' anpassen:
        $analytics = ChemicAnalytics::where('see_id', $id)
            ->orderBy('datum', 'asc')
            ->take(30)
            ->get();

        // Pluck die beiden Felder "temperatur" und "sauerstoffgehalt",
        // die du im Diagramm benötigst
        $temperatureData = $analytics->pluck('temperatur');
        $oxygenData = $analytics->pluck('sauerstoffgehalt');

        return Inertia::render('Lakes/Graph', [
            'lake' => $lake, // optional, falls du Name/Infos im Template brauchst
            'temperatureData' => $temperatureData,
            'oxygenData' => $oxygenData,
        ]);
    }
}
