<?php

use ActivismeBe\Models\Fragments;
use Illuminate\Database\Seeder;

/**
 * Class FragmentsTableSeeder 
 * ----- 
 * Database seed for the page fragments in the application 
 * 
 * @author      Tim Joosten <topairy@gmail.com> 
 * @copyright   Tim Joosten <MIT License>
 */
class FragmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Fragments::create([
            'slug' => 'privacy-policy', 
            'page' => 'Privacy Policy', 
            'title' => 'Privacy Policy', 
            'content' => file_get_contents(resource_path('policies/privacy.' . config('app.locale') . '.txt'))
        ]);

        Fragments::create([
            'slug' => 'terms-of-service', 
            'page' => 'Terms Of Service', 
            'title' => 'Terms Of Service', 
            'content' => file_get_contents(resource_path('policies/terms-of-service.' . config('app.locale') . '.txt')),
        ]);
    }
}
