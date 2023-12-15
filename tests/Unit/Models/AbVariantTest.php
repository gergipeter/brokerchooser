<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AbVariant;
use App\Models\AbTest;

class AbVariantTest extends TestCase
{
    use RefreshDatabase;

    public function testGetVariantsWithStartedTests()
    {
        // Create a test AbTest instance with a status of 'started'
        $abTest = AbTest::factory()->create(['status' => AbTest::STATUS_STARTED]);

        // Create AbVariant instances associated with the AbTest
        $variant1 = AbVariant::factory()->create([
            'name' => 'Variant A',
            'ab_test_id' => $abTest->id,
            'is_selected' => true,
        ]);

        // Call the getVariantsWithStartedTests method
        $abVariantInstance = new AbVariant();
        $variants = $abVariantInstance->getVariantsWithStartedTests();

        // Assert for variant1
        $this->assertCount(1, $variants);

        $this->assertEquals($variant1->id, $variants[0]->id);
        $this->assertEquals($variant1->name, $variants[0]->name);
        $this->assertEquals($variant1->targeting_ratio, $variants[0]->targeting_ratio);
        $this->assertEquals($variant1->is_selected, $variants[0]->is_selected);
        $this->assertEquals($abTest->id, $variants[0]->ab_test_id);
    }
}
