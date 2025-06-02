<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use App\Models\AdminLogistik;
use App\Models\Inventaris;
use App\Models\laporinventaris;
use App\Models\PinjamInventaris;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LaporInventarisControllerTest extends DuskTestCase
{
    use DatabaseMigrations;


    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Setup data
        $logistik = AdminLogistik::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password123')
        ]);

        $mahasiswa = Mahasiswa::factory()->create([
            'nim' => '1234567800',
            'nama_mahasiswa' => 'John Doe',
            'email' => 'john.doe@student.univ.ac.id',
            'password' => Hash::make('Password123!')
        ]);

        $kategori = laporinventaris::factory()->create([
            'nama_kategori' => 'Elektronik'
        ]);

        $inventaris = Inventaris::factory()->create([
            'nama_inventaris' => 'Laptop Dell',
            'kategori_id' => $kategori->id,
            'status' => 'Tersedia',
            'id_logistik' => $logistik->id
        ]);

        PinjamInventaris::factory()->create([
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
            'id_inventaris' => $inventaris->id,
            'status' => 1
        ]);
    }

        protected function login(Browser $browser)
        {
            $browser->visit('/mahasiswa/login')
                ->waitFor('#login-form.active', 10)
                ->type('#login-email', 'john.doe@student.univ.ac.id')
                ->type('#login-password', 'Password123!')
                ->click('button[type="submit"]')
                ->waitForLocation('/mahasiswa/dashboard', 10);
        }

        /** @test */
        public function testMahasiswaCanLaporInventaris()
        {
            $this->browse(function (Browser $browser) {
                $this->login($browser);

                $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Daftar Peminjaman', 10)
                    ->click('@btn-lapor-0')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/create', 10)
                    ->attach('foto_awal', __DIR__.'/files/awal.jpg')
                    ->attach('foto_akhir', __DIR__.'/files/akhir.jpg')
                    ->type('deskripsi', 'Barang baik')
                    ->press('Submit')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris', 10)
                    ->assertSee('Laporan Inventaris Berhasil Dibuat');
            });
        }

        /** @test */
        public function testMahasiswaCannotLaporTanpaLogin()
        {
            $this->browse(function (Browser $browser) {
                $browser->visit('/mahasiswa/pelaporan/lapor-inventaris/create?id_peminjaman=1')
                    ->assertSee('Silakan login terlebih dahulu.');
            });
        }

        /** @test */
        public function testMahasiswaCannotLaporTanpaFoto()
        {
            $this->browse(function (Browser $browser) {
                $this->login($browser);

                $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Daftar Peminjaman', 10)
                    ->click('@btn-lapor-0')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/create', 10)
                    ->type('deskripsi', 'Barang baik')
                    ->press('Submit')
                    ->waitForText('The foto awal field is required', 10)
                    ->assertSee('The foto awal field is required');
            });
        }

        /** @test */
        public function testMahasiswaCanViewLaporanHistory()
        {
            $this->browse(function (Browser $browser) {
                $this->login($browser);

                $browser->visit('/mahasiswa/pelaporan/lapor-inventaris')
                    ->assertSee('Riwayat Laporan Inventaris');
            });
        }

        /** @test */
        public function testMahasiswaCanEditLaporan()
        {
            $this->browse(function (Browser $browser) {
                $this->login($browser);

                // Buat laporan terlebih dahulu
                $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Daftar Peminjaman', 10)
                    ->click('@btn-lapor-0')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/create', 10)
                    ->attach('foto_awal', __DIR__.'/files/awal.jpg')
                    ->attach('foto_akhir', __DIR__.'/files/akhir.jpg')
                    ->type('deskripsi', 'Barang baik')
                    ->press('Submit')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris', 10);

                // Edit laporan
                $browser->visit('/mahasiswa/pelaporan/lapor-inventaris')
                    ->click('@btn-edit-0')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/1/edit', 10)
                    ->type('deskripsi', 'Barang sudah diperbaiki')
                    ->press('Submit')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris', 10)
                    ->assertSee('Laporan berhasil diperbarui.');
            });
        }

        /** @test */
        public function testMahasiswaCanDownloadLaporanPDF()
        {
            $this->browse(function (Browser $browser) {
                $this->login($browser);

                // Buat laporan terlebih dahulu
                $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Daftar Peminjaman', 10)
                    ->click('@btn-lapor-0')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/create', 10)
                    ->attach('foto_awal', __DIR__.'/files/awal.jpg')
                    ->attach('foto_akhir', __DIR__.'/files/akhir.jpg')
                    ->type('deskripsi', 'Barang baik')
                    ->press('Submit')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris', 10);

                // Download PDF
                // (Add your PDF download test steps here)
            });
        }

        /** @test */
        public function testMahasiswaCanLaporInventarisSetelahPeminjaman()
        {
            $this->browse(function (Browser $browser) {
                $this->login($browser);

                // Mahasiswa melakukan peminjaman inventaris
                $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Daftar Peminjaman', 10)
                    ->assertSee('Laptop Dell')
                    ->assertSee('Disetujui')
                    // Klik tombol lapor pada baris pertama
                    ->click('@btn-lapor-0')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris/create', 10)
                    // Isi form laporan inventaris
                    ->attach('foto_awal', __DIR__.'/files/awal.jpg')
                    ->attach('foto_akhir', __DIR__.'/files/akhir.jpg')
                    ->type('deskripsi', 'Inventaris selesai digunakan dengan baik')
                    // Pilih logistik jika ada select
                    ->when($browser->element('select[name="id_logistik"]'), function ($browser) {
                        $browser->select('id_logistik', 1);
                    })
                    // Isi tanggal laporan jika ada
                    ->when($browser->element('input[name="datetime"]'), function ($browser) {
                        $browser->type('datetime', now()->format('Y-m-d H:i'));
                    })
                    ->press('Submit')
                    ->waitForLocation('/mahasiswa/pelaporan/lapor-inventaris', 10)
                    ->assertSee('Laporan berhasil dikirim')
                    // Pastikan status peminjaman berubah menjadi selesai
                    ->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Daftar Peminjaman', 10)
                        ->assertSee('Selesai');
                });
            }
        }
