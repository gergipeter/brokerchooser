<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbVariant extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'targeting_ratio', 'is_selected'];

    public function abTest() {
        return $this->belongsTo(AbTest::class, 'ab_test_id');
    }

    public function getVariantsWithStartedTests() {
        return $this->leftJoin('ab_tests', 'ab_variants.ab_test_id', '=', 'ab_tests.id')
            ->where('ab_tests.status', 'started')
            ->where('ab_variants.is_selected', true)
            ->get(['ab_variants.*']);
    }
}
