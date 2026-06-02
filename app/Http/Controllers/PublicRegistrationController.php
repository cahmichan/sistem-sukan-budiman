<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Models\Guardian;
use App\Models\House;
use App\Models\Participant;
use App\Models\Setting;
use App\Models\Sport;
use App\Models\SportRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicRegistrationController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }

    public function create()
    {
        if (! Setting::registrationIsOpen()) {
            return view('public.closed', ['settings' => Setting::allAsArray()]);
        }

        return view('public.register', [
            'houses' => House::orderBy('name')->get(),
            'sports' => Sport::where('is_active', true)->withCount([
                'acceptedRegistrations',
                'waitingListRegistrations',
            ])->orderBy('category')->orderBy('name')->get(),
            'childAgeThreshold' => Participant::CHILD_AGE_THRESHOLD,
        ]);
    }

    public function store(StoreParticipantRequest $request)
    {
        if (! Setting::registrationIsOpen()) {
            return response()->view('public.closed', ['settings' => Setting::allAsArray()], 403);
        }

        $data = $request->validated();
        $participant = DB::transaction(function () use ($data) {
            $guardian = null;
            $category = Participant::categoryForAge((int) $data['age']);

            if ($category === 'Kanak-Kanak') {
                $guardian = Guardian::create([
                    'name' => $data['guardian_name'],
                    'phone' => $data['guardian_phone'],
                    'relationship' => $data['guardian_relationship'],
                ]);
            }

            $participant = Participant::create([
                'registration_code' => $this->generateRegistrationCode(),
                'name' => $data['name'],
                'age' => $data['age'],
                'phone' => $data['phone'],
                'category' => $category,
                'house_id' => $data['house_id'],
                'guardian_id' => $guardian?->id,
                'status' => 'Aktif',
            ]);

            $sport = Sport::lockForUpdate()->findOrFail($data['sport_id']);
            SportRegistration::create([
                'participant_id' => $participant->id,
                'sport_id' => $sport->id,
                'status' => $sport->hasCapacity() ? 'Diterima' : 'Senarai Menunggu',
            ]);

            return $participant;
        });

        return redirect()->route('public.success', $participant->registration_code);
    }

    public function success(string $registrationCode)
    {
        $participant = Participant::with(['house', 'sportRegistrations.sport'])->where('registration_code', $registrationCode)->firstOrFail();

        return view('public.success', compact('participant'));
    }

    public function check()
    {
        return view('public.check');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string', 'max:255'],
        ], ['search.required' => 'Sila masukkan kod pendaftaran atau nombor telefon.']);

        $search = $this->normalizeSearch($request->input('search'));

        $participants = Participant::with(['house', 'guardian', 'sportRegistrations.sport'])
            ->where('registration_code', $search)
            ->orWhere('phone', $search)
            ->latest()
            ->get();

        return view('public.status', compact('participants', 'search'));
    }

    public function status(string $registrationCode)
    {
        $participants = Participant::with(['house', 'guardian', 'sportRegistrations.sport'])
            ->where('registration_code', $registrationCode)
            ->get();

        abort_if($participants->isEmpty(), 404);

        return view('public.status', ['participants' => $participants, 'search' => $registrationCode]);
    }

    private function generateRegistrationCode(): string
    {
        do {
            $code = 'SRKB-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
        } while (Participant::where('registration_code', $code)->exists());

        return $code;
    }

    private function normalizeSearch(string $search): string
    {
        $search = trim($search);

        if (str_starts_with(strtoupper($search), 'SRKB-')) {
            return strtoupper($search);
        }

        $digits = preg_replace('/\D+/', '', $search);

        if (str_starts_with($digits, '60')) {
            return '0'.substr($digits, 2);
        }

        return $digits ?: $search;
    }
}
