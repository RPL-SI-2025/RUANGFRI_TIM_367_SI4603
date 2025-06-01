<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\Traits\PersistentDataTrait;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, PersistentDataTrait;

    /**
     * Prepare for Dusk test execution.
     */
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
        
        // Setup testing database
        static::setupTestingDatabase();
    }

    /**
     * Setup testing database with persistent data
     */
    protected static function setupTestingDatabase(): void
    {
        try {
            // Switch ke database testing
            config(['database.default' => 'mysql_testing']);
            
            // Test koneksi database
            DB::connection()->getPdo();
            
            // Cek apakah tabel sudah ada
            $tables = DB::select("SHOW TABLES LIKE 'migrations'");
            
            if (empty($tables)) {
                // Database kosong, jalankan migration dan seeder
                Artisan::call('migrate:fresh', [
                    '--seed' => true,
                    '--force' => true
                ]);
                
                echo "Database testing berhasil di-setup dengan data awal.\n";
            } else {
                echo "Database testing sudah ada, menggunakan data yang tersimpan.\n";
            }
            
        } catch (\Exception $e) {
            echo "Error setting up testing database: " . $e->getMessage() . "\n";
            
            // Coba buat database jika belum ada
            try {
                $connection = config('database.connections.mysql');
                $pdo = new \PDO(
                    "mysql:host={$connection['host']};port={$connection['port']}",
                    $connection['username'],
                    $connection['password']
                );
                
                $pdo->exec("CREATE DATABASE IF NOT EXISTS ruangfri_testing");
                
                // Switch ke database testing
                config(['database.default' => 'mysql_testing']);
                
                // Jalankan migration dan seeder
                Artisan::call('migrate:fresh', [
                    '--seed' => true,
                    '--force' => true
                ]);
                
                echo "Database testing berhasil dibuat dan di-setup.\n";
                
            } catch (\Exception $e2) {
                echo "Error creating testing database: " . $e2->getMessage() . "\n";
                throw $e2;
            }
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup data testing yang konsisten
        $this->setupTestData();
        
        // Cleanup session lama
        $this->cleanupSessionData();
    }

    protected function tearDown(): void
    {
        // Reset hanya data transaksi, bukan data master
        $this->resetTransactionData();
        
        parent::tearDown();
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     */
    protected function hasHeadlessDisabled(): bool
    {
        return isset($_ENV['DUSK_HEADLESS_DISABLED']) ||
               isset($_SERVER['DUSK_HEADLESS_DISABLED']);
    }

    /**
     * Determine if the browser should start maximized.
     */
    protected function shouldStartMaximized(): bool
    {
        return isset($_ENV['DUSK_START_MAXIMIZED']) ||
               isset($_SERVER['DUSK_START_MAXIMIZED']);
    }
}