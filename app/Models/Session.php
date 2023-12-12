<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $casts = [
        'time' => 'datetime:Y-m-d H:i:s',
    ];

    public $timestamps = false;

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
