<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Participant;
use App\Models\Sport;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'totalParticipants' => Participant::count(),
            'childParticipants' => Participant::where('category', 'Kanak-Kanak')->orWhere('age', '<', Participant::CHILD_AGE_THRESHOLD)->count(),
            'adultParticipants' => Participant::where('category', 'Dewasa')->count(),
            'activeParticipants' => Participant::where('status', 'Aktif')->count(),
            'participantsByHouse' => House::withCount('participants')->orderBy('name')->get(),
            'sports' => Sport::withCount('registrations')->orderBy('name')->get(),
            'latestParticipants' => Participant::with('house')->latest()->take(8)->get(),
        ]);
    }
}
