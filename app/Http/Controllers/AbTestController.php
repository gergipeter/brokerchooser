<?php

namespace App\Http\Controllers;

use App\Models\AbTest;
use App\Models\AbVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AbTestController extends Controller
{
    public function createTest(Request $request) {
        if ($request->isMethod('post')) {
            // Validate the form data
            $request->validate([
                'test_name' => 'required|string',
            ]);

            // Create A/B test
            $abTest = AbTest::create([
                'name' => $request->input('test_name'),
                'status' => AbTest::STATUS_NEW,
            ]);
            
            // Create default Variant A and Variant B with  random targeting_ratio to the test
            $abVariant = new AbVariant();
            $abVariant->ab_test_id = $abTest->id;
            $abVariant->name = 'Variant A';
            $abVariant->targeting_ratio = mt_rand(0, 100) / 100;;
            $abVariant->save();

            $abVariant = new AbVariant();
            $abVariant->ab_test_id = $abTest->id;
            $abVariant->name = 'Variant B';
            $abVariant->targeting_ratio = mt_rand(0, 100) / 100;;
            $abVariant->save();

            return redirect('/')->with('successCreated', 'A/B Test created successfully!');
        } else {
            return view('create-test');
        }
    }

    public function startTest($id) {
        $abTest = AbTest::findOrFail($id);

        //$selectedVariant contains the randomly selected AbVariant instance
        if ($abTest->status === AbTest::STATUS_NEW) {
            $abTest->status = AbTest::STATUS_STARTED;
            $abTest->save();
            
            $abTestSelectedVariantArray = $abTest->selectVariant();
            $selectedVariant = $abTestSelectedVariantArray['variant'];

            $randomNumber = $abTestSelectedVariantArray['randomNumber'];
            $cumulativeWeight = $abTestSelectedVariantArray['cumulativeWeight'];

            $abVariant = AbVariant::find($selectedVariant->id);
            $abVariant->is_selected = true;
            $abVariant->save();

            return View::make('ab_test')->with([
                'abTest' => $abTest,
                'selectedVariant' => $selectedVariant,
                'randomNumber' => $randomNumber,
                'cumulativeWeight' => $cumulativeWeight,
            ]);
        }


    }

    public function stopTest($id) {
        $abTest = AbTest::findOrFail($id);

        if ($abTest->status === AbTest::STATUS_STARTED) {
            $abTest->status = AbTest::STATUS_STOPPED;
            $abTest->save();
        }

        return View::make('ab_test')->with(['abTest' => $abTest]);
    }

    public function listAllTests() {
        $tests = AbTest::with('variants')->get();

        return view('list_all_tests', compact('tests'));
    }
}
