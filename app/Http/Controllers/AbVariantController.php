<?php

namespace App\Http\Controllers;

use App\Models\AbVariant;

class AbVariantController extends Controller
{
    public function listAllVariants()
    {
        $variants = (new AbVariant())->getVariantsWithStartedTests();

        return view('list_all_variants', compact('variants'));
    }
}
