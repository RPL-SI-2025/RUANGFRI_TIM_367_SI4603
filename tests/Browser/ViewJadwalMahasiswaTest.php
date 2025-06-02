<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewJadwalMahasiswaTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test mahasiswa dapat melihat jadwal ketersediaan ruangan di katalog
     */
    public function testMahasiswaCanViewJadwalKetersediaan()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();

            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000)
                    ->type('#nim', '87654321')
                    ->type('#nama_mahasiswa', 'Jane Smith')
                    ->type('#register-email', 'jane.smith@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'Password123!')
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
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

            
            $browser->type('input[name="nama_ruangan"]', 'Ruang Meeting 101')
                    ->type('input[name="kapasitas"]', '30')
                    ->type('textarea[name="fasilitas"]', 'Proyektor, AC, Whiteboard, Sound System')
                    ->type('input[name="lokasi"]', 'Gedung A Lantai 2')
                    ->select('select[name="status"]', 'Tersedia')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/ruangan', 15)
                    ->pause(1000)
                    ->assertSee('Ruang Meeting 101');

            
            $browser->visit('/admin/jadwal')
                    ->waitForText('Manajemen Jadwal', 10)
                    ->pause(2000)
                    ->waitFor('a[href*="jadwal/create"]', 10)
                    ->click('a[href*="jadwal/create"]')
                    ->waitForText('Tambah Jadwal', 10)
                    ->pause(2000);

            
            $browser->waitFor('#single-content.active', 10)
                    ->pause(1000)
                    ->select('select[name="id_ruangan"]', '1')
                    ->select('select[name="jeda_waktu"]', '2')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/admin/jadwal', 15)
                    ->pause(1000);

            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'jane.smith@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->visit('/mahasiswa/katalog/ruangan')
                    ->waitForText('Katalog Ruangan', 10)
                    ->pause(2000)
                    ->assertSee('Ruang Meeting 101');

            
            $browser->waitFor('a[href*="/mahasiswa/katalog/ruangan/1"]', 10)
                    ->click('a[href*="/mahasiswa/katalog/ruangan/1"]')
                    ->waitForText('Detail Ruangan', 10)
                    ->pause(2000)
                    ->assertSee('Ruang Meeting 101')
                    ->assertSee('Jadwal Ketersediaan');

          
        });
    }
}
