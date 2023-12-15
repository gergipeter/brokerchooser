<?php

namespace Database\Seeders;

use App\Models\AbTest;
use App\Models\AbVariant;
use App\Models\Event;
use App\Models\Session;
use Illuminate\Database\Seeder;

class AbTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AbTest::factory()->count(20)->create()->each(function ($abTest) {
            // Create variantA for the current A/B test
            $variantA = AbVariant::factory()->state(['name' => 'Variant A'])->create(['ab_test_id' => $abTest->id]);

            // Create variantB for the current A/B test
            $variantB = AbVariant::factory()->state(['name' => 'Variant B'])->create(['ab_test_id' => $abTest->id]);

            // Create random events for variantA
            Event::factory()->count(10)->create([
                'label' => $variantA->name,
                'category' => $abTest->name,
                'session_id' => Session::factory()->create()->id,
            ]);

            // Create random events for variantB
            Event::factory()->count(10)->create([
                'label' => $variantB->name,
                'category' => $abTest->name,
                'session_id' => Session::factory()->create()->id,
            ]);
        });
    }
}
