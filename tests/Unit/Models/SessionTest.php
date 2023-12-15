<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Session;
use App\Models\Event;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    public function testSessionModel()
    {
        // Create a Session instance
        $session = Session::create([
            'time' => now(),
            'user_id' => 1,
            // Add other attributes as needed
        ]);

        // Create an Event associated with the Session
        $event = Event::create([
            'session_id' => $session->id,
            'time' => now(),
            'category' => 'example_category',
            'action' => 'example_action',
            'label' => 'example_label',
            'url' => '127.0.0.1'
        ]);

        // Retrieve the associated events from the Session model
        $associatedEvents = $session->events;

        // Assert that the session was created successfully
        $this->assertInstanceOf(Session::class, $session);

        // Assert that the associated events include the created event
        $this->assertInstanceOf(Event::class, $event);
        $this->assertCount(1, $associatedEvents);
        $this->assertEquals($event->id, $associatedEvents->first()->id);
    }
}
