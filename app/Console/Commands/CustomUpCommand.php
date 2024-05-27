<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CustomUpCommand extends Command
{
    protected $signature = 'custom:up';
    protected $description = 'Bring the application back up from maintenance mode';

    public function handle()
    {
        $password = $this->secret('Enter the live mode password:');
        if ($password !== env('LIVE_PASSWORD')) {
            $this->error('Invalid password.');
            return 1;
        }

        Artisan::call('up');
        $this->info('The application is now live.');
        return 0;
    }
}
