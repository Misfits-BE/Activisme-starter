<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use Illuminate\Http\Response;
Use Spatie\Permission\Models\Role;

/**
 * Class CreateViewTest 
 * ----- 
 * PHPUnit testcase for the create view from the user management console.
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     Tests\Feature\Users
 */
class CreateViewTest extends TestCase
{
    use RefreshDatabase, CreatesUsers;

    /**
     * @test
     * @testdox test if a unauthenticated user can't access the user create page. 
     */
    public function unauthenticated(): void 
    {
        $this->get(route('admin.users.create'))
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @testdox Test if a user with incorrect ACL role can't access the error page. 
     */
    public function incorrectRole(): void 
    {
        $this->actingAs($this->createUser('user'))
            ->get(route('admin.users.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN); // Code: 403
    }

    /**
     * @test
     * @testdox Test if a user with correct ACL role can access the page without errors
     */
    public function success(): void 
    {
        factory(Role::class)->create(['name' => 'user']);

        $this->actingAs($this->createUser('admin'))
            ->get(route('admin.users.create'))
            ->assertStatus(Response::HTTP_OK); // Code: 402
    }
}
