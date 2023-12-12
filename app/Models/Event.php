<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'session_id' => 'integer',
        'time' => 'datetime:Y-m-d H:i:s',
    ];

    protected $guarded = [];

    public $timestamps = false;

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
