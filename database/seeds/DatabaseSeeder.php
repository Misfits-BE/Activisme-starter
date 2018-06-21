<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder 
 * ----- 
 * Start point for running database seeds that populate the database
 * with dummy data in testing/development environments. 
 * In this file we only ask for clearing the database and perform the other seeds
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>     
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Ask for db migration refresh, default is no 
        if ($this->command->confirm('database.ask-refresh')) {
            // Call the php artisan migrate:refresh command
            $this->command->call('migrate:refresh');
            $this->command->warn(__('database.cleared-database'));
        }

        // Execute other database seeds 
        $this->call(UsersTableSeeder::class); //! Covers also roles and permissions database table.
    }
}
