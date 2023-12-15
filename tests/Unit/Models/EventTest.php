<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Session;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function testEventModel()
    {
        // Create a test Session instance
        $session = Session::factory()->create();

        // Create an Event instance
        $event = Event::create([
            'session_id' => $session->id,
            'time' => now(),
            'category' => 'example_category',
            'action' => 'example_action',
            'label' => 'example_label',
            'url' => '127.0.0.1'
        ]);

        // Retrieve the associated session from the Event model
        $associatedSession = $event->session;

        // Assert that the event was created successfully
        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals('example_category', $event->category);
        $this->assertEquals('example_action', $event->action);
        $this->assertEquals('example_label', $event->label);
        $this->assertEquals('127.0.0.1', $event->url);

        // Assert that the associated session is the same as the created session
        $this->assertInstanceOf(Session::class, $associatedSession);
        $this->assertEquals($session->id, $associatedSession->id);
    }
}
