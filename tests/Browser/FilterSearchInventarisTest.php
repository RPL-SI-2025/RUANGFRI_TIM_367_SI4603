<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use App\Models\Ruangan;
use App\Models\Inventaris;
use App\Models\KategoriInventaris;
use App\Models\AdminLogistik;
use App\Models\PinjamRuangan;
use App\Models\PinjamInventaris;
use Illuminate\Support\Facades\Hash;

class DashboardMahasiswaTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin logistik first (required for inventaris)
        AdminLogistik::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'nama' => 'Admin Test',
                'password' => Hash::make('password123')
            ]
        );

        // Create test user
        $mahasiswa = Mahasiswa::firstOrCreate(
            ['nim' => '1234567800'],
            [
                'nama_mahasiswa' => 'John Doe',
                'email' => 'john.doe@student.univ.ac.id',
                'password' => Hash::make('Password123!')
            ]
        );

        // Create test categories
        $elektronik = KategoriInventaris::firstOrCreate(
            ['nama_kategori' => 'Elektronik'],
            ['deskripsi' => 'Peralatan elektronik']
        );

        // Create test rooms
        Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Kelas 101'],
            [
                'kapasitas' => 30,
                'lokasi' => 'Gedung A Lantai 1',
                'status' => 'Tersedia'
            ]
        );

        // Create test inventory
        Inventaris::firstOrCreate(
            ['nama_inventaris' => 'Laptop Dell'],
            [
                'kategori_id' => $elektronik->id,
                'deskripsi' => 'Laptop untuk presentasi',
                'jumlah' => 3,
                'status' => 'Tersedia',
                'id_logistik' => 1
            ]
        );

        // Create some test borrowing data for dashboard stats
        PinjamRuangan::create([
            'id_mahasiswa' => $mahasiswa->id,
            'id_ruangan' => 1,
            'tanggal_pengajuan' => now()->format('Y-m-d'),
            'tanggal_selesai' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '10:00',
            'tujuan_peminjaman' => 'Test purpose',
            'status' => 1, // Disetujui
            'file_scan' => 'test.pdf'
        ]);

        PinjamInventaris::create([
            'id_mahasiswa' => $mahasiswa->id,
            'id_inventaris' => 1,
            'tanggal_pengajuan' => now()->format('Y-m-d'),
            'tanggal_selesai' => now()->addDay()->format('Y-m-d'),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '10:00',
            'jumlah_pinjam' => 1,
            'tujuan_peminjaman' => 'Test purpose',
            'status' => 0, // Pending
            'file_scan' => 'test.pdf'
        ]);
    }

    protected function login(Browser $browser)
    {
        $browser->visit('/mahasiswa/login')
                ->waitFor('#login-form.active', 10)
                ->pause(1000)
                ->type('#login-email', 'john.doe@student.univ.ac.id')
                ->type('#login-password', 'Password123!')
                ->pause(500)
                ->scrollIntoView('button[type="submit"]')
                ->pause(500)
                ->click('button[type="submit"]')
                ->waitForLocation('/mahasiswa/dashboard', 30);
    }

    // PASSING TESTS (4) - Berdasarkan elemen yang BENAR-BENAR ada di dashboard

    public function testDashboardPageLoads()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->assertPathIs('/mahasiswa/dashboard')
                    ->pause(2000)
                    ->assertSee('Dashboard')
                    ->assertSee('Mahasiswa')
                    ->assertSee('Selamat datang di sistem manajemen fasilitas FRI');
        });
    }

    public function testHeaderStatsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(2000)
                    ->assertPresent('.header-stats')
                    ->assertPresent('.stat-card')
                    ->assertSee('Disetujui')
                    ->assertSee('Pending')
                    ->assertSee('Ditolak');
        });
    }

    public function testStatusOverviewSection()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(2000)
                    ->assertSee('Status Peminjaman Overview')
                    ->assertPresent('.status-card-modern')
                    ->assertSee('Diterima')
                    ->assertSee('Pending');
        });
    }

    public function testCatalogSections()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(2000)
                    ->assertSee('Katalog Ruangan')
                    ->assertSee('Katalog Inventaris')
                    ->assertPresent('.catalog-card')
                    ->assertSee('Lihat Semua');
        });
    }

    // FAILING TESTS (4) - Elemen yang TIDAK ada di dashboard

    public function testQuickActionMenu()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertSee('Quick Actions Menu') // Will fail - tidak ada
                    ->assertPresent('.quick-action-panel');
        });
    }

    public function testNotificationBell()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertPresent('.notification-bell') // Will fail - tidak ada
                    ->assertSee('Notifications');
        });
    }

    public function testRecentActivitiesTimeline()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertSee('Recent Activities') // Will fail - tidak ada
                    ->assertPresent('.activity-timeline');
        });
    }

    public function testAdvancedChartsSection()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertSee('Analytics Charts') // Will fail - tidak ada
                    ->assertPresent('#analytics-chart');
        });
    }
}