<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdate implements ShouldBroadcast // WAJIB: ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jadwalId;
    public $nomorSekarang;

    public function __construct($jadwalId, $nomorSekarang)
    {
        $this->jadwalId = $jadwalId;
        $this->nomorSekarang = $nomorSekarang;
    }

    public function broadcastOn(): array
    {
        // Kita pakai Public Channel agar semua pasien bisa akses
        return [
            new Channel('antrian-poliklinik'),
        ];
    }

    public function broadcastAs()
    {
        return 'antrian-update';
    }
}