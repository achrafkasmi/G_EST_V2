<?php

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

Artisan::command('add_apogee', function () {

    Schema::table('t_etudiant', function (Blueprint $table) {
        $table->dropColumn('apogee');
    });
    
        if (!Schema::hasColumn('t_etudiant', 'apogee')) {

            Schema::table('t_etudiant', function (Blueprint $table) {

                $table->string('apogee')->nullable()->unique;
            });

        }

        $this->info('Added successfully.');

});