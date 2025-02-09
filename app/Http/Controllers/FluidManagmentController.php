<?php

namespace App\Http\Controllers;

use App\Models\FluidManagment;
use App\Models\See;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FluidManagmentController extends Controller
{
    /**
     * Anzeigen aller FluidManagement-Datensätze.
     */
    public function index()
    {
        $fluidManagement = FluidManagment::with('see')->get();

        return Inertia::render('Fluid Managment/Index', [
            'fluidManagement' => $fluidManagement,
            'sees' => See::all()
        ]);
    }

    /**
     * Zeigt das Formular zum Erstellen eines neuen FluidManagement-Datensatzes.
     */
    public function create()
    {
        return Inertia::render('Fluid Managment/Create', [
            'sees' => See::all()
        ]);
    }

    /**
     * Speichert einen neuen FluidManagement-Datensatz.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'see_id' => 'required|exists:sees,id',
            'type' => 'nullable|string',
            'comming_from' => 'nullable|string',
            'going_too' => 'nullable|string',
            'reason' => 'nullable|string',
            'started_drain' => 'nullable|date',
            'ended_drain' => 'nullable|date',
            'pegelstand_vor' => 'nullable|numeric',
            'pegelstand_nach' => 'nullable|numeric',
            'menge' => 'nullable|numeric',
            'datum' => 'required|date',
        ]);

        FluidManagment::create($validated);

        return redirect()->route('fluidManagement.index');
    }

    /**
     * Zeigt das Formular zum Bearbeiten eines bestehenden FluidManagement-Datensatzes.
     */
    public function edit($id)
    {
        $fluidManagement = FluidManagment::findOrFail($id);

        return Inertia::render('Fluid Managment/Edit', [
            'fluidManagement' => $fluidManagement,
            'sees' => See::all()
        ]);
    }

    /**
     * Aktualisiert einen bestehenden FluidManagement-Datensatz.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'see_id' => 'required|exists:sees,id',
            'type' => 'nullable|string',
            'comming_from' => 'nullable|string',
            'going_too' => 'nullable|string',
            'reason' => 'nullable|string',
            'started_drain' => 'nullable|date',
            'ended_drain' => 'nullable|date',
            'pegelstand_vor' => 'nullable|numeric',
            'pegelstand_nach' => 'nullable|numeric',
            'menge' => 'nullable|numeric',
            'datum' => 'required|date',
        ]);

        $fluidManagement = FluidManagment::findOrFail($id);
        $fluidManagement->update($validated);

        return redirect()->route('fluidManagement.index');
    }

    /**
     * Löscht einen FluidManagement-Datensatz.
     */
    public function destroy($id)
    {
        $fluidManagement = FluidManagment::findOrFail($id);
        $fluidManagement->delete();

        return redirect()->route('fluidManagement.index');
    }
}
