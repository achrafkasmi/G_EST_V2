<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class CustomDownCommand extends Command
{
    protected $signature = 'custom:down';
    protected $description = 'Put the application into maintenance mode';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Generate the password based on the current date and time
        $currentPassword = Carbon::now()->format('YmdHi');
        $password = $this->secret('Enter the maintenance mode password:');

        if ($password === $currentPassword) {
            Artisan::call('down');
            $this->info('Application is now in maintenance mode.');
        } else {
            $this->error('Invalid password.');
        }
    }
}
