<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use App\Models\Ruangan;
use Carbon\Carbon;

class PinjamRuanganTest extends DuskTestCase
{
    /**
     * Test mahasiswa dapat melihat halaman peminjaman ruangan
     */
    public function test_mahasiswa_can_view_room_booking_page()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai mahasiswa
            $mahasiswa = Mahasiswa::factory()->create();
            $browser->visit('/mahasiswa/login')
                   ->type('email', $mahasiswa->email)
                   ->type('password', 'password')
                   ->press('Login')
                   ->assertPathIs('/mahasiswa/dashboard');

            // Kunjungi halaman peminjaman ruangan
            $browser->visit('/mahasiswa/pinjam-ruangan')
                   ->assertSee('Peminjaman Ruangan')
                   ->assertVisible('@pinjam-ruangan-form');
        });
    }

    /**
     * Test mahasiswa dapat melakukan peminjaman ruangan
     */
    public function test_mahasiswa_can_book_room()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai mahasiswa
            $mahasiswa = Mahasiswa::factory()->create();
            $ruangan = Ruangan::factory()->create([
                'status' => 'tersedia'
            ]);

            $browser->visit('/mahasiswa/login')
                   ->type('email', $mahasiswa->email)
                   ->type('password', 'password')
                   ->press('Login')
                   ->assertPathIs('/mahasiswa/dashboard');

            // Buat peminjaman ruangan
            $tanggal = Carbon::now()->addDays(2)->format('Y-m-d');
            $browser->visit('/mahasiswa/pinjam-ruangan/create')
                   ->select('ruangan_id', $ruangan->id)
                   ->type('tanggal', $tanggal)
                   ->type('jam_mulai', '09:00')
                   ->type('jam_selesai', '11:00')
                   ->type('keterangan', 'Untuk rapat kelompok')
                   ->press('Submit')
                   ->assertPathIs('/mahasiswa/pinjam-ruangan')
                   ->assertSee('Peminjaman berhasil dibuat');
        });
    }

    /**
     * Test validasi form peminjaman ruangan
     */
    public function test_room_booking_validation()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai mahasiswa
            $mahasiswa = Mahasiswa::factory()->create();
            $browser->visit('/mahasiswa/login')
                   ->type('email', $mahasiswa->email)
                   ->type('password', 'password')
                   ->press('Login')
                   ->assertPathIs('/mahasiswa/dashboard');

            // Coba submit form kosong
            $browser->visit('/mahasiswa/pinjam-ruangan/create')
                   ->press('Submit')
                   ->assertSee('The ruangan id field is required')
                   ->assertSee('The tanggal field is required')
                   ->assertSee('The jam mulai field is required')
                   ->assertSee('The jam selesai field is required');
        });
    }

    /**
     * Test mahasiswa dapat melihat detail peminjaman
     */
    public function test_mahasiswa_can_view_booking_details()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai mahasiswa
            $mahasiswa = Mahasiswa::factory()->create();
            $ruangan = Ruangan::factory()->create();

            // Buat peminjaman
            $peminjaman = $mahasiswa->pinjamRuangan()->create([
                'ruangan_id' => $ruangan->id,
                'tanggal' => Carbon::now()->addDays(2),
                'jam_mulai' => '09:00',
                'jam_selesai' => '11:00',
                'keterangan' => 'Untuk rapat kelompok',
                'status' => 'pending'
            ]);

            $browser->visit('/mahasiswa/login')
                   ->type('email', $mahasiswa->email)
                   ->type('password', 'password')
                   ->press('Login')
                   ->assertPathIs('/mahasiswa/dashboard');

            // Lihat detail peminjaman
            $browser->visit('/mahasiswa/pinjam-ruangan/' . $peminjaman->id)
                   ->assertSee($ruangan->nama)
                   ->assertSee($peminjaman->tanggal)
                   ->assertSee($peminjaman->jam_mulai)
                   ->assertSee($peminjaman->jam_selesai)
                   ->assertSee($peminjaman->keterangan);
        });
    }
}
