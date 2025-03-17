<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CheckForUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there is a new update in the GitHub repository';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $repoOwner = 'asepsurya';  // Ganti dengan username GitHub kamu
        $repoName = 'devAbsent'; // Ganti dengan nama repositori kamu
        
        $latestCommit = $this->getLatestCommit($repoOwner, $repoName);
        $currentCommit = $this->getCurrentCommitHash();
    
        if ($latestCommit !== $currentCommit) {
            Cache::put('update_available', true, now()->addHours(1)); // Menandakan ada pembaruan
        } else {
            Cache::put('update_available', false, now()->addHours(1)); // Tidak ada pembaruan
        }
    }

    /**
     * Mendapatkan hash commit terbaru dari repositori GitHub.
     *
     * @param string $repoOwner
     * @param string $repoName
     * @return string
     */
    private function getLatestCommit($repoOwner, $repoName)
    {
        $url = "https://api.github.com/repos/{$repoOwner}/{$repoName}/commits";
        
        $response = Http::withHeaders([
            'Authorization' => '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',
        ])->get($url);
        
        if ($response->successful()) {
            $commits = $response->json();
            return $commits[0]['sha']; // Mengambil hash commit terbaru
        }

        return '';
    }

    /**
     * Mendapatkan hash commit lokal dari proyek.
     *
     * @return string
     */
    private function getCurrentCommitHash()
    {
        return trim(shell_exec('git rev-parse HEAD')); // Mengambil hash commit lokal
    }
}
