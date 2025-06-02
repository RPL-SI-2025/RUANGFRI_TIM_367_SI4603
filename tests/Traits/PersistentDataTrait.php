<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait PersistentDataTrait
{
    /**
     * Reset hanya data yang diperlukan, bukan seluruh database
     */
    protected function resetSpecificData(array $tables = []): void
    {
        if (empty($tables)) {
            $tables = [
                'pinjam_ruangan',
                'pinjam_inventaris', 
                'lapor_inventaris',
                'pelaporans',
                'jadwals'
            ];
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Backup data penting sebelum test
     */
    protected function backupImportantData(): array
    {
        return [
            'mahasiswa' => DB::table('mahasiswa')->get()->toArray(),
            'admin_logistik' => DB::table('admin_logistik')->get()->toArray(),
            'ruangan' => DB::table('ruangan')->get()->toArray(),
            'inventaris' => DB::table('inventaris')->get()->toArray(),
        ];
    }

    /**
     * Restore data jika diperlukan
     */
    protected function restoreData(array $backup): void
    {
        foreach ($backup as $table => $data) {
            if (!empty($data)) {
                DB::table($table)->insert($data);
            }
        }
    }

    /**
     * Clean up session data dari testing sebelumnya
     */
    protected function cleanupSessionData(): void
    {
        $sessionPath = storage_path('framework/sessions');
        
        if (is_dir($sessionPath)) {
            $files = glob($sessionPath . '/*');
            foreach ($files as $file) {
                if (is_file($file) && time() - filemtime($file) > 3600) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Setup data awal untuk testing yang konsisten
     */
    protected function setupTestData(): void
    {
   
        if (DB::table('admin_logistik')->count() == 0) {
            DB::table('admin_logistik')->insert([
                'nama' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => bcrypt('password123'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

   
        if (DB::table('mahasiswa')->count() == 0) {
            DB::table('mahasiswa')->insert([
                'nim' => '12345678',
                'nama_mahasiswa' => 'Test Mahasiswa',
                'email' => 'mahasiswa@test.com',
                'password' => bcrypt('password123'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reset hanya data transaksi, pertahankan data master
     */
    protected function resetTransactionData(): void
    {
        $transactionTables = [
            'pinjam_ruangan',
            'pinjam_inventaris',
            'lapor_inventaris',
            'pelaporans',
            'jadwals'
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        foreach ($transactionTables as $table) {
            DB::table($table)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

   
        DB::table('ruangan')->update(['status' => 'Tersedia']);
        DB::table('inventaris')->update(['status' => 'Tersedia']);
    }
}