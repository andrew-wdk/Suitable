<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Unavailable;
use App\Repeatable;

class UnavailablesControllerTest extends TestCase
{
    use refreshDatabase;



    public function setUp(): void
    {
        parent::setUp();
        // $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

    }
    
     /** @test */
    public function user_can_view_unavailables_page()
    {
        $user = User::Find(1);

        $this->assertInstanceOf(User::class, $user);

        $response = $this->actingAs($user)->get('/unavailables');

        $response->assertStatus(200);
    }

    /** @test */
    public function logged_out_user_cannot_view_unavailables_page()
    {
        $response = $this->get('/unavailables');

        $response->assertStatus(302);
    }

    /** @test */
    public function the_create_method_returns_the_correct_view()
    {
        $user = User::Find(1);
        $response = $this->actingAs($user)->get('unavailables/create');
        $response->assertStatus(200);
        $response->assertViewIs('InsertUnavailables');
    }

    /** @test */
    public function the_store_method_validates_the_request_attributes()
    {
        // $this->withoutExceptionHandling();
        $user = User::Find(1);
        $response = $this->actingAs($user)
        ->post('unavailables', ['start' => "2020-01-01 03:00:00", 'end' => "2020-01-01 03:00:00",
         'priority' => 1]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('end');

        $response = $this->actingAs($user)
        ->post('unavailables', ['start' => "2020-01-01 3:00:00", 'end' => "2020-01-01 08:00:00",
         'priority' => 1]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('start');

        $response = $this->actingAs($user)
        ->post('unavailables', ['start' => "2020-01-01 3:00:00", 'end' => "2020-01-01 08:00:00"]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('priority');
    }

    /** @test */
    public function the_store_method_creates_an_entry_in_the_unavailables_table()
    {
        $this->withoutExceptionHandling();
        $user = User::Find(1);
        $response = $this->actingAs($user)
        ->post('unavailables', ['start' => $start = "2020-01-01 03:00:00", 'end' => $end = "2020-01-01 05:00:00",
         'priority' => $priority = 1]);

        // $response->assertViewIs('Home');
        $unav = Unavailable::Find(1);
        $this->assertIsObject($unav);
        $this->assertEquals($start, $unav->start);
        $this->assertEquals($end, $unav->end);
        $this->assertEquals($user->id, $unav->user_id);
        $this->assertEquals($priority, $unav->priority);
    }

    /** @test */
    public function the_store_method_creates_an_entry_in_the_repeatables_table()
    {
        $this->withoutExceptionHandling();
        $user = User::Find(1);
        $response = $this->actingAs($user)
        ->post('unavailables', ['start' => $start = "2020-01-01 03:00:00", 'end' => $end = "2020-01-01 05:00:00",
         'priority' => $priority = 1, '7' => true]);

        // $response->assertViewIs('Home');
        $rep = Repeatable::Find(1);
        $this->assertIsObject($rep);
        $this->assertEquals($start, $rep->start);
        $this->assertEquals($end, $rep->end);
        $this->assertEquals($user->id, $rep->user_id);
        $this->assertEquals($priority, $rep->priority);
    }
}
