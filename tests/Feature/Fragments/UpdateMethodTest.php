<?php

namespace Tests\Feature\Fragments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use ActivismeBe\Models\Fragments;
use Illuminate\Http\Response;
use ActivismeBe\Toastr\Traits\WithToastr;

/**
 * Class UpdateMethodTest 
 * ---- 
 * PHPUnit testsuite for te page fragment update method 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT License> 
 */
class UpdateMethodTest extends TestCase
{
    use CreatesUsers, WithFaker, RefreshDatabase, WithToastr;

    /**
     * @test
     * @testdox Test that u user with incorrect permissions can't update a page fragment
     */
    public function incorrectRole(): void 
    {
        $fragment = factory(Fragments::class)->create();
        $input    = ['title' => $this->faker->title, 'content' => $this->faker->paragraph];

        $this->actingAs($this->createUser('user'))
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), $input)
            ->assertStatus(Response::HTTP_FORBIDDEN); // Code: 403
    }

    /**
     * @test
     * @testdox Test the error response when no valid slug is found in the database. 
     */
    public function slugNotFound(): void 
    {
        $input = ['title' => $this->faker->title, 'content' => $this->faker->paragraph]; 

        $this->actingAs($this->createUser('admin'))
            ->patch(route('admin.fragments.update', ['slug' => 'fragment-slug']), $input)
            ->assertStatus(Response::HTTP_NOT_FOUND); // Code: 404
    }

    /**
     * @test
     * @testdox Test that an unauthenticated user can't update a page fragment. 
     */
    public function unauthenticated(): void 
    {
        $fragment = factory(Fragments::class)->create(); 
        $input    = ['title' => $this->faker->title, 'content' => $this->faker->paragraph]; 
        
        $this->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('login'));
    }

    /**
     * @test 
     * @testdox Test that a user with correct permission can update a page fragment. 
     */
    public function success(): void 
    {
        $fragment = factory(Fragments::class)->create(); 
        $input    = ['title' => $this->faker->title, 'content' => $this->faker->paragraph];
        $langKey  = 'starter-translations::fragments';
        $user     = $this->createUser('admin');

        $this->actingAs($user)
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('admin.fragments.index'));

        $this->assertHasToastr('success', __("{$langKey}.toastr.update.title"), __("{$langKey}.toastr.update.message", ['name' => $fragment->page]));

        $this->assertDatabaseMissing('fragments', ['title' => $fragment->title, 'content' => $fragment->content]); 
        $this->assertDatabaseHas('fragments', $input);
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'fragments', 'description' => __("{$langKey}.activity.update", ['user' => $user->name, 'name' => $fragment->page
        ])]);
    }

    /**
     * @test 
     * @testdox Test if the title is required in the form request.
     */
    public function validationTitleRequired(): void 
    {
        $fragment = factory(Fragments::class)->create();

        $this->actingAs($this->createUser('admin'))
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), ['content' => $this->faker->paragraph])
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['title' => __('validation.required', ['attribute' => 'title'])]);
    }

    /**
     * @test 
     * @testdox Test that the title field in the form request can only be a string data type
     */
    public function validationTitleString(): void 
    {
        $fragment = factory(Fragments::class)->create(); 
        $input    = ['title' => rand(0, 250), 'content' => $this->faker->paragraph];

        $this->actingAs($this->createUser('admin'))
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['title' => __('validation.string', ['attribute' => 'title'])]);

    }

    /**
     * @test
     * @testdox Test that the title field in the can only contain max 200 characters.
     */
    public function validationTitleMax200(): void 
    {
        $fragment = factory(Fragments::class)->create();
        $input    = ['title' => str_random(250), 'content' => $this->faker->paragraph]; 

        $this->actingAs($this->createUser('admin'))
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['title' => __('validation.max.string', [
                'max' => 200, 'attribute' => 'title',
            ])]);
    }

    /**
     * @test
     * @testdox Test if the content field is required in the form request 
     */
    public function validationContentRequired(): void 
    {
        $fragment = factory(Fragments::class)->create();

        $this->actingAs($this->createUser('admin'))
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), ['title' => $this->faker->title])
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['content' => __('validation.required', ['attribute' => 'content'])]);
    }

    /**
     * @test 
     * @testdox Test if the content field can only contain a string data type
     */
    public function validationContentString(): void 
    {
        $fragment = factory(Fragments::class)->create();
        $input = ['title' => $this->faker->paragraph, 'content' => rand(0, 250)];

        $this->actingAs($this->createUser('admin'))
            ->patch(route('admin.fragments.update', ['slug' => $fragment->slug]), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['content' => __('validation.string', ['attribute' => 'content'])]);
    }
}
