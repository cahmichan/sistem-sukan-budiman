<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportRequest;
use App\Models\AuditLog;
use App\Models\Sport;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sports.index', [
            'sports' => Sport::withCount(['registrations', 'acceptedRegistrations', 'waitingListRegistrations'])->orderBy('category')->orderBy('name')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sports.create', ['sport' => new Sport(['is_active' => true])]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SportRequest $request)
    {
        $sport = Sport::create($request->validated() + ['is_active' => $request->boolean('is_active')]);
        AuditLog::record('create', $sport, null, $sport->toArray());

        return redirect()->route('admin.sports.index')->with('success', 'Acara sukan berjaya ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
        return redirect()->route('admin.sports.edit', $sport);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sport $sport)
    {
        return view('admin.sports.edit', compact('sport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SportRequest $request, Sport $sport)
    {
        $newCapacity = $request->integer('max_players_per_group') ?: null;
        $acceptedCount = $sport->acceptedRegistrations()->count();

        if ($newCapacity && $newCapacity < $acceptedCount) {
            return back()
                ->withInput()
                ->with('error', "Kapasiti tidak boleh kurang daripada {$acceptedCount} peserta yang telah diterima.");
        }

        $oldValues = $sport->toArray();
        $sport->update($request->validated() + ['is_active' => $request->boolean('is_active')]);
        AuditLog::record('update', $sport, $oldValues, $sport->toArray());

        return redirect()->route('admin.sports.index')->with('success', 'Acara sukan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        if ($sport->registrations()->exists()) {
            return back()->with('error', 'Acara ini masih mempunyai pendaftaran peserta.');
        }

        $oldValues = $sport->toArray();
        $sport->delete();
        AuditLog::record('delete', $sport, $oldValues, null);

        return redirect()->route('admin.sports.index')->with('success', 'Acara sukan berjaya dipadam.');
    }
}
