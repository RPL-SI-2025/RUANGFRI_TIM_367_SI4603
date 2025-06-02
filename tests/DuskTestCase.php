<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
<<<<<<< HEAD
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
=======
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
        
   
        static::setupTestingDatabase();
    }

    /**
     * Setup testing database with persistent data
     */
    protected static function setupTestingDatabase(): void
    {
        try {
   
            config(['database.default' => 'mysql_testing']);
            
   
            DB::connection()->getPdo();
            
   
            $tables = DB::select("SHOW TABLES LIKE 'migrations'");
            
            if (empty($tables)) {
   
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
            
   
            try {
                $connection = config('database.connections.mysql');
                $pdo = new \PDO(
                    "mysql:host={$connection['host']};port={$connection['port']}",
                    $connection['username'],
                    $connection['password']
                );
                
                $pdo->exec("CREATE DATABASE IF NOT EXISTS ruangfri_testing");
                
   
                config(['database.default' => 'mysql_testing']);
                
   
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
        
   
        $this->setupTestData();
        
   
        $this->cleanupSessionData();
    }

    protected function tearDown(): void
    {
   
        $this->resetTransactionData();
        
        parent::tearDown();
>>>>>>> be3ea6703e56698f8d541c4164b429821f305820
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
<<<<<<< HEAD
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
=======
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
>>>>>>> be3ea6703e56698f8d541c4164b429821f305820
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        return RemoteWebDriver::create(
<<<<<<< HEAD
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
=======
            $_ENV['DUSK_DRIVER_URL'] ?? 'http:   
>>>>>>> be3ea6703e56698f8d541c4164b429821f305820
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
<<<<<<< HEAD
}
=======

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
>>>>>>> be3ea6703e56698f8d541c4164b429821f305820
