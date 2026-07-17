<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbPush extends Command
{
    protected $signature = 'db:push';
    protected $description = 'Push local database to production';

    public function handle()
    {
        $this->warn('⚠️  This will overwrite production!');

        if (!$this->confirm('Are you sure?')) {
            $this->info('Aborted.');

            return Command::SUCCESS;
        }

        $scriptPath = base_path('scripts/db-push.sh');
        passthru("bash $scriptPath", $code);

        return $code === 0 ? Command::SUCCESS : Command::FAILURE;
    }
}
