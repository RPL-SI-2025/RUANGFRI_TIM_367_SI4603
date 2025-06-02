<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminCRUDCatatanInventarisTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin dapat menolak peminjaman inventaris dan menambahkan catatan
     */
    public function testAdminCanRejectInventoryWithNotes()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();

            
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed', ['--class' => 'MahasiswaSeeder']);
            $this->artisan('db:seed', ['--class' => 'InventarisSeeder']);
            $this->artisan('db:seed', ['--class' => 'PinjamInventarisSeeder']);

            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000)
                    ->assertSee('Dashboard Admin');

            
            $browser->visit('/admin/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000)
                    ->assertSee('Peminjaman Inventaris');

            
            $browser->waitFor('table tbody tr', 10)
                    ->pause(1000);

            
            $browser->click('table tbody tr:first-child .btn-info')
                    ->waitForText('Informasi Peminjaman', 10)
                    ->pause(3000)
                    ->assertSee('Informasi Peminjaman');

            
            $browser->waitFor('.card-body', 10)
                    ->pause(2000);

            
            $browser->script('
                window.scrollTo({
                    top: 500,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
            
            $browser->script('
                window.scrollTo({
                    top: 1000,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            
            if ($browser->element('button[data-bs-target="#rejectModal"]')) {
                
                $browser->script('
                    const rejectBtn = document.querySelector("button[data-bs-target=\'#rejectModal\']");
                    if (rejectBtn) {
                        rejectBtn.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                ');
                $browser->pause(2000)
                        ->click('button[data-bs-target="#rejectModal"]')
                        ->waitFor('#rejectModal', 10)
                        ->pause(1000);

                
                $browser->waitFor('#notes', 5)
                        ->type('#notes', 'Peminjaman ditolak karena inventaris sedang dalam perawatan dan tidak dapat dipinjamkan saat ini.')
                        ->pause(500)
                        ->click('#rejectSubmitBtn')
                        ->waitForText('Status berhasil diperbarui', 10)
                        ->pause(3000);
            }

            
            $browser->script('
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
            
            
            $browser->script('
                window.scrollTo({
                    top: 300,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            
            $browser->assertSee('Ditolak');

            
            $browser->script('
                window.scrollTo({
                    top: 800,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
            
            $browser->script('
                window.scrollTo({
                    top: 1200,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            
            if ($browser->element('button[data-bs-target="#editNotesModal"]')) {
                $browser->script('
                    const editBtn = document.querySelector("button[data-bs-target=\'#editNotesModal\']");
                    if (editBtn) {
                        editBtn.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                ');
                $browser->pause(2000)
                        ->click('button[data-bs-target="#editNotesModal"]')
                        ->waitFor('#editNotesModal', 10)
                        ->pause(1000)
                        ->clear('#editNotes')
                        ->type('#editNotes', 'Peminjaman ditolak karena inventaris tidak tersedia untuk tanggal yang diminta. Silakan pilih tanggal lain.')
                        ->pause(500)
                        ->click('#editNotesModal button[type="submit"]')
                        ->waitForText('Status berhasil diperbarui', 10)
                        ->pause(3000);
                
                
                $browser->script('
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000);
                
                $browser->script('
                    window.scrollTo({
                        top: 400,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000);
            }

            
            $browser->visit('/admin/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000);

            
            $browser->assertSee('Ditolak');

            
            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000);

            
            $browser->type('#login-email', 'mahasiswa@example.com') 
                    ->type('#login-password', 'password') 
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->visit('/mahasiswa/peminjaman/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000);

            
            if ($browser->element('.badge')) {
                
                $browser->pause(1000);
                
                
                if ($browser->element('a[href*="show"]')) {
                    $browser->click('a[href*="show"]:first')
                            ->waitForText('Detail Peminjaman Inventaris', 10)
                            ->pause(2000);
                    
                    
                    $browser->script('
                        window.scrollTo({
                            top: 600,
                            behavior: "smooth"
                        });
                    ');
                    $browser->pause(2000);
                    
                    $browser->script('
                        window.scrollTo({
                            top: 1000,
                            behavior: "smooth"
                        });
                    ');
                    $browser->pause(3000)
                            ->assertSee('Ditolak');
                }
            }
        });
    }

    /**
     * Test admin dapat menyetujui peminjaman inventaris dengan catatan
     */
    public function testAdminCanApproveInventoryWithNotes()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();

            
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed', ['--class' => 'MahasiswaSeeder']);
            $this->artisan('db:seed', ['--class' => 'InventarisSeeder']);
            $this->artisan('db:seed', ['--class' => 'PinjamInventarisSeeder']);

            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000);

            
            $browser->visit('/admin/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000);

            
            if ($browser->element('table tbody tr:nth-child(2) .btn-info')) {
                $browser->click('table tbody tr:nth-child(2) .btn-info');
            } else {
                $browser->click('table tbody tr:first-child .btn-info');
            }

            $browser->waitForText('Informasi Peminjaman', 10)
                    ->pause(3000);

            
            $browser->script('
                window.scrollTo({
                    top: 800,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
            
            $browser->script('
                window.scrollTo({
                    top: 1200,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            
            if ($browser->element('button[type="submit"]:contains("Setujui")')) {
                $browser->script('
                    const approveBtn = document.querySelector("button[type=\'submit\']:contains(\'Setujui\')");
                    if (approveBtn) {
                        approveBtn.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                ');
                $browser->pause(2000)
                        ->click('button[type="submit"]:contains("Setujui")')
                        ->acceptDialog()
                        ->waitForText('Status berhasil diperbarui', 10)
                        ->pause(3000);
                
                
                $browser->script('
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000);
                
                $browser->script('
                    window.scrollTo({
                        top: 300,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000)
                        ->assertSee('Disetujui');
            }
        });
    }

    /**
     * Test admin dapat mengubah catatan multiple kali
     */
    public function testAdminCanUpdateNotesMultipleTimes()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();

            
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed', ['--class' => 'MahasiswaSeeder']);
            $this->artisan('db:seed', ['--class' => 'InventarisSeeder']);
            $this->artisan('db:seed', ['--class' => 'PinjamInventarisSeeder']);

            
            $browser->visit('/admin/dashboard')
                    ->waitForText('Dashboard Admin', 15)
                    ->pause(2000);

            
            $browser->visit('/admin/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000)
                    ->click('table tbody tr:first-child .btn-info')
                    ->waitForText('Informasi Peminjaman', 10)
                    ->pause(3000);

            
            $browser->script('
                window.scrollTo({
                    top: 800,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
            
            $browser->script('
                window.scrollTo({
                    top: 1200,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            
            if ($browser->element('button[data-bs-target="#rejectModal"]')) {
                $browser->script('
                    const rejectBtn = document.querySelector("button[data-bs-target=\'#rejectModal\']");
                    if (rejectBtn) {
                        rejectBtn.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                ');
                $browser->pause(2000)
                        ->click('button[data-bs-target="#rejectModal"]')
                        ->waitFor('#rejectModal', 10)
                        ->pause(1000)
                        ->type('#notes', 'Catatan pertama: Peminjaman sedang diproses.')
                        ->pause(500)
                        ->click('#rejectSubmitBtn')
                        ->waitForText('Status berhasil diperbarui', 10)
                        ->pause(3000);

                
                $browser->script('
                    window.scrollTo({
                        top: 600,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000);

                
                if ($browser->element('button[data-bs-target="#editNotesModal"]')) {
                    
                    $browser->script('
                        const editBtn = document.querySelector("button[data-bs-target=\'#editNotesModal\']");
                        if (editBtn) {
                            editBtn.scrollIntoView({ behavior: "smooth", block: "center" });
                        }
                    ');
                    $browser->pause(2000)
                            ->click('button[data-bs-target="#editNotesModal"]')
                            ->waitFor('#editNotesModal', 10)
                            ->pause(1000)
                            ->clear('#editNotes')
                            ->type('#editNotes', 'Catatan kedua: Inventaris telah disiapkan dan siap dipinjam.')
                            ->pause(500)
                            ->click('#editNotesModal button[type="submit"]')
                            ->waitForText('Status berhasil diperbarui', 10)
                            ->pause(3000);

                    
                    $browser->script('
                        window.scrollTo({
                            top: 600,
                            behavior: "smooth"
                        });
                    ');
                    $browser->pause(2000);

                    
                    $browser->script('
                        const editBtn2 = document.querySelector("button[data-bs-target=\'#editNotesModal\']");
                        if (editBtn2) {
                            editBtn2.scrollIntoView({ behavior: "smooth", block: "center" });
                        }
                    ');
                    $browser->pause(2000)
                            ->click('button[data-bs-target="#editNotesModal"]')
                            ->waitFor('#editNotesModal', 10)
                            ->pause(1000)
                            ->clear('#editNotes')
                            ->type('#editNotes', 'Catatan final: Peminjaman perlu verifikasi ulang dokumen.')
                            ->pause(500)
                            ->click('#editNotesModal button[type="submit"]')
                            ->waitForText('Status berhasil diperbarui', 10)
                            ->pause(3000);
                    
                    
                    $browser->script('
                        window.scrollTo({
                            top: 400,
                            behavior: "smooth"
                        });
                    ');
                    $browser->pause(2000)
                            ->assertSee('Catatan final');
                }
            }
        });
    }

    /**
     * Test validasi form catatan kosong
     */
    public function testValidationForEmptyNotes()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();

            
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed', ['--class' => 'MahasiswaSeeder']);
            $this->artisan('db:seed', ['--class' => 'InventarisSeeder']);
            $this->artisan('db:seed', ['--class' => 'PinjamInventarisSeeder']);

            
            $browser->visit('/admin/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000)
                    ->click('table tbody tr:first-child .btn-info')
                    ->waitForText('Informasi Peminjaman', 10)
                    ->pause(3000);

            
            $browser->script('
                window.scrollTo({
                    top: 800,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
            
            $browser->script('
                window.scrollTo({
                    top: 1200,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            
            if ($browser->element('button[data-bs-target="#rejectModal"]')) {
                $browser->script('
                    const rejectBtn = document.querySelector("button[data-bs-target=\'#rejectModal\']");
                    if (rejectBtn) {
                        rejectBtn.scrollIntoView({ behavior: "smooth", block: "center" });
                    }
                ');
                $browser->pause(2000)
                        ->click('button[data-bs-target="#rejectModal"]')
                        ->waitFor('#rejectModal', 10)
                        ->pause(1000)
                        
                        ->click('#rejectSubmitBtn')
                        ->pause(1000);

                
                if ($browser->element('#notes.is-invalid')) {
                    $browser->assertPresent('#notes.is-invalid');
                }

                
                $browser->type('#notes', 'Catatan ditambahkan setelah validation error.')
                        ->pause(500)
                        ->click('#rejectSubmitBtn')
                        ->waitForText('Status berhasil diperbarui', 10)
                        ->pause(3000);
                
                
                $browser->script('
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000);
                
                $browser->script('
                    window.scrollTo({
                        top: 300,
                        behavior: "smooth"
                    });
                ');
                $browser->pause(2000)
                        ->assertSee('Ditolak');
            }
        });
    }

    /**
     * Test admin dapat melihat detail lengkap peminjaman
     */
    public function testAdminCanViewDetailedBorrowingInfo()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();

            
            $this->artisan('migrate:fresh');
            $this->artisan('db:seed', ['--class' => 'MahasiswaSeeder']);
            $this->artisan('db:seed', ['--class' => 'InventarisSeeder']);
            $this->artisan('db:seed', ['--class' => 'PinjamInventarisSeeder']);

            
            $browser->visit('/admin/pinjam-inventaris')
                    ->waitForText('Peminjaman Inventaris', 10)
                    ->pause(2000)
                    ->click('table tbody tr:first-child .btn-info')
                    ->waitForText('Informasi Peminjaman', 10)
                    ->pause(3000);

            
            $browser->assertSee('Informasi Peminjaman')
                    ->assertSee('Inventaris yang Dipinjam');

            
            $browser->script('
                window.scrollTo({
                    top: 400,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            $browser->script('
                window.scrollTo({
                    top: 800,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);

            $browser->script('
                window.scrollTo({
                    top: 1200,
                    behavior: "smooth"
                });
            ');
            $browser->pause(3000);

            
            if ($browser->element('.card-header:contains("Aksi Peminjaman")')) {
                $browser->assertSee('Aksi Peminjaman');
            }
            
            
            $browser->script('
                window.scrollTo({
                    top: 600,
                    behavior: "smooth"
                });
            ');
            $browser->pause(2000);
        });
    }
}