<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Participant;
use App\Models\Sport;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'houses' => House::orderBy('name')->get(),
            'sports' => Sport::orderBy('name')->get(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $participants = Participant::query()
            ->with(['house', 'guardian', 'sportRegistrations.sport'])
            ->when($request->house_id, fn ($query, $houseId) => $query->where('house_id', $houseId))
            ->when($request->category, fn ($query, $category) => $query->where('category', $category))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->sport_id, fn ($query, $sportId) => $query->whereHas('sportRegistrations', fn ($query) => $query->where('sport_id', $sportId)))
            ->when($request->sport_status, fn ($query, $status) => $query->whereHas('sportRegistrations', fn ($query) => $query->where('status', $status)))
            ->orderBy('name')
            ->get();

        return response()->streamDownload(function () use ($participants) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Kod', 'Nama', 'Umur', 'Telefon', 'Kategori', 'Rumah Sukan', 'Status Peserta', 'Penjaga', 'Telefon Penjaga', 'Acara', 'Status Acara']);

            foreach ($participants as $participant) {
                fputcsv($handle, [
                    $participant->registration_code,
                    $participant->name,
                    $participant->age,
                    $participant->phone,
                    $participant->category,
                    $participant->house?->name,
                    $participant->status,
                    $participant->guardian?->name,
                    $participant->guardian?->phone,
                    $participant->sportRegistrations->pluck('sport.name')->filter()->join(', '),
                    $participant->sportRegistrations->pluck('status')->filter()->join(', '),
                ]);
            }

            fclose($handle);
        }, 'senarai-peserta-sukan-budiman.csv', ['Content-Type' => 'text/csv']);
    }

    public function print(Request $request)
    {
        $participants = Participant::query()
            ->with(['house', 'guardian', 'sportRegistrations.sport'])
            ->when($request->house_id, fn ($query, $houseId) => $query->where('house_id', $houseId))
            ->when($request->category, fn ($query, $category) => $query->where('category', $category))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->sport_id, fn ($query, $sportId) => $query->whereHas('sportRegistrations', fn ($query) => $query->where('sport_id', $sportId)))
            ->when($request->sport_status, fn ($query, $status) => $query->whereHas('sportRegistrations', fn ($query) => $query->where('status', $status)))
            ->orderBy('name')
            ->get();

        return view('admin.reports.print', [
            'participants' => $participants,
            'filters' => $request->only(['house_id', 'category', 'status', 'sport_id', 'sport_status']),
        ]);
    }
}
