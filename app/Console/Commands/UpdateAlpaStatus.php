<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PresensiGenerate;

class UpdateAlpaStatus extends Command
{
    protected $signature = 'app:update-alpa-status';
    protected $description = 'Update status siswa menjadi alpa jika tidak absen masuk atau keluar';

    protected $presensiService;

    public function __construct(PresensiGenerate $presensiService)
    {
        parent::__construct();
        $this->presensiService = $presensiService;
    }

    public function handle()
    {
        $message = $this->presensiService->updateAlpaStatus();
        $this->info($message);
    }
}
