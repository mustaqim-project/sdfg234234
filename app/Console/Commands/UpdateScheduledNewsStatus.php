<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk menggunakan logging

class UpdateScheduledNewsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:update-scheduled-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update news status based on scheduled_at time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $targetTime = $now->copy()->addHours(7);
        $specifiedDate = Carbon::create(2024, 8, 15, 0, 0, 0); // Mengatur tanggal 15 Agustus 2024

        $newsItems = News::where('scheduled_at', '>', $specifiedDate)
            ->where('scheduled_at', '<=', $targetTime)
            ->where('status', 0)
            ->get();

        foreach ($newsItems as $news) {
            $news->status = 1; // Update status ke aktif
            $news->save();
        }

        $message = 'Scheduled news statuses have been updated.';

        // Cetak pesan ke log dengan nama "SCHEDULER"
        Log::channel('scheduler')->info($message);

        // Juga cetak pesan ke konsol
        $this->info($message);
    }
}
