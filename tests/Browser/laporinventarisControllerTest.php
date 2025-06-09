<?php

namespace Tests\Browser;

use App\Models\Mahasiswa;
use App\Models\AdminLogistik;
use App\Models\Inventaris;
use App\Models\PinjamInventaris;
use App\Models\laporinventaris;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class LaporInventarisFlowTest extends DuskTestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    /**
     * Test the full flow of reporting an inventory item.
     *
     * @return void
     */
    #[Test]
    public function testFullLaporInventarisFlow()
    {
        Storage::fake('public');

        // Setup: Buat admin logistik & mahasiswa
        $admin = AdminLogistik::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123')
        ]);
        $mahasiswa = Mahasiswa::factory()->create([
            'email' => 'mahasiswa@test.com',
            'password' => Hash::make('mahasiswa123')
        ]);

        // Mahasiswa login
        $this->browse(function (Browser $browser) use ($mahasiswa, $admin) {
            // Login mahasiswa
            $browser->visit('/mahasiswa/login')
                ->type('email', $mahasiswa->email)
                ->type('password', 'mahasiswa123')
                ->press('Login')
                ->waitForLocation('/mahasiswa/dashboard', 10);

            // Katalog inventaris
            $browser->visit('/mahasiswa/inventaris')
                ->assertSee('Katalog Inventaris');

            // Tambah katalog inventaris (asumsi ada tombol tambah)
            $browser->click('@btn-tambah-inventaris')
                ->waitForLocation('/mahasiswa/inventaris/create', 10)
                ->type('nama_inventaris', 'Laptop Dusk')
                ->type('spesifikasi', 'i5, 8GB RAM')
                ->select('id_logistik', $admin->id)
                ->press('Simpan')
                ->waitForText('Inventaris berhasil ditambahkan', 10);

            // Proses peminjaman
            $browser->visit('/mahasiswa/inventaris')
                ->click('@btn-pinjam-0')
                ->waitForLocation('/mahasiswa/peminjaman/pinjam-inventaris/create', 10)
                ->type('tanggal_pengajuan', now()->format('Y-m-d'))
                ->type('tanggal_selesai', now()->addDays(2)->format('Y-m-d'))
                ->type('waktu_mulai', '09:00')
                ->type('waktu_selesai', '17:00')
                ->attach('file_scan', __DIR__.'/files/scan.jpg')
                ->press('Ajukan')
                ->waitForText('Peminjaman berhasil diajukan', 10);

            // Simulasikan approval admin (langsung update status di DB)
            $pinjam = PinjamInventaris::latest()->first();
            $pinjam->status = 1; // Disetujui
            $pinjam->save();

            // Daftar peminjaman & klik lapor
            $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                ->waitForText('Daftar Peminjaman', 10)
                ->click('@btn-lapor-0')
                ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/create', 10)
                ->attach('foto_awal', __DIR__.'/files/awal.jpg')
                ->attach('foto_akhir', __DIR__.'/files/akhir.jpg')
                ->type('deskripsi', 'Laptop baik')
                ->select('id_logistik', $admin->id)
                ->press('Kirim Laporan')
                ->waitForText('Laporan berhasil dikirim', 10);

            // Lihat detail laporan
            $browser->visit('/mahasiswa/pelaporan/lapor-inventaris')
                ->waitForText('Riwayat Laporan Inventaris', 10)
                ->click('@btn-detail-0')
                ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/1', 10)
                ->assertSee('Detail Laporan Inventaris');

            // Download PDF
            $browser->click('@btn-download-pdf')
                ->pause(2000); // Tunggu download

            // Edit laporan
            $browser->visit('/mahasiswa/pelaporan/lapor-inventaris')
                ->click('@btn-edit-0')
                ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/1/edit', 10)
                ->type('deskripsi', 'Laptop sudah diperbaiki')
                ->press('Submit')
                ->waitForText('Laporan berhasil diperbarui', 10);

            // Cek histori laporan
            $browser->visit('/mahasiswa/pelaporan/lapor-inventaris/history')
                ->assertSee('Laptop sudah diperbaiki');
        });
    }
}