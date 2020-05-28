<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Event;
use Illuminate\Support\Facades\DB;


class EventsControllerTest extends TestCase
{
    use refreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        // $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

    }

    /** @test */
    public function user_can_view_unavailables_page()
    {
        $user = User::Find(1);

        $this->assertInstanceOf(User::class, $user);

        $response = $this->actingAs($user)->get('/events');

        $response->assertStatus(200);
    }

    /** @test */
    public function the_create_method_returns_the_correct_view()
    {
        $user = User::Find(1);
        $response = $this->actingAs($user)->get('events/create');
        $response->assertStatus(200);
        $response->assertViewIs('CreateEvent');
    }

    /** @test */
    public function the_store_method_validates_the_request_attributes()
    {
        // $this->withoutExceptionHandling();
        $user = User::Find(1);
        $response = $this->actingAs($user)
        ->post('events', ['title' => '','startDate' => "2020-01-01 03:00:00", 'endDate' => "2020-01-05 03:00:00",
         'participants' => 1]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');

        $response = $this->actingAs($user)
        ->post('events', ['title' => 'title','startDate' => "2020-01-01 3:00:00", 'endDate' => "2020-01-05 03:00:00",
         'participants' => 1]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('startDate');

        $response = $this->actingAs($user)
        ->post('events', ['title' => 'title','startDate' => "2020-01-01 03:00:00", 'endDate' => "2020-01-01 03:00:00",
         'participants' => 1]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('endDate');
    }

    /** @test */
    public function the_store_method_creates_an_entry_in_the_events_table()
    {
        // $this->withoutExceptionHandling();
        $user = User::Find(1);
        $response = $this->actingAs($user)
        ->post('events', ['title' => $title = 'title', 'startDate' => $start = "2020-01-01 03:00:00", 'endDate' => $end = "2020-01-05 05:00:00",
         'duration' => $duration = 5, 'participants' => $participants = 1]);

        $response->assertStatus(302);
        $count = Event::count();
        $event = Event::find($count);
        $this->assertIsObject($event);
        $this->assertEquals($title, $event->title);
        $this->assertEquals($start, $event->startDate);
        $this->assertEquals($end, $event->endDate);
        $this->assertEquals($user->id, $event->host_id);
        $this->assertEquals($participants, $event->participants);
    }

    /** @test */
    public function the_show_method_returns_the_correct_view()
    {
        $event = Event::find(1);
        $user = $event->users->first();
        $response = $this->actingAs($user)->get('events/1');

        $response->assertStatus(200);
        $response->assertViewIs('availables3');

        $response->assertViewHas('event');
        $response->assertViewHas('user', $user);
        $response->assertViewHas('availables');
        $response->assertViewHas('guests');
        $response->assertViewHas('comments');
        $response->assertViewHas('blocks');
    }

    /** @test */
    public function user_must_be_a_participant_or_an_admin_to_view_the_event()
    {
        $event = Event::find(1);
        $participants = $event->users->pluck('id')->toArray();

        $i = 2;
        while(in_array($i, $participants)){
            $i++;
        }

        $user = User::find($i);

        $response = $this->actingAs($user)->get('events/1');
        $response->assertStatus(403);
    }

    /** @test */
    public function event_host_can_generate_shareable_link()
    {
        $event = Event::find(1);

        $user = $event->host;

        $response = $this->actingAs($user)->get('event/share/1');

        $response->assertStatus(200);
        $response->assertViewIs('ShowEvents');
        $response->assertViewHas('link');

        $data = $response->getOriginalContent()->getData();
        $link = $data['link']->url;
        $this->assertIsString($link);

        $response = $this->actingAs($user)->get('event/share/1');
        $data = $response->getOriginalContent()->getData();
        $link2 = $data['link']->url;
        $this->assertEquals($link, $link2);
    }

    /** @test */
    public function user_can_view_participation_page_via_shareable_link()
    {
        $event = Event::find(1);

        $host = $event->host;

        $response = $this->actingAs($host)->get('event/share/1');

        $data = $response->getOriginalContent()->getData();
        $link = $data['link']->url;

        // $user = User::create(['name' => 'user', 'email' => 'example@site.com']);

        $response = $this->
        // actingAs($user)->
        get($link);

        $response->assertStatus(200);
        $response->assertViewIs('Participate');
        $response->assertViewHas('event');
        $response->assertViewHas('host');
    }

    /** @test */
    public function unauthenticated_user_is_redirected_to_login_page_then_added_to_participants()
    {
        $event = Event::find(1);

        $host = $event->host;

        $response = $this->get('event/participate/1');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('intended', url('event/participate/1'));

        $user = User::Find(2);

        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);
        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect(url('home'));
    }





}
