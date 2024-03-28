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

    $user->email = 'offiziellkonto@gmail.com';
    $user->name = 'Achraf KASMI';
    $user->apogee = '0000000';
    $user->password = bcrypt('achrafk');
    $user->save();
    $user->assignRole('admin');
});


Artisan::command('add_apogee', function () {

    if (!Schema::hasColumn('t_etudiant', 'apogee')) {

        Schema::table('t_etudiant', function (Blueprint $table) {

            $table->string('apogee')->nullable()->unique;
        });
    }

    $this->info('Added successfully.');
});


Artisan::command('is_recommanded', function () {

    if (!Schema::hasColumn('t_dossier_stage', 'is_recommanded')) {

        Schema::table('t_dossier_stage', function (Blueprint $table) {

            $table->boolean('is_recommanded')->default(false);
        });
    }
    $this->info('Added successfully.');
});


Artisan::command('validation_prof', function () {

    if (!Schema::hasColumn('t_dossier_stage', 'validation_prof')) {

        Schema::table('t_dossier_stage', function (Blueprint $table) {

            $table->boolean('validation_prof')->default(false);
        });
    }
    $this->info('Stage Validé.');
});
