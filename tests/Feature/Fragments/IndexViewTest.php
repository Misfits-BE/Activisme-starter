<?php

namespace Tests\Feature\Fragments;

use Tests\{TestCase, CreatesUsers};
use Illuminate\Foundation\Testing\{WithFaker, RefreshDatabase};
use Illuminate\Http\Response;
use ActivismeBe\Models\Fragments;

/**
 * Class IndexViewTest
 * ---- 
 * PHPUnit testsuite for the index management console in the page fragments section. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT License>
 * @package     Tests\Feature\Fragments
 */
class IndexViewTest extends TestCase
{
    use RefreshDatabase, CreatesUsers;

    /**
     * @test
     * @testdox Test the error response when an unauthenticated tries to access the route
     */
    public function unauthenticated(): void 
    {   
        $this->get(route('admin.fragments.index'))
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @testdox Test the error response when an user with incorrect role tries to access the route
     */
    public function incorrectRole(): void 
    {
        $this->actingAs($this->createUser('user'))
            ->get(route('admin.fragments.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN); // Code: 403
    }

    /**
     * @test
     * @testdox Test that a user with correct role (ACL) can view the page without errors.
     */
    public function correctRole(): void 
    {
        factory(Fragments::class)->create();
        $user = $this->createUser('admin'); 

        $this->actingAs($user)
            ->get(route('admin.fragments.index'))
            ->assertStatus(Response::HTTP_OK); // Code: 200
    }
}
