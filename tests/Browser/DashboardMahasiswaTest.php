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
        Mahasiswa::firstOrCreate(
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

        // Create test rooms with fasilitas field
        Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Kelas 101'],
            [
                'kapasitas' => 30,
                'lokasi' => 'Gedung A Lantai 1',
                'status' => 'Tersedia',
                'fasilitas' => 'Proyektor, AC, Papan Tulis'
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

    // PASSING TESTS (4) - Test yang seharusnya berhasil

    public function testDashboardLoadsSuccessfully()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->assertPathIs('/mahasiswa/dashboard')
                    ->waitForText('Dashboard', 10)
                    ->assertSee('Dashboard');
        });
    }

    public function testUserCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 10)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 30)
                    ->assertPathIs('/mahasiswa/dashboard');
        });
    }

    public function testPageHasBasicStructure()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(2000)
                    ->assertPresent('body')
                    ->assertPresent('.container, .wrapper, main, #app');
        });
    }

    public function testRedirectFromRootWorks()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertPathIs('/mahasiswa/dashboard');
        });
    }

    // FAILING TESTS (4) - Test yang sengaja dibuat gagal

    public function testAccessWithoutLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/mahasiswa/dashboard')
                    ->assertPathIs('/mahasiswa/login')
                    ->assertSee('Halaman Admin Panel'); // Will fail - text doesn't exist
        });
    }

    public function testPeminjamanQuickActions()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertSee('Buat Peminjaman Cepat') // Will fail - button doesn't exist
                    ->assertSee('Shortcut Actions');
        });
    }

    public function testRecentActivitySection()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertSee('Aktivitas Terbaru') // Will fail - section doesn't exist
                    ->assertSee('Riwayat Kegiatan');
        });
    }

    public function testPersonalizedWelcomeMessage()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            
            $browser->visit('/mahasiswa/dashboard')
                    ->pause(1000)
                    ->assertSee('Selamat pagi, John Doe') // Will fail - doesn't show personalized greeting
                    ->assertSee('Halo, John Doe');
        });
    }
}