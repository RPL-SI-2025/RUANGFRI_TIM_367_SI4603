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
     * Setup testing database with persistent data.
     */
    protected static function setupTestingDatabase(): void
    {
        try {
            // Switch to testing database
            config(['database.default' => 'mysql_testing']);

            // Test database connection
            DB::connection()->getPdo();

            // Check if the migrations table exists
            $tables = DB::select("SHOW TABLES LIKE 'migrations'");

            if (empty($tables)) {
                // Database is empty, run migrations and seeders
                Artisan::call('migrate:fresh', [
                    '--seed' => true,
                    '--force' => true
                ]);

                echo "Testing database successfully set up with initial data.\n";
            } else {
                echo "Testing database already exists, using stored data.\n";
            }

        } catch (\Exception $e) {
            echo "Error setting up testing database: " . $e->getMessage() . "\n";

            // Attempt to create the database if it doesn't exist
            try {
                $connection = config('database.connections.mysql');
                $pdo = new \PDO(
                    "mysql:host={$connection['host']};port={$connection['port']}",
                    $connection['username'],
                    $connection['password']
                );

                $pdo->exec("CREATE DATABASE IF NOT EXISTS ruangfri_testing");

                // Switch to testing database
                config(['database.default' => 'mysql_testing']);

                // Run migrations and seeders
                Artisan::call('migrate:fresh', [
                    '--seed' => true,
                    '--force' => true
                ]);

                echo "Testing database created and set up successfully.\n";

            } catch (\Exception $e2) {
                echo "Error creating testing database: " . $e2->getMessage() . "\n";
                throw $e2;
            }
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Setup consistent test data
        $this->setupTestData();

        // Cleanup old session data
        $this->cleanupSessionData();
    }

    protected function tearDown(): void
    {
        // Reset only transaction data, not master data
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
