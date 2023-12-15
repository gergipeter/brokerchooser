<?php

namespace Database\Factories;

use App\Models\AbTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AbTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'test_' . $this->faker->word(),
            'status' => 'new',
        ];
    }
}
