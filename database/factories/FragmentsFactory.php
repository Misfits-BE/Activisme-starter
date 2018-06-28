<?php

use Faker\Generator as Faker;
use ActivismeBe\Models\Fragments;

$factory->define(Fragments::class, function (Faker $faker): array {
    return [
        'slug' => $faker->slug, 
        'page' => $faker->word, 
        'title' => $faker->title, 
        'content' => $faker->paragraph,  
    ];
});
