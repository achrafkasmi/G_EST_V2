<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('selectedDB', function () {
    $result = DB::table('t_grad')->get();
    print_r($result);
});

Artisan::command('createUser', function () {

   $this->info('creating user...');

   $user = new User();

   $user->email = 'achraf@gmail.com';
   $user->name = 'achraf';
   $user->apogee = 'K12345';
   $user->password = bcrypt('123456');
   $user->save();
});

