<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response->assertViewIs('auth.login');

    }

    /** @test */
    public function login_displays_validation_errors()
    {
        $response = $this->post('/login', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_successful()
    {
        //$this->withoutExceptionHandling();

        // User::create(['email' => 'admin@site.com', 'password' => bcrypt('123456'), 'name' => 'Admin']);
        // $login = $this->post('/login', ['email' => 'admin@site.com', 'password' => '123456'] );

        $user = factory(User::class)->create();
        $login = $this->post(route('login'), ['email' => $user->email, 'password' => 'password'] );

        $login->assertStatus(302);
        $login->assertRedirect(route('home'));
        $login->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);

    }
}
