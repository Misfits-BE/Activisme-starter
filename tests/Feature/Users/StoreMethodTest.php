<?php

namespace Tests\Feature\Users;

use Tests\{TestCase, CreatesUsers};
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use ActivismeBe\User;
use ActivismeBe\Notifications\UserRegistered;
use Spatie\Permission\Models\Role;

/**
 * Class StoreMethodTest 
 * ---- 
 * PHPUnit testsuite for testing the handlings that test the user creation in the application. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     Tests\Feature\Users
 */
class StoreMethodTest extends TestCase
{
    use RefreshDatabase, CreatesUsers, WithFaker;

    /**
     * @test
     * @testdox Test the error response when an unauthenticated user tries to create a new user. 
     */
    public function unauthenticated(): void 
    {
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName, 'email' => $this->faker->email];

        $this->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @testdox Test the error response when a user with incorrect ACL tries to create a login.
     */
    public function incorrectRole(): void
    {
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName, 'email' => $this->faker->email];
        $user  = $this->createUser('user');

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FORBIDDEN); // Code: 403
    }

    /**
     * @test
     * @testdox Test that a user with admin role can create a new user in the application.
     */
    public function success(): void 
    {
        Notification::fake();
        factory(Role::class)->create(['name' => 'user']);

        $user  = $this->createUser('admin'); 
        $input = ['firstname' => $this->faker->firstname, 'lastname' => $this->faker->lastName, 'email' => $this->faker->email];
        
        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertRedirect(route('admin.users.index'));

        // TODO: Implement session data check
        dd(session()->all()); //! DEBUGGING PROPOSES

        Notification::assertSentTo([User::where('email', $input['email'])->first()], UserRegistered::class);
    }

    public function validationFirstnameRequired(): void 
    {

    }

    public function validationFirstnameString(): void 
    {

    }

    public function validationFirstnameMax255(): void 
    {

    }

    public function validationLastnameRequired(): void 
    {

    }

    public function validationLastnameString(): void 
    {

    }

    public function validationLastnameMax255(): void 
    {

    }

    public function validationEmailRequired(): void 
    {

    }

    public function validationEmailString(): void 
    {

    }

    public function validationEmailMax255(): void 
    {

    }

    public function validationEmailIsEmail(): void 
    {

    }

    public function validationEmailUnique(): void 
    {

    }
}
