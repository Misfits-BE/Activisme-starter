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
use ActivismeBe\Toastr\Traits\WithToastr;

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
    use RefreshDatabase, CreatesUsers, WithFaker, WithToastr;

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

        $this->assertHasToastr('success', __('starter-translations::users.toastr.store.message'), __('starter-translations::users.toastr.store.title'));
        $this->assertDatabaseHas('users', ['name' => "{$input['firstname']} {$input['lastname']}", 'email' => $input['email']]);

        Notification::assertSentTo([User::where('email', $input['email'])->first()], UserRegistered::class);
    }

    /**
     * @test
     * @testdox Test if the firstname field is required in the form 
     */
    public function validationFirstnameRequired(): void 
    {
        $input = ['lastname' => $this->faker->lastname, 'email' => $this->faker->email]; 
        $user  = $this->createUser('admin');

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['firstname' => __('validation.required', ['attribute' => 'firstname'])]);
    }

    /**
     * @test
     * @testdox Test if the firstname field can only be an string data type
     */
    public function validationFirstnameString(): void 
    {
        $input = ['firstname' => rand(0, 25), 'lastname' => $this->faker->lastName, 'email' => $this->faker->email];
        $user = $this->createUser('admin');

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['firstname' => __('validation.string', ['attribute' => 'firstname'])]);
    }

    /**
     * @test
     * @testdox Test if the firstname field can only be max 255 characters
     */
    public function validationFirstnameMax255(): void 
    {
        $input = ['firstname' => str_random(275), 'lastname' => $this->faker->lastname, 'email' => $this->faker->email]; 
        $user = $this->createUser('admin'); 

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['firstname' => __('validation.max.string', [
                'attribute' => 'firstname', 'max' => 255
            ])]);
    }

    /**
     * @test
     * @testdox Test if the lastname field is required
     */
    public function validationLastnameRequired(): void 
    {
        $input = ['firstname' => $this->faker->firstName, 'email' => $this->faker->email];
        $user = $this->createUser('admin'); 

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['lastname' => __('validation.required', ['attribute' => 'lastname'])]);
    }

    /**
     * @test 
     * @testdox Test if the lastname field only can be an string field
     */
    public function validationLastnameString(): void 
    {
        $input = ['firstname' => $this->faker->firstname, 'lastname' => rand(0, 250), 'email' => $this->faker->email];
        $user = $this->createUser('admin');
        
        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['lastname' => __('validation.string', ['attribute' => 'lastname'])]);
    }

    /**
     * @test 
     * @testdox Test if the lastname field can only be max 255 characters
     */
    public function validationLastnameMax255(): void 
    {
        $input = ['lastname' => str_random(280), 'firstname' => $this->faker->firstName, 'email' => $this->faker->email]; 
        $user = $this->createUser('admin'); 

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['lastname' => __('validation.max.string', [
                'attribute' => 'lastname', 'max' => 255
            ])]);
    }

    /**
     * @test 
     * @testdox Test if the email field is required
     */
    public function validationEmailRequired(): void 
    {
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName];
        $user = $this->createUser('admin');

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['email' => __('validation.required', ['attribute' => 'email'])]);
    }

    /**
     * @test
     * @testdox Test if the email field can only be an string data type
     */
    public function validationEmailString(): void 
    {
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName, 'email' => rand(0, 250)];
        $user = $this->createUser('admin'); 

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['email' => __('validation.string', ['attribute' => 'email'])]);
    }

    /**
     * @test
     * @testdox Test if the email filed can only be max 255 characters
     */
    public function validationEmailMax255(): void 
    {
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName, 'email' => str_random(250) . '@example.com'];
        $user = $this->createUser('admin'); 

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['email' => __('validation.max.string', ['attribute' => 'email', 'max' => 255])]);
    }

    /**
     * @test
     * @testdox test if the email field actually contains a valid e-mail address
     */
    public function validationEmailIsEmail(): void 
    {
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName, 'email' => $this->faker->word];
        $user = $this->createUser('admin');

        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['email' => __('validation.email', ['attribute' => 'email'])]);
    }

    /**
     * @test
     * @testdox Test if the email field value is unique in the users table.
     */
    public function validationEmailUnique(): void 
    {
        $user = $this->createUser('admin');
        $input = ['firstname' => $this->faker->firstName, 'lastname' => $this->faker->lastName, 'email' => $user->email];
    
        $this->actingAs($user)
            ->post(route('admin.users.store'), $input)
            ->assertStatus(Response::HTTP_FOUND) // Code: 302
            ->assertSessionHasErrors(['email' => __('validation.unique', ['attribute' => 'email'])]);
    }
}
