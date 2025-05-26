<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ruangan;
use App\Models\Jadwal;

class SyncRoomStatus extends Command
{
    protected $signature = 'room:sync-status';
    protected $description = 'Synchronize room availability status with jadwal bookings';

    public function handle()
    {
        $rooms = Ruangan::all();
        $count = 0;
        
        foreach ($rooms as $room) {
            $totalJadwals = Jadwal::where('id_ruangan', $room->id)->count();
            $bookedJadwals = Jadwal::where('id_ruangan', $room->id)
                ->whereIn('status', ['booked', 'proses'])
                ->count();
            
            $newStatus = ($totalJadwals > 0 && $totalJadwals == $bookedJadwals) 
                ? 'Tidak Tersedia' 
                : 'Tersedia';
                
            if ($room->status != $newStatus) {
                $room->status = $newStatus;
                $room->save();
                $count++;
            }
        }
        
        $this->info("Room status synchronized. Updated $count rooms.");
    }
}