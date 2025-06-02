<?php

namespace Tests\Browser;

use App\Models\Ruangan;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FilterMahasiswaTest extends DuskTestCase
{
    /**
     * Setup data mahasiswa untuk login.
     */
    protected function setupUser()
    {
        Mahasiswa::updateOrCreate(
            ['nim' => '1234567800'],
            [
                'nama_mahasiswa' => 'John Doe',
                'email' => 'john.doe@student.univ.ac.id',
                'password' => Hash::make('Password123!')
            ]
        );
    }

    /**
     * Login mahasiswa via Dusk.
     */
    protected function login(Browser $browser)
    {
        $browser->visit('/mahasiswa/login')
                ->waitFor('#login-form.active', 5)
                ->type('#login-email', 'john.doe@student.univ.ac.id')
                ->type('#login-password', 'Password123!')
                ->press('Login') // pastikan tombol login tertulis "Login"
                ->waitForLocation('/mahasiswa/dashboard', 10);
    }

    public function testFilterByStatusAndLocation()
    {
        // Setup data user dan ruangan
        $this->setupUser();

        // Buat data ruangan dummy
        Ruangan::create([
            'nama_ruangan' => 'Ruang A',
            'kapasitas' => 30,
            'fasilitas' => 'AC, Proyektor',
            'lokasi' => 'Gedung B (Cacuk)',
            'status' => 'Tersedia',
            'gambar' => null,
        ]);

        Ruangan::create([
            'nama_ruangan' => 'Ruang B',
            'kapasitas' => 20,
            'fasilitas' => 'AC',
            'lokasi' => 'Telkom University Landmark Tower (TULT)',
            'status' => 'Tidak Tersedia',
            'gambar' => null,
        ]);

        $this->browse(function (Browser $browser) {
            // Login dulu
            $this->login($browser);

            // Buka halaman katalog ruangan
            $browser->visit(route('mahasiswa.katalog.ruangan.index'))
                ->assertSee('Katalog Ruangan') // pastikan halaman tampil
                ->select('lokasi', 'Gedung B (Cacuk)') // pilih filter lokasi
                ->select('status', 'Tersedia')        // pilih filter status
                ->press('Filter')                     // klik tombol filter
                ->pause(1000)                        // tunggu hasil filter muncul
                ->assertSee('Ruang A')               // Ruang A harus muncul
                ->assertDontSee('Ruang B');          // Ruang B tidak muncul
        });
    }
}
