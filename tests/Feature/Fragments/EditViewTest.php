<?php

namespace Tests\Feature\Fragments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use ActivismeBe\Models\Fragments;
use Illuminate\Http\Response;

/**
 * Class EditViewTest 
 * ---- 
 * PHPUnit testsuite for the edit view from the page fragments section. 
 * 
 * @author
 * @copyright
 * @package
 */
class EditViewTest extends TestCase
{
    use CreatesUsers, RefreshDatabase;

    /**
     * @test
     * @testdox Test if a unauthenticated user can't access the page fragments edit view.
     */
    public function unauthenticated(): void 
    {
        $fragment = factory(Fragments::class)->create();

        $this->get(route('admin.fragments.edit', ['slug' => $fragment->slug]))
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @testdox Test if a user with correct permissions can view the page without problems.
     */
    public function correctRole(): void 
    {
        $fragment = factory(Fragments::class)->create();
        $user = $this->createUser('admin');

        $this->actingAs($user)
            ->get(route('admin.fragments.edit', ['slug' => $fragment->slug]))
            ->assertStatus(Response::HTTP_OK); // Code: 200
    }

    /**
     * @test
     * @testdox Test that a user with incorrect permissions can't view the page.
     */
    public function incorrectRole(): void 
    {
        $this->actingAs($this->createUser('user'))
            ->get(route('admin.fragments.edit', ['slug' => factory(Fragments::class)->create()->slug]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @testdox Test the error response when the slug is not found in the database.
     */
    public function slugNotFound(): void 
    {
        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.fragments.edit', ['slug' => 'article-slug']))
            ->assertStatus(Response::HTTP_NOT_FOUND); // Code: 404
    }
}
