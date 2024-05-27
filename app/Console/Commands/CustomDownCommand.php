<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CustomDownCommand extends Command
{
    protected $signature = 'custom:down';
    protected $description = 'Put the application into maintenance mode';

    public function handle()
    {
        $password = $this->secret('Enter the maintenance mode password:');
        if ($password !== env('MAINTENANCE_PASSWORD')) {
            $this->error('Invalid password.');
            return 1;
        }

        Artisan::call('down');
        $this->info('The application is now in maintenance mode.');
        return 0;
    }
}
