<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AbTest;
use App\Models\AbVariant;
use App\Models\Event;

class AbTestTest extends TestCase
{
    use RefreshDatabase;

    public function testSelectVariant()
    {
        // Create a test AbTest instance with variants
        $abTest = AbTest::factory()->create();
        $variant1 = AbVariant::factory()->create(['name' => 'Variant A', 'ab_test_id' => $abTest->id, 'targeting_ratio' => 30]);
        $variant2 = AbVariant::factory()->create(['name' => 'Variant B', 'ab_test_id' => $abTest->id, 'targeting_ratio' => 70]);

        // Call the selectVariant method
        $result = $abTest->selectVariant();
    
        // Assert that the selected variant's ID
        $expectedVariantIds = [$variant1->id, $variant2->id];
        $this->assertContains($result['variant']->id, $expectedVariantIds);
    }

    public function testTestDuration()
    {
        // Create a test AbTest instance with a specific status
        $abTest = AbTest::factory()->create(['status' => AbTest::STATUS_STOPPED]);
    
        // Set created_at and updated_at to simulate a time difference
        $abTest->created_at = now()->subHours(2);
        $abTest->updated_at = now();
    
        // Call the testDuration method
        $result = $abTest->testDuration();
    
        // Assert the expected result format
        $this->assertStringContainsString('2 hours', $result);
        $this->assertStringContainsString('0 minutes', $result);
    }

    public function testTestStarted()
    {
        // Create a test AbTest instance with a specific status
        $abTest = AbTest::factory()->create(['status' => AbTest::STATUS_STARTED]);

        // Set updated_at to simulate a recent update
        $abTest->updated_at = now()->subMinutes(10);

        // Call the testStarted method
        $result = $abTest->testStarted();

        // Assert the expected result format
        $this->assertStringContainsString('10 minutes before', $result);
    }

    public function testTestResult()
    {
        // Create a test AbTest instance with a specific status
        $abTest = AbTest::factory()->create(['status' => AbTest::STATUS_STOPPED]);

        // Create Event instances for the test
        Event::factory()->create(['category' => 'test_category', 'label' => 'variant_1', 'action' => 'click']);
        Event::factory()->create(['category' => 'test_category', 'label' => 'variant_1', 'action' => 'pageview']);
        Event::factory()->create(['category' => 'test_category', 'label' => 'variant_2', 'action' => 'click']);
        Event::factory()->create(['category' => 'test_category', 'label' => 'variant_2', 'action' => 'pageview']);

        // Call the testResult method
        $result = $abTest->testResult('test_category');

        // Assert the expected formatted result
        $this->assertEquals("Clicks: 1, Pageviews: 1, Click-to-Pageview Ratio: 1.00\n", $result);
    }
}
