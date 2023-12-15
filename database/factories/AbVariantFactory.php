<?php

namespace Database\Factories;

use App\Models\AbTest;
use App\Models\AbVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AbVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'targeting_ratio' => $this->faker->randomFloat(2, 0, 1),
            'ab_test_id' => AbTest::factory(),
        ];
    }

    /**
     * Define a state for variant A.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function variantA()
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'name' => 'Variant A',
            ]);
        });
    }

    /**
     * Define a state for variant B.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function variantB()
    {
        return $this->state(function (array $attributes) {
            return array_merge($attributes, [
                'name' => 'Variant B',
            ]);
        });
    }
}
