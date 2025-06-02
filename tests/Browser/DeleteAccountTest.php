<?php


namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;

class DeleteAccountTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        
        $this->artisan('migrate:fresh');
    }
    
    /**
     * Test successful account deletion
     */
    public function testSuccessfulAccountDeletion()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->maximize();
            
            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000)
                    
                    
                    ->type('#nim', '12345678')
                    ->type('#nama_mahasiswa', 'John Doe')
                    ->type('#register-email', 'john.doe@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'Password123!')
                    
                    
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->click('a[onclick*="logout-form"]')
                    ->waitForLocation('/mahasiswa/login', 10);

            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->pause(500)
                    
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->visit('/mahasiswa/profile/edit')
                    ->waitForText('Hapus Akun', 10)
                    ->pause(1000);

            
            $browser->scrollIntoView('#toggleDeleteSection')
                    ->pause(500)
                    ->click('#toggleDeleteSection')
                    ->waitFor('#deleteAccountSection', 5)
                    ->pause(1000);

            
            $browser->scrollIntoView('#delete-password')
                    ->pause(500)
                    ->type('#delete-password', 'Password123!')
                    ->pause(500)
                    
                    ->scrollIntoView('#delete-account-form button[type="submit"]')
                    ->pause(500)
                    ->click('#delete-account-form button[type="submit"]')
                    ->pause(2000)
                    ->waitForLocation('/', 15);


            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(3000)
                    ->assertPathIs('/mahasiswa/login')
                    ->assertSee('The provided credentials do not match our records.');
        
                
        });
    }

    /**
     * Test account deletion with wrong password
     */
    public function testAccountDeletionWithWrongPassword()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->maximize();
            
            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000)
                    
                    ->type('#nim', '12345678')
                    ->type('#nama_mahasiswa', 'John Doe')
                    ->type('#register-email', 'john.doe@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'Password123!')
                    
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->click('a[onclick*="logout-form"]')
                    ->waitForLocation('/mahasiswa/login', 10);

            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->pause(500)
                    
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->visit('/mahasiswa/profile/edit')
                    ->waitForText('Hapus Akun', 10)
                    ->pause(1000);

            
            $browser->scrollIntoView('#toggleDeleteSection')
                    ->pause(500)
                    ->click('#toggleDeleteSection')
                    ->waitFor('#deleteAccountSection', 5)
                    ->pause(1000);

            
            $browser->scrollIntoView('#delete-password')
                    ->pause(500)
                    ->type('#delete-password', 'WrongPassword!')
                    ->pause(500)
                    
                    ->scrollIntoView('#delete-account-form button[type="submit"]')
                    ->pause(500)
                    ->click('#delete-account-form button[type="submit"]')
                    ->pause(2000)
                    ->assertSee('Password yang Anda masukkan tidak valid.');
        });
    }

    /**
     * Test cancel account deletion
     */
    public function testCancelAccountDeletion()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->maximize();
            
            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000)
                    
                    ->type('#nim', '12345678')
                    ->type('#nama_mahasiswa', 'John Doe')
                    ->type('#register-email', 'john.doe@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'Password123!')
                    
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->click('a[onclick*="logout-form"]')
                    ->waitForLocation('/mahasiswa/login', 10);

            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->pause(500)
                    
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->visit('/mahasiswa/profile/edit')
                    ->waitForText('Hapus Akun', 10)
                    ->pause(1000);

            
            $browser->scrollIntoView('#toggleDeleteSection')
                    ->pause(500)
                    ->click('#toggleDeleteSection')
                    ->waitFor('#deleteAccountSection', 5)
                    ->pause(1000);

            
            $browser->scrollIntoView('#cancelDelete')
                    ->pause(500)
                    ->click('#cancelDelete')
                    ->pause(1000)
                    ->assertDontSee('#deleteAccountSection')
                    ->assertSee('Hapus Akun');

            
            $browser->click('a[onclick*="logout-form"]')
                    ->waitForLocation('/mahasiswa/login', 10)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');
        });
    }

    /**
     * Test account deletion form validation (empty password)
     */
    public function testAccountDeletionWithEmptyPassword()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->maximize();
            
            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000)
                    
                    ->type('#nim', '12345678')
                    ->type('#nama_mahasiswa', 'John Doe')
                    ->type('#register-email', 'john.doe@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'Password123!')
                    
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->click('a[onclick*="logout-form"]')
                    ->waitForLocation('/mahasiswa/login', 10);

            
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'Password123!')
                    ->pause(500)
                    
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20)
                    ->assertSee('Selamat datang');

            
            $browser->visit('/mahasiswa/profile/edit')
                    ->waitForText('Hapus Akun', 10)
                    ->pause(1000);

            
            $browser->scrollIntoView('#toggleDeleteSection')
                    ->pause(500)
                    ->click('#toggleDeleteSection')
                    ->waitFor('#deleteAccountSection', 5)
                    ->pause(1000);

            
            $browser->scrollIntoView('#delete-account-form button[type="submit"]')
                    ->pause(500)
                    ->click('#delete-account-form button[type="submit"]')
                    ->pause(1000)
                    ->assertPathIs('/mahasiswa/profile/edit'); 
        });
    }
}