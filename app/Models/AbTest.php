<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbTest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public const STATUS_NEW = 'new';
    public const STATUS_STARTED = 'started';
    public const STATUS_STOPPED = 'stopped';

    public function variants() {
        return $this->hasMany(AbVariant::class);
    }

    /**
     * Simulate a weighted random selection based on the targeting ratios of the variants.
     * The larger the targeting ratio of a variant, the higher the probability that it will be selected.
     */
    public function selectVariant() {
        $variants = $this->variants()->get();

        $totalWeight = $variants->sum('targeting_ratio');
        $randomNumber = mt_rand(0, $totalWeight * 100) / 100;
    
        $cumulativeWeight = 0;

        foreach ($variants as $variant) {
            $cumulativeWeight += $variant->targeting_ratio;
            if ($randomNumber <= $cumulativeWeight) {
                return [
                    'variant' => $variant,
                    'randomNumber' => $randomNumber,
                    'cumulativeWeight' => $cumulativeWeight
                ];
            }
        }

        // Fallback: Return null if variants collection is empty
        return [
            'variant' => optional($variants->first()),
            'randomNumber' => $randomNumber ?? null, // Ensure $randomNumber is not null
            'cumulativeWeight' => $cumulativeWeight ?? null, // Ensure $cumulativeWeight is not null
        ];
    }

    public function testDuration(): string {
        if ($this->status === self::STATUS_STOPPED) {
            $created_at = Carbon::parse($this->created_at);
            $updated_at = Carbon::parse($this->updated_at);

            $durationInMinutes = $created_at->diffInMinutes($updated_at);
            $durationInHours = $created_at->diffInHours($updated_at);

            return "$durationInHours hours and $durationInMinutes minutes";

        }

        return 'N/A';
    }

    public function testStarted(): string {
        if ($this->status === self::STATUS_STARTED) {
            $updated_at = $this->updated_at;
            $now = Carbon::now();
            return $updated_at->diffForHumans($now);
        }

        return 'N/A';
    }

    public function testResult($testName): string {
        if ($this->status === self::STATUS_STOPPED) {
            // Assuming you have a model corresponding to the "events" table
            $results = DB::table('events')
                ->select('category as test_name', 'label as variant', 
                    DB::raw('SUM(CASE WHEN action = "click" THEN 1 ELSE 0 END) as clicks'),
                    DB::raw('SUM(CASE WHEN action = "pageview" THEN 1 ELSE 0 END) as pageviews'),
                    DB::raw('(SUM(CASE WHEN action = "click" THEN 1 ELSE 0 END) / SUM(CASE WHEN action = "pageview" THEN 1 ELSE 0 END)) as click_to_pageview_ratio')
                )->where('category', $testName)
                ->groupBy('test_name', 'variant')
                ->get();
    
            // Process the $results and return the formatted result
            $formattedResult = '';
            $maxRatio = null;
            $maxRatioResult = null;

            foreach ($results as $result) {
                // Check if the current ratio is higher than the maximum
                if ($maxRatio === null || $result->click_to_pageview_ratio > $maxRatio) {
                    $maxRatio = $result->click_to_pageview_ratio;
                    $maxRatioResult = $result;
                }
            }

            if ($maxRatioResult !== null) {
                $formattedMaxRatio = number_format($maxRatioResult->click_to_pageview_ratio, 2);
                $formattedResult .= "Clicks: $maxRatioResult->clicks, Pageviews: $maxRatioResult->pageviews, Click-to-Pageview Ratio: $formattedMaxRatio\n";
            }

            return $formattedResult;
        }
    
        return 'N/A';
    }
}
