<?php

namespace Tests\Feature\Policies;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use ActivismeBe\Models\Fragments;

/**
 * Class PolicyPagesTest 
 * ----
 * PHPUnit testsuite for the policy pages
 * 
 * @author      Tim Joosten <Tim@activisme.be>
 * @copyright   Tim Joosten <MIT License>
 * @package     Tests\Feature\Policies
 */
class PolicyPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @testdox Test if the user can view the privacy policy without any problems. 
     */
    public function privacyPolicy(): void 
    {
        factory(Fragments::class)->create(['page' => 'Privacy Policy']);
        $this->get(route('policy.privacy'))->assertStatus(Response::HTTP_OK); // Code: 200
    }

    /**
     * @test
     * @testdox Test if the user can view the terms of service page without any problems.
     */
    public function termsOfService(): void 
    {
        factory(Fragments::class)->create(['page' => 'Terms Of Service']);
        $this->get(route('policy.terms'))->assertStatus(Response::HTTP_OK); // Code: 200
    }
}
