<?php

namespace Tests\Feature;

use App\Models\House;
use App\Models\Participant;
use App\Models\Setting;
use App\Models\Sport;
use App\Models\SportRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_participant_can_register_and_receive_a_registration_code(): void
    {
        $house = House::create(['name' => 'Rumah Hijau']);
        $sport = Sport::create(['name' => 'Balloon Rush', 'category' => 'Dewasa', 'max_players_per_group' => 12, 'is_active' => true]);

        $response = $this->post('/daftar', [
            'name' => 'Ali Budiman',
            'age' => 25,
            'phone' => '0123456789',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ]);

        $participant = Participant::first();

        $this->assertNotNull($participant);
        $this->assertStringStartsWith('SRKB-', $participant->registration_code);
        $this->assertDatabaseHas('sport_registrations', [
            'participant_id' => $participant->id,
            'sport_id' => $sport->id,
            'status' => 'Diterima',
        ]);
        $response->assertRedirect(route('public.success', $participant->registration_code));
    }

    public function test_child_registration_requires_guardian_details(): void
    {
        $house = House::create(['name' => 'Rumah Merah']);
        $sport = Sport::create(['name' => 'Pindah Cawan', 'category' => 'Kanak-Kanak', 'is_active' => true]);

        $response = $this->post('/daftar', [
            'name' => 'Amin Budiman',
            'age' => 8,
            'phone' => '0133456789',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ]);

        $response->assertSessionHasErrors(['guardian_name', 'guardian_phone', 'guardian_relationship']);
    }

    public function test_duplicate_same_normalized_phone_and_name_is_blocked(): void
    {
        $house = House::create(['name' => 'Rumah Biru']);
        $sport = Sport::create(['name' => 'Radio Rosak', 'category' => 'Terbuka', 'is_active' => true]);

        Participant::create([
            'registration_code' => 'SRKB-260602-ABCDE',
            'name' => 'Ali Budiman',
            'age' => 20,
            'phone' => '0123456789',
            'category' => 'Dewasa',
            'house_id' => $house->id,
            'status' => 'Aktif',
        ]);

        $this->post('/daftar', [
            'name' => 'Ali Budiman',
            'age' => 20,
            'phone' => '+6012-3456789',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ])->assertSessionHasErrors('name');
    }

    public function test_inactive_event_cannot_be_selected_publicly(): void
    {
        $house = House::create(['name' => 'Rumah Kuning']);
        $sport = Sport::create(['name' => 'Acara Tutup', 'category' => 'Terbuka', 'is_active' => false]);

        $this->post('/daftar', [
            'name' => 'Siti Budiman',
            'age' => 18,
            'phone' => '0143456789',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ])->assertSessionHasErrors('sport_id');
    }

    public function test_incompatible_event_category_is_rejected(): void
    {
        $house = House::create(['name' => 'Rumah Hijau']);
        $sport = Sport::create(['name' => 'Pindah Cawan', 'category' => 'Kanak-Kanak', 'is_active' => true]);

        $this->post('/daftar', [
            'name' => 'Dewasa Budiman',
            'age' => 22,
            'phone' => '0163456789',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ])->assertSessionHasErrors('sport_id');
    }

    public function test_child_age_cannot_register_for_adult_event(): void
    {
        $house = House::create(['name' => 'Rumah Hijau']);
        $sport = Sport::create(['name' => 'Balloon Rush', 'category' => 'Dewasa', 'is_active' => true]);

        $this->post('/daftar', [
            'name' => 'Kanak Budiman',
            'age' => 11,
            'phone' => '0169999999',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
            'guardian_name' => 'Penjaga Kanak',
            'guardian_phone' => '0129999999',
            'guardian_relationship' => 'Ibu',
        ])->assertSessionHasErrors('sport_id');
    }

    public function test_age_11_creates_child_category_even_if_payload_is_tampered(): void
    {
        $house = House::create(['name' => 'Rumah Biru']);
        $sport = Sport::create(['name' => 'Radio Rosak', 'category' => 'Terbuka', 'is_active' => true]);

        $this->post('/daftar', [
            'name' => 'Anak Budiman',
            'age' => 11,
            'phone' => '0153456789',
            'category' => 'Dewasa',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
            'guardian_name' => 'Ibu Budiman',
            'guardian_phone' => '0128888888',
            'guardian_relationship' => 'Ibu',
        ]);

        $this->assertDatabaseHas('participants', [
            'name' => 'Anak Budiman',
            'category' => 'Kanak-Kanak',
        ]);
    }

    public function test_age_12_creates_adult_category_and_does_not_require_guardian(): void
    {
        $house = House::create(['name' => 'Rumah Kuning']);
        $sport = Sport::create(['name' => 'Catch the Scammer', 'category' => 'Terbuka', 'is_active' => true]);

        $this->post('/daftar', [
            'name' => 'Remaja Budiman',
            'age' => 12,
            'phone' => '0193456789',
            'category' => 'Kanak-Kanak',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('participants', [
            'name' => 'Remaja Budiman',
            'category' => 'Dewasa',
            'guardian_id' => null,
        ]);
    }

    public function test_open_event_accepts_both_child_and_adult_categories(): void
    {
        $house = House::create(['name' => 'Rumah Merah']);
        $sport = Sport::create(['name' => 'Radio Rosak', 'category' => 'Terbuka', 'max_players_per_group' => 10, 'is_active' => true]);

        $this->post('/daftar', [
            'name' => 'Anak Terbuka',
            'age' => 9,
            'phone' => '0111111111',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
            'guardian_name' => 'Penjaga Terbuka',
            'guardian_phone' => '0127777777',
            'guardian_relationship' => 'Bapa',
        ])->assertSessionHasNoErrors();

        $this->post('/daftar', [
            'name' => 'Dewasa Terbuka',
            'age' => 30,
            'phone' => '0112222222',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('participants', ['name' => 'Anak Terbuka', 'category' => 'Kanak-Kanak']);
        $this->assertDatabaseHas('participants', ['name' => 'Dewasa Terbuka', 'category' => 'Dewasa']);
    }

    public function test_full_event_places_public_registration_on_waiting_list(): void
    {
        $house = House::create(['name' => 'Rumah Merah']);
        $sport = Sport::create(['name' => 'Tarik Tali Final', 'category' => 'Terbuka', 'max_players_per_group' => 1, 'is_active' => true]);
        $accepted = Participant::create([
            'registration_code' => 'SRKB-260602-FIRST',
            'name' => 'Peserta Pertama',
            'age' => 20,
            'phone' => '0173456789',
            'category' => 'Terbuka',
            'house_id' => $house->id,
            'status' => 'Aktif',
        ]);
        SportRegistration::create(['participant_id' => $accepted->id, 'sport_id' => $sport->id, 'status' => 'Diterima']);

        $this->post('/daftar', [
            'name' => 'Peserta Kedua',
            'age' => 21,
            'phone' => '0183456789',
            'house_id' => $house->id,
            'sport_id' => $sport->id,
        ]);

        $this->assertDatabaseHas('sport_registrations', [
            'sport_id' => $sport->id,
            'status' => 'Senarai Menunggu',
        ]);
    }

    public function test_registration_is_blocked_when_settings_close_it(): void
    {
        Setting::setValue('registration_is_open', '0');

        $this->get('/daftar')
            ->assertOk()
            ->assertSee('Pendaftaran Ditutup');
    }

    public function test_public_pages_do_not_show_admin_login_link(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('Admin')
            ->assertDontSee('/login');
    }
}
