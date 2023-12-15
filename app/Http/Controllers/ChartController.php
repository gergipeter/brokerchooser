<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ChartController extends Controller
{
    public function getChartData() {
    
        
        $dataSet = Event::select([
            'category as test_name',
            'label as variant',
            DB::raw('COUNT(*) as count'),
            DB::raw("'pageview' as action_type")
        ])->where('action', 'pageview')
        ->groupBy('test_name', 'variant')

        ->union(Event::select([
            'category as test_name',
            'label as variant',
            DB::raw('COUNT(*) as count'),
            DB::raw("'click' as action_type")
        ])->where('action', 'click')
        ->groupBy('test_name', 'variant'))
        ->get();

        $abTestPerformanceData = [];

        foreach ($dataSet as $event) {
            $abTestPerformanceData[] = [
                'test_name' => $event->test_name,
                'variant' => $event->variant,
                'count' => $event->count,
                'action_type' => $event->action_type,
            ];
        }
        
        // Pass the data to the view
        return View::make('charts')->with('abTestPerformanceData', $abTestPerformanceData);
    }
}
