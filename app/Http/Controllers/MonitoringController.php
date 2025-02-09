<?php

namespace App\Http\Controllers;

use App\Models\FluidManagment;
use App\Models\Monitoring;
use App\Models\See;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitoringController extends Controller
{
    /**
     * Zeigt die Liste aller Datensätze in Inertia,
     * inkl. Relation zum See und einer Liste aller Seen.
     */
    public function index()
    {
        // Lade alle Monitoring mit dem zugehörigen See (Eager Loading)
        $monitoring = Monitoring::with('see')->get();

        // Lade eine Liste aller Seen (z. B. für das Dropdown im Frontend)
        $sees = See::select('id', 'name')->get();

        return Inertia::render('Pegeldaten/Index', [
            'monitoring' => $monitoring,
            'sees' => $sees,
        ]);
    }

    public function create()
    {
        return Inertia::render('Pegeldaten/Create', [
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
            'pegelstand' => 'nullable|numeric',
            'datum' => 'nullable|date',
            'verdunstung' => 'nullable|numeric',
            'niederschlag' => 'nullable|numeric',
            'temperatur' => 'nullable|numeric'
        ]);

        Monitoring::create($validated);

        // Leite zurück zur Liste, Inertia führt keinen Full-Refresh aus,
        // sondern aktualisiert die Seite inkl. flash message.
        return redirect()->route('monitoring.index')
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
            'pegelstand' => 'nullable|numeric',
            'datum' => 'nullable|date',
            'verdunstung' => 'nullable|numeric',
            'niederschlag' => 'nullable|numeric',
            'temperatur' => 'nullable|numeric'
        ]);

        $monitoring = Monitoring::findOrFail($id);
        $monitoring->update($validated);

        return redirect()->route('monitoring.index')
            ->with('success', 'Datensatz wurde aktualisiert.');
    }

    public function edit($id)
    {
        $monitoring = Monitoring::findOrFail($id);

        return Inertia::render('Pegeldaten/Edit', [
            'monitoring' => $monitoring,
            'sees' => See::all()
        ]);
    }

    /**
     * Löscht einen Datensatz.
     */
    public function destroy($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        $monitoring->delete();

        return redirect()->route('monitoring.index')
            ->with('success', 'Datensatz wurde gelöscht.');
    }
}
