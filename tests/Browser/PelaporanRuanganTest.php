<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use App\Models\Ruangan;
use App\Models\AdminLogistik;
use Illuminate\Support\Facades\Hash;

class PelaporanRuanganTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat admin logistik (jika dibutuhkan)
        AdminLogistik::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'nama' => 'Admin Test',
                'password' => Hash::make('admin123')
            ]
        );

        // Buat test user mahasiswa
        Mahasiswa::firstOrCreate(
            ['nim' => '1202220129'],
            [
                'nama_mahasiswa' => 'Mahasiswa Test',
                'email' => 'mahasiswa@student.univ.ac.id',
                'password' => Hash::make('mahasiswa123')
            ]
        );

        // Buat data ruangan
        Ruangan::create([
            'nama_ruangan' => 'Ruang Kelas B013',
            'kapasitas' => 40,
            'fasilitas' => 'AC, Proyektor, Papan Tulis',
            'lokasi' => 'Gedung B Lantai 1',
            'status' => 'Tersedia',
            'gambar' => null,
        ]);
    }

    protected function login(Browser $browser)
    {
        $browser->visit('/mahasiswa/login')
                ->waitFor('form', 10)
                ->type('email', 'mahasiswa@student.univ.ac.id')
                ->type('password', 'mahasiswa123')
                ->press('Masuk ke Akun')
                ->waitForLocation('/mahasiswa/dashboard', 10);
    }

    // 2 TEST PASS

    public function testIndexLaporanRuanganPagePass()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/pelaporan/lapor-ruangan')
                    ->pause(1000)
                    ->assertSee('Daftar Laporan Ruangan');
        });
    }

    public function testShowLaporanRuanganPagePass()
    {
        // Buat dummy laporan ruangan di database
        $mahasiswa = Mahasiswa::where('email', 'mahasiswa@student.univ.ac.id')->first();
        $ruangan = Ruangan::first();

        $laporan = \App\Models\LaporRuangan::create([
            'id_peminjaman' => 1,
            'id_logistik' => 1,
            'id_ruangan' => $ruangan->id,
            'oleh' => $mahasiswa->nama_mahasiswa,
            'deskripsi' => 'Kondisi baik',
        ]);

        $this->browse(function (Browser $browser) use ($laporan) {
            $this->login($browser);

            $browser->visit('/mahasiswa/pelaporan/lapor-ruangan/' . $laporan->id_lapor_ruangan)
                    ->pause(1000)
                    ->assertSee('Detail Laporan Ruangan')
                    ->assertSee('Kondisi baik');
        });
    }

    // 2 TEST FAILED

    public function testCreateLaporanRuanganValidationFailed()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/pelaporan/lapor-ruangan/create')
                    ->press('Kirim Laporan')
                    ->pause(1000)
                    ->assertSee('error'); // Sesuaikan dengan pesan error validasi di aplikasi
        });
    }

    public function testCreateLaporanRuanganInvalidFileFailed()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/pelaporan/lapor-ruangan/create')
                    ->attach('foto_awal', __DIR__.'/files/test.txt') // File txt, bukan gambar
                    ->press('Kirim Laporan')
                    ->pause(1000)
                    ->assertSee('Format salah'); // Sesuaikan dengan pesan error validasi di aplikasi
        });
    }
}