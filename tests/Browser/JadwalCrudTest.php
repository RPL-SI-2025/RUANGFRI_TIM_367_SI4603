<?php


namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Ruangan;
use App\Models\Jadwal;

class JadwalCrudTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        
        $this->artisan('migrate:fresh');
    }

    /**
     * Test complete CRUD operations for Jadwal (Schedule)
     */
    public function testJadwalCrudOperations()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->maximize();
            
            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000);

            
            $browser->visit('/admin/ruangan')
                    ->waitForText('Katalog Ruangan', 10)
                    ->pause(2000)
                    
                    ->waitUntil('document.getElementById("pageLoader") && document.getElementById("pageLoader").style.opacity == "0"', 10)
                    ->pause(1500)
                    ->waitFor('a.btn.btn-success', 10)
                    ->click('a.btn.btn-success')
                    ->waitForText('Tambah Ruangan', 10)
                    ->pause(1500);

            
            $browser->type('input[name="nama_ruangan"]', 'Ruang Test 101')
                    ->type('input[name="kapasitas"]', '50')
                    ->type('textarea[name="fasilitas"]', 'Proyektor, AC, Whiteboard')
                    ->type('input[name="lokasi"]', 'Gedung A Lantai 1')
                    ->select('select[name="status"]', 'Tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/ruangan', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101');

            
            $browser->visit('/admin/jadwal')
                    ->waitForText('Manajemen Jadwal', 10)
                    ->pause(2000);

            
            $browser->waitFor('a[href*="jadwal/create"]', 10)
                    ->click('a[href*="jadwal/create"]')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000);

            
            $browser->waitFor('#single-tab', 10)
                    ->waitFor('#single-content.active', 10)
                    ->pause(1000)
                    
                    ->assertVisible('#single-content.active')
                    ->assertSee('Buat Jadwal Tunggal')
                    ->select('select[name="id_ruangan"]', '1') 
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101');

            
            $browser->waitFor('a[href*="jadwal/create"]', 10)
                    ->click('a[href*="jadwal/create"]')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000)
                    
                    ->click('#bulk-tab')
                    ->waitFor('#bulk-content.active', 10)
                    ->pause(1000)
                    ->assertSee('Generate Jadwal Bulk');

            
            $browser->select('select[id="id_ruangan_bulk"]', '1')
                    ->pause(500)
                    ->select('select[name="jeda_waktu"]', '1') 
                        ->pause(500)
                        ->assertSee('Hari Operasional')
                    
                    ->check('#hari_1') 
                    ->check('#hari_2') 
                    ->check('#hari_3') 
                    ->check('#hari_4') 
                    ->check('#hari_5') 
                    ->pause(500);

            
            $browser->assertSee('Generate Jadwal')
                    ->waitFor('#bulk-content button[type="submit"]', 10)
                    ->click('#bulk-content button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101');            $browser->waitFor('a[href*="jadwal/create"]', 10)
                    ->click('a[href*="jadwal/create"]')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000)
                    
                    ->click('#bulk-tab')
                    ->waitFor('#bulk-content.active', 10)
                    ->pause(1000)
                    ->assertSee('Generate Jadwal Bulk');

            
            $browser->select('select[id="id_ruangan_bulk"]', '1')
                    ->pause(500)
                    ->assertSee('Hari Operasional')
                    ->assertSee('Jeda Waktu')
                    ->select('select[name="jeda_waktu_bulk"]', '1') 
                    
                    ->check('#hari_1') 
                    ->check('#hari_2') 
                    ->check('#hari_3') 
                    ->check('#hari_4') 
                    ->check('#hari_5') 
                    ->pause(500);

            
            $browser->assertSee('Generate Jadwal')
                    ->waitFor('#bulk-content button[type="submit"]', 10)
                    ->click('#bulk-content button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101');

            
            $browser->pause(2000)
                    ->waitFor('a[href*="jadwal/show"]', 10)
                    ->click('a[href*="jadwal/show"]:first-child')
                    ->waitForText('Detail Jadwal:', 10)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101')
                    ->assertSee('Gedung A Lantai 1');

            
            $browser->scrollIntoView('table')
                    ->pause(1000)
                    ->waitFor('a[href*="jadwal"][href*="edit"]', 10)
                    ->click('a[href*="jadwal"][href*="edit"]:first-child')
                    ->waitForText('Edit Jadwal', 10)
                    ->pause(1000);

            
            $browser->clear('input[name="jam_mulai"]')
                    ->type('input[name="jam_mulai"]', '07:00') 
                    ->clear('input[name="jam_selesai"]')
                    ->type('input[name="jam_selesai"]', '09:00') 
                    ->select('select[name="status"]', 'tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101');

            
            $browser->visit('/admin/jadwal')
                    ->waitForText('Filter Jadwal', 10)
                    ->pause(1000)
                    ->select('select[name="ruangan"]', '1')
                    ->select('select[name="status"]', 'tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    ->assertSee('Ruang Test 101');

            
            $browser->click('a.btn-secondary')
                    ->pause(2000)
                    ->assertPathIs('/admin/jadwal');

            
            $browser->scrollIntoView('table')
                    ->pause(1000);

            
            $browser->whenAvailable('form[action*="jadwal"][method="POST"]:first-child button[type="submit"]', function ($button) {
                $button->click();
            })
            ->pause(1000)
            ->acceptDialog() 
            ->pause(2000)
            ->assertSee('Ruang Test 101');

            
            $browser->visit('/admin/jadwal')
                    ->waitForText('Manajemen Jadwal', 10)
                    ->pause(1000)
                    ->assertSee('Ruang Test 101');
        });
    }

    /**
     * Test schedule validation errors
     */
    public function testJadwalValidationErrors()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();
            
            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000);

            
            $browser->visit('/admin/ruangan')
                    ->waitForText('Katalog Ruangan', 10)
                    ->pause(2000)
                    ->waitUntil('document.getElementById("pageLoader") && document.getElementById("pageLoader").style.opacity == "0"', 10)
                    ->pause(1500)
                    ->waitFor('a.btn.btn-success', 10)
                    ->click('a.btn.btn-success')
                    ->waitForText('Tambah Ruangan', 10)
                    ->pause(1500)
                    ->type('input[name="nama_ruangan"]', 'Ruang Validation Test')
                    ->type('input[name="kapasitas"]', '30')
                    ->type('textarea[name="fasilitas"]', 'Basic facilities')
                    ->type('input[name="lokasi"]', 'Test Location')
                    ->select('select[name="status"]', 'Tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/ruangan', 15)
                    ->pause(1000);

            
            $browser->visit('/admin/jadwal/create')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000);

            
            $browser->waitFor('#single-content.active', 10)
                    ->pause(1000);

            
            $browser->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    ->assertPathIs('/admin/jadwal/create');

            
            $browser->select('select[name="id_ruangan"]', '1')
                    ->type('input[name="tanggal"]', date('Y-m-d', strtotime('+1 day')))
                    ->type('input[name="jam_mulai"]', '10:00') 
                    ->type('input[name="jam_selesai"]', '08:00') 
                    ->select('select[name="jeda_waktu"]', '1')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    ->assertPathIs('/admin/jadwal/create');

            
            $browser
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    ->assertPathIs('/admin/jadwal/create');
        });
    }

    /**
     * Test schedule bulk generation
     */
    public function testJadwalBulkGeneration()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();
            
            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000);

            
            $browser->visit('/admin/ruangan')
                    ->waitForText('Katalog Ruangan', 10)
                    ->pause(2000)
                    ->waitUntil('document.getElementById("pageLoader") && document.getElementById("pageLoader").style.opacity == "0"', 10)
                    ->pause(1500)
                    ->waitFor('a.btn.btn-success', 10)
                    ->click('a.btn.btn-success')
                    ->waitForText('Tambah Ruangan', 10)
                    ->pause(1500)
                    ->type('input[name="nama_ruangan"]', 'Ruang Bulk Test')
                    ->type('input[name="kapasitas"]', '40')
                    ->type('textarea[name="fasilitas"]', 'Bulk test facilities')
                    ->type('input[name="lokasi"]', 'Bulk Test Location')
                    ->select('select[name="status"]', 'Tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/ruangan', 15)
                    ->pause(1000);

            
            $browser->visit('/admin/jadwal/create')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000)
                    ->click('#bulk-tab')
                    ->waitFor('#bulk-content.active', 10)
                    ->pause(1000)
                    ->assertSee('Generate Jadwal Bulk');

            
            $browser->select('select[id="id_ruangan_bulk"]', '1') 
                    ->pause(500);

            
            

            $browser->scrollIntoView('Hari Operasional')
                        ->pause(500)
                     ->select('select[name="jeda_waktu_bulk"]', '1') 
                    ->uncheck('#hari_1') 
                    ->uncheck('#hari_2') 
                    ->uncheck('#hari_3') 
                    ->uncheck('#hari_4') 
                    ->uncheck('#hari_5') 
                    
                    ->check('#hari_0') 
                    ->check('#hari_6') 
                    ->pause(500)
                    ->scrollIntoView('#bulk-content button[type="submit"]')
                    ->pause(500)
                     ->assertSee('Generate Jadwal')
                        ->click('button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Bulk Test');

            
            $browser->pause(2000)
                    ->assertSee('Ruang Bulk Test');
        });
    }

    /**
     * Test schedule filtering and search functionality
     */
    public function testJadwalFilteringAndSearch()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();
            
            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000);

            
            $browser->visit('/admin/ruangan')
                    ->waitForText('Katalog Ruangan', 10)
                    ->pause(2000)
                    ->waitUntil('document.getElementById("pageLoader") && document.getElementById("pageLoader").style.opacity == "0"', 10)
                    ->pause(1500)
                    ->waitFor('a.btn.btn-success', 10)
                    ->click('a.btn.btn-success')
                    ->waitForText('Tambah Ruangan', 10)
                    ->pause(1500)
                    ->type('input[name="nama_ruangan"]', 'Meeting Room A')
                    ->type('input[name="kapasitas"]', '20')
                    ->type('textarea[name="fasilitas"]', 'Meeting facilities')
                    ->type('input[name="lokasi"]', 'Building A')
                    ->select('select[name="status"]', 'Tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/ruangan', 15)
                    ->pause(1000);

            
            $browser->waitFor('a.btn.btn-success', 10)
                    ->click('a.btn.btn-success')
                    ->waitForText('Tambah Ruangan', 10)
                    ->pause(1500)
                    ->type('input[name="nama_ruangan"]', 'Conference Room B')
                    ->type('input[name="kapasitas"]', '50')
                    ->type('textarea[name="fasilitas"]', 'Conference facilities')
                    ->type('input[name="lokasi"]', 'Building B')
                    ->select('select[name="status"]', 'Tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/ruangan', 15)
                    ->pause(1000);

            
            $browser->visit('/admin/jadwal/create')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000)
                    ->waitFor('#single-content.active', 10)
                    ->pause(1000)
                    ->select('select[name="id_ruangan"]', '1')
                    ->select('select[name="jeda_waktu"]', '2')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000);

            $browser->waitFor('a[href*="jadwal/create"]', 10)
                    ->click('a[href*="jadwal/create"]')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000)
                    ->waitFor('#single-content.active', 10)
                    ->pause(1000)
                    ->select('select[name="id_ruangan"]', '2')
                    ->select('select[name="jeda_waktu"]', '2')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000);

            
            $browser->visit('/admin/jadwal')
                    ->waitForText('Filter Jadwal', 10)
                    ->pause(1000)
                    ->select('select[name="ruangan"]', '1')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    ->assertSee('Meeting Room A');

            
            $browser->select('select[name="ruangan"]', '')
                    ->select('select[name="status"]', 'tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000);

            
            $browser->click('a.btn-secondary')
                    ->pause(2000)
                    ->assertPathIs('/admin/jadwal');
        });
    }
}