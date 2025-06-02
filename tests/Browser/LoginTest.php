<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
   
        $this->artisan('migrate:fresh');
    }

    /**
     * Test successful login
     */
    public function testSuccessfulLogin()
    {
        $this->browse(function (Browser $browser) {
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
        });
    }

    /**
     * Test login with invalid credentials
     */
    public function testLoginWithInvalidCredentials()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/mahasiswa/login')
                    ->waitFor('#login-form.active', 5)
                    ->pause(1000)
                    ->type('#login-email', 'john.doe@student.univ.ac.id')
                    ->type('#login-password', 'WrongPassword!')
                    ->pause(500)
                    ->scrollIntoView('button[type="submit"]')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->pause(2000) 
                    ->assertPathIs('/mahasiswa/login')
                    ->assertSee('The provided credentials do not match our records.');
        });
    }
}