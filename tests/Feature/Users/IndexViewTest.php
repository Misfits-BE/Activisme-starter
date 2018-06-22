<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\CreatesUsers;
use Spatie\Permission\Models\Role;

/**
 * Class IndexViewTest
 * ----
 * PHPUnit testcase for testing the index view for the user management. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     Tests\Feature\Users
 */
class IndexViewTest extends TestCase
{
    use RefreshDatabase, CreatesUsers;

    /**
     * @test
     * @testdox Test if a unauthenticated user can't visit the users management index
     */
    public function unauthenticated(): void
    {
        $this->get(route('admin.users.index'))
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @testdox Test if a user with incorrect role can't access the user management index.
     */
    public function incorrectRole(): void 
    {
        $this->actingAs($this->createUser('user'))
            ->get(route('admin.users.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN); // Code: 403
    }

    /**
     * @test 
     * @testdox Test if a user with correct ACl role can access the page without any errors 
     */
    public function success(): void 
    {
        factory(Role::class)->create(['name' => 'user']); 

        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.users.index'))
            ->assertStatus(Response::HTTP_OK);
    }
}
