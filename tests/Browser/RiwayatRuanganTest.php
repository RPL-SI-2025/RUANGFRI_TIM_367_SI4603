<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Hash;

class RiwayatRuanganTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user mahasiswa
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

    public function testIndexRiwayatRuanganPagePass()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/history/ruangan')
                ->pause(1000)
                ->assertSee('Riwayat Peminjaman Ruangan');
        });
    }

    public function testShowRiwayatRuanganPagePass()
    {
        $mahasiswa = Mahasiswa::where('email', 'mahasiswa@student.univ.ac.id')->first();
        $ruangan = Ruangan::first();

        // Simulasi data riwayat (buat sesuai kebutuhan aplikasi)
        $peminjaman = \App\Models\PinjamRuangan::create([
            'id_ruangan' => $ruangan->id,
            'id_mahasiswa' => $mahasiswa->id,
            'tanggal_pengajuan' => now(),
            'tanggal_selesai' => now(),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '10:00',
            'status' => 3,
        ]);

        $laporan = \App\Models\Pelaporan::create([
            'id_logistik' => 1,
            'id_mahasiswa' => $mahasiswa->id,
            'id_ruangan' => $ruangan->id,
            'id_pinjam_ruangan' => $peminjaman->id,
            'datetime' => now(),
            'foto_awal' => null,
            'foto_akhir' => null,
            'deskripsi' => 'Ruangan baik',
            'oleh' => $mahasiswa->nama_mahasiswa,
            'kepada' => 'Admin Logistik'
        ]);

        $this->browse(function (Browser $browser) use ($laporan) {
            $this->login($browser);

            $browser->visit('/mahasiswa/history/ruangan/ruangan/' . $laporan->id_lapor_ruangan)
                ->pause(1000)
                ->assertSee('Deskripsi Pelaporan')
                ->assertSee('Ruangan baik');
        });
    }

    public function testIndexRiwayatRuanganPageFailed()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/history/ruangan/invalid-url')
                ->pause(1000)
                ->assertSee('Tipe laporan tidak valid');
        });
    }

    public function testShowRiwayatRuanganPageFailed()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);

            $browser->visit('/mahasiswa/history/ruangan/ruangan/99999')
                ->pause(1000)
                ->assertSee('Laporan tidak ditemukan');
        });
    }
}