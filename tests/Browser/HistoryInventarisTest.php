<?php

namespace Tests\Browser;

use App\Models\Mahasiswa;
use App\Models\AdminLogistik;
use App\Models\Inventaris;
use App\Models\PinjamInventaris;
use App\Models\laporinventaris;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class HistoryInventarisTest extends DuskTestCase
{
    #[Test]
    public function testMahasiswaCanSeeInventarisHistory()
    {
        // Setup data
        $admin = AdminLogistik::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123')
        ]);
        $mahasiswa = Mahasiswa::factory()->create([
            'email' => 'mahasiswa@test.com',
            'password' => Hash::make('mahasiswa123')
        ]);
        $inventaris = Inventaris::factory()->create([
            'nama_inventaris' => 'Laptop Dusk',
            'id_logistik' => $admin->id
        ]);
        $pinjam = PinjamInventaris::factory()->create([
            'id_mahasiswa' => $mahasiswa->id,
            'id_inventaris' => $inventaris->id,
            'status' => 3 // Selesai
        ]);
        $laporan = laporinventaris::factory()->create([
            'id_logistik' => $admin->id,
            'id_mahasiswa' => $mahasiswa->id,
            'id_pinjam_inventaris' => $pinjam->id,
            'deskripsi' => 'Laptop baik',
            'datetime' => now()
        ]);

        $this->browse(function (Browser $browser) use ($mahasiswa, $laporan) {
            // Login mahasiswa
            $browser->visit('/mahasiswa/login')
                ->type('email', $mahasiswa->email)
                ->type('password', 'mahasiswa123')
                ->press('Login')
                ->waitForLocation('/mahasiswa/dashboard', 10);

            // Kunjungi halaman history inventaris
            $browser->visit('/mahasiswa/history/history_inventaris')
                ->assertSee('Riwayat Laporan Inventaris')
                ->assertSee($laporan->deskripsi);

            // Klik detail laporan
            $browser->click('@btn-detail-0')
                ->waitForLocation('/mahasiswa/history/history_inventaris/inventaris/'.$laporan->id_lapor_inventaris, 10)
                ->assertSee('Detail Laporan Inventaris')
                ->assertSee($laporan->deskripsi);
        });
    }
}