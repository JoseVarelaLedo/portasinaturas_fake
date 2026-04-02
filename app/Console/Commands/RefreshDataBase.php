<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshDataBase extends Command
{
    protected $signature = 'app:refresh';
 
    protected $description = 'Fai rollback a DB e executa os seeder/faker';
  
    public function handle()
    {
       Artisan::call('migrate:rollback');
       Artisan::call('migrate');
       Artisan::call('db:seed');
    }
}
