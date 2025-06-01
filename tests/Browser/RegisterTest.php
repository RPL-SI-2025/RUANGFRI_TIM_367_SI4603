<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Mahasiswa;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup database for testing
        $this->artisan('migrate:fresh');
    }

    /**
     * Test successful registration
     */
    public function testSuccessfulRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000) // Give time for animations
                    
                    // Fill form data
                    ->type('#nim', '12345678')
                    ->type('#nama_mahasiswa', 'John Doe')
                    ->type('#register-email', 'john.doe@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'Password123!')
                    
                    // Scroll to terms checkbox and check it
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]')
                    ->waitForLocation('/mahasiswa/dashboard', 20) // Increased timeout
                    ->assertSee('Selamat datang');
        });
    }

    /**
     * Test registration with mismatched passwords
     */
    public function testRegistrationWithMismatchedPasswords()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/mahasiswa/login')
                    ->waitFor('[data-tab="register"]', 10)
                    ->click('[data-tab="register"]')
                    ->waitFor('#register-form.active', 5)
                    ->pause(1000)
                    
                    ->type('#nim', '12345678')
                    ->type('#nama_mahasiswa', 'John Doe')
                    ->type('#register-email', 'john.doe@student.univ.ac.id')
                    ->type('#register-password', 'Password123!')
                    ->type('#password_confirmation', 'DifferentPassword!')
                    ->pause(1500) // Wait for password match validation
                    
                    // Check for password mismatch indicator
                    ->assertSeeIn('.password-match', 'tidak cocok')
                    ->scrollIntoView('#terms')
                    ->pause(500)
                    ->check('#terms')
                    ->pause(500)
                    ->click('button[type="submit"]');
        });
    }
}