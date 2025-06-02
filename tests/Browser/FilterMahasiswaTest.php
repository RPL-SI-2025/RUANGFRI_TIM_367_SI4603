<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use App\Models\Ruangan;
use App\Models\AdminLogistik;
use Illuminate\Support\Facades\Hash;

class FilterMahasiswaTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat admin logistik dulu (kalau dibutuhkan)
        AdminLogistik::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'nama' => 'Admin Test',
                'password' => Hash::make('password123')
            ]
        );

        // Buat test user mahasiswa
        Mahasiswa::firstOrCreate(
            ['nim' => '1234567800'],
            [
                'nama_mahasiswa' => 'Test User',
                'email' => 'test.user@student.univ.ac.id',
                'password' => Hash::make('Password123!')
            ]
        );

        // Buat data ruangan
        Ruangan::create([
            'nama_ruangan' => 'Ruang Kelas A101',
            'kapasitas' => 30,
            'fasilitas' => 'AC, Proyektor, Papan Tulis',
            'lokasi' => 'Gedung A Lantai 1',
            'status' => 'Tersedia',
            'gambar' => null,
        ]);

        Ruangan::create([
            'nama_ruangan' => 'Ruang Kelas B201',
            'kapasitas' => 20,
            'fasilitas' => 'AC, Whiteboard',
            'lokasi' => 'Gedung B Lantai 2',
            'status' => 'Tidak Tersedia',
            'gambar' => null,
        ]);

        Ruangan::create([
            'nama_ruangan' => 'Lab Komputer',
            'kapasitas' => 40,
            'fasilitas' => 'AC, Komputer, Proyektor',
            'lokasi' => 'Gedung C Lantai 1',
            'status' => 'Tersedia',
            'gambar' => null,
        ]);
    }

    protected function login(Browser $browser)
    {
        $browser->visit('/mahasiswa/login')
                ->waitFor('#login-form.active', 10)
                ->pause(1000)
                ->type('#login-email', 'test.user@student.univ.ac.id')
                ->type('#login-password', 'Password123!')
                ->pause(500)
                ->scrollIntoView('button[type="submit"]')
                ->pause(500)
                ->click('button[type="submit"]')
                ->waitForLocation('/mahasiswa/dashboard', 30);
    }

    // 4 Skema Validasi Berhasil

    public function testFilterRuanganByStatus()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-status', 'Tersedia')
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Ruang Kelas A101')
                    ->assertSee('Lab Komputer')
                    ->assertDontSee('Ruang Kelas B201');
        });
    }

    public function testFilterRuanganByLocation()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-lokasi', 'Gedung A Lantai 1')
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Ruang Kelas A101')
                    ->assertDontSee('Lab Komputer')
                    ->assertDontSee('Ruang Kelas B201');
        });
    }

    public function testFilterRuanganByStatusAndLocation()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-status', 'Tersedia')
                    ->select('#filter-lokasi', 'Gedung A Lantai 1')
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Ruang Kelas A101')
                    ->assertDontSee('Lab Komputer')
                    ->assertDontSee('Ruang Kelas B201');
        });
    }

    public function testAccessRuanganCatalog()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->assertPathIs('/mahasiswa/katalog/ruangan')
                    ->assertSee('Katalog Ruangan');
        });
    }

    // 4 Skema Validasi Gagal / Edge Cases

    public function testFilterRuanganByStatusNotFound()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-status', 'Sedang Maintenance') // Status tidak ada di DB
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Data tidak ditemukan');
        });
    }

    public function testFilterRuanganByLocationNotFound()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-lokasi', 'Gedung Z Lantai 99') // Lokasi tidak ada
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Data tidak ditemukan');
        });
    }

    public function testFilterRuanganByStatusAndLocationNotFound()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-status', 'Tidak Tersedia')
                    ->select('#filter-lokasi', 'Gedung A Lantai 1') // Kombinasi yang tidak ada
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Data tidak ditemukan');
        });
    }

    public function testFilterRuanganEmptyFilter()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->pause(2000)
                    ->select('#filter-status', '') // Kosong / default
                    ->select('#filter-lokasi', '')
                    ->click('#filter-apply-button')
                    ->pause(2000)
                    ->assertSee('Menampilkan semua ruangan');
        });
    }
}