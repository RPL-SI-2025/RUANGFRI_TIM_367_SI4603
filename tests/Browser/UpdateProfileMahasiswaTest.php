<?php

namespace Tests\Web;

use Tests\TestCase;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UpdateProfileMahasiswaTest extends TestCase
{
    use RefreshDatabase;

    protected $mahasiswa;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat user mahasiswa dummy
        $this->mahasiswa = Mahasiswa::factory()->create([
            'password' => Hash::make('password123'),
        ]);
    }

    /** @test */
    public function user_must_login_before_update_profile()
    {
        $response = $this->patch(route('mahasiswa.profile.update'), []);
        $response->assertRedirect(route('login')); // pastikan diarahkan ke login jika belum login
    }

    /** @test */
    public function update_profile_successful_with_valid_data()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $validData = [
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'emailbaru@example.com',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => now()->subYears(18)->format('Y-m-d'), // minimal umur 17 tahun
            'wa' => '081234567890',
            'alamat' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s.,-]+$/'],
            'angkatan' => '2022',
            'tujuan' => 'Studi lanjut',
            'instansi' => 'Universitas ABC',
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $validData);

        $response->assertRedirect(route('mahasiswa.profile.edit'));
        $response->assertSessionHas('status', 'Profil berhasil diperbarui!');

        $this->assertDatabaseHas('mahasiswa', [
            'id' => $this->mahasiswa->id,
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'emailbaru@example.com',
        ]);
    }

    /** @test */
    public function update_profile_fails_with_empty_nim()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $data = [
            'nim' => '',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'emailbaru@example.com',
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $data);

        $response->assertSessionHasErrors('nim');
    }

    /** @test */
    public function update_profile_fails_with_invalid_email()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $data = [
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'email-tidak-valid',
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $data);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function update_profile_fails_if_tanggal_lahir_not_minimum_17_years()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $data = [
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'validemail@example.com',
            'tanggal_lahir' => now()->subYears(16)->format('Y-m-d'), // kurang dari 17 tahun
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $data);

        $response->assertSessionHasErrors('tanggal_lahir');
    }

    /** @test */
    public function update_profile_fails_if_wa_contains_non_digit_characters()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $data = [
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'validemail@example.com',
            'wa' => '08123abc456',
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $data);

        $response->assertSessionHasErrors('wa');
    }

    /** @test */
    public function update_profile_fails_if_tempat_lahir_contains_invalid_characters()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $data = [
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'validemail@example.com',
            'tempat_lahir' => 'Jakarta123',
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $data);

        $response->assertSessionHasErrors('tempat_lahir');
    }

    /** @test */
    public function update_profile_fails_if_alamat_contains_invalid_characters()
    {
        $this->actingAs($this->mahasiswa, 'mahasiswa');

        $data = [
            'nim' => '1234567890',
            'nama_mahasiswa' => 'Nama Baru',
            'email' => 'validemail@example.com',
            'alamat' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s.,-]+$/'],
        ];

        $response = $this->patch(route('mahasiswa.profile.update'), $data);

        $response->assertSessionHasErrors('alamat');
    }
}