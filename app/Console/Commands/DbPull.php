<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbPull extends Command
{
    use DbSyncHelper; // ← this line must be here

    protected $signature = 'db:pull';
    protected $description = 'Pull production database → local';

    public function handle(): int
    {
        $this->warn('⬇️  Pulling production DB to local (merge mode)...');

        try {
            $this->info('📦 Dumping production database...');
            $file = $this->dumpDatabase('production', 'merge');
            $this->info("✅ Dumped to: {$file}");

            $this->info('📥 Merging into local database...');
            $this->importDatabase('mysql', $file);

            @unlink($file);
            $this->info('🎉 Done! Production merged into local.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
