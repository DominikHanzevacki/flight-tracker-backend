<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Position extends Model
{
    public $timestamps = false;
    protected $fillable = ['latitude', 'longitude'];

    public function airport(): HasOne
    {
        return $this->hasOne(Airport::class);
    }
}
