<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $routes = Route::getRoutes();
        $routesStringArray = [];

        foreach ($routes as $route) {
            $routesStringArray[] = $route->uri();
        }

        return [
            'session_id' => function () {
                return Session::factory()->create()->id;
            },
            'time' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'action' => $this->faker->randomElement(['pageview', 'click']),
            'url' => $this->faker->randomElement($routesStringArray)
        ];
    }
}
