<?php

namespace App\Http\Controllers;

use App\Models\ChemicAnalytics;
use App\Models\FluidManagment;
use App\Models\See;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChemicAnalyticController extends Controller
{
    /**
     * Zeigt die Liste aller Datensätze in Inertia,
     * inkl. Relation zum See und einer Liste aller Seen.
     */
    public function index()
    {
        // Lade alle ChemicAnalytics mit dem zugehörigen See (Eager Loading)
        $chemicAnalytics = ChemicAnalytics::with('see')->get();

        // Lade eine Liste aller Seen (z. B. für das Dropdown im Frontend)
        $sees = See::select('id', 'name')->get();

        return Inertia::render('Chemische Daten/Index', [
            'chemicAnalytics' => $chemicAnalytics,
            'sees' => $sees,
        ]);
    }

    public function create()
    {
        return Inertia::render('Chemische Daten/Create', [
            'sees' => See::all()
        ]);
    }

    public function edit($id)
    {
        $chemicAnalytics = ChemicAnalytics::findOrFail($id);

        return Inertia::render('Chemische Daten/Edit', [
            'chemicAnalytics' => $chemicAnalytics,
            'sees' => See::all()
        ]);
    }

    /**
     * Legt einen neuen Datensatz an.
     */
    public function store(Request $request)
    {
        // Validierung (anpassen nach Bedarf)
        $validated = $request->validate([
            'see_id' => 'required|exists:seen,id',
            'datum' => 'nullable|date',
            'wetter' => 'nullable|string|max:255',
            'sonderzustand' => 'nullable|string|max:255',
            'temperatur' => 'nullable|numeric',
            'sauerstoffgehalt' => 'nullable|numeric',
            'ph' => 'nullable|numeric',
            'el' => 'nullable|numeric',
            'ung_stoffe' => 'nullable|numeric',
            'ammonium' => 'nullable|numeric',
            'nitrit' => 'nullable|numeric',
            'nitrat' => 'nullable|numeric',
            'ortho_p' => 'nullable|numeric',
            'gesamt_p' => 'nullable|numeric',
            'np_verhaltnis' => 'nullable|numeric',
            'doc' => 'nullable|numeric',
            'chlorid' => 'nullable|numeric',
            'chlorophyll' => 'nullable|numeric',
        ]);

        ChemicAnalytics::create($validated);

        // Leite zurück zur Liste, Inertia führt keinen Full-Refresh aus,
        // sondern aktualisiert die Seite inkl. flash message.
        return redirect()->route('chemic-analytics.index')
            ->with('success', 'Neuer Datensatz erfolgreich erstellt.');
    }

    /**
     * Aktualisiert einen bestehenden Datensatz.
     */
    public function update(Request $request, $id)
    {
        // Validierung (anpassen nach Bedarf)
        $validated = $request->validate([
            'see_id' => 'required|exists:seen,id',
            'datum' => 'nullable|date',
            'wetter' => 'nullable|string|max:255',
            'sonderzustand' => 'nullable|string|max:255',
            'temperatur' => 'nullable|numeric',
            'sauerstoffgehalt' => 'nullable|numeric',
            'ph' => 'nullable|numeric',
            'el' => 'nullable|numeric',
            'ung_stoffe' => 'nullable|numeric',
            'ammonium' => 'nullable|numeric',
            'nitrit' => 'nullable|numeric',
            'nitrat' => 'nullable|numeric',
            'ortho_p' => 'nullable|numeric',
            'gesamt_p' => 'nullable|numeric',
            'np_verhaltnis' => 'nullable|numeric',
            'doc' => 'nullable|numeric',
            'chlorid' => 'nullable|numeric',
            'chlorophyll' => 'nullable|numeric',
        ]);

        $chemic = ChemicAnalytics::findOrFail($id);
        $chemic->update($validated);

        return redirect()->route('chemic-analytics.index')
            ->with('success', 'Datensatz wurde aktualisiert.');
    }

    /**
     * Löscht einen Datensatz.
     */
    public function destroy($id)
    {
        $chemic = ChemicAnalytics::findOrFail($id);
        $chemic->delete();

        return redirect()->route('chemic-analytics.index')
            ->with('success', 'Datensatz wurde gelöscht.');
    }
}
