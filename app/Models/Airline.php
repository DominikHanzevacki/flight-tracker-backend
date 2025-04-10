<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Airline extends Model
{
    protected $hidden = ['pivot'];
    public $timestamps = false;
    protected $fillable = [
        'name',
        'country_id'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function airports(): BelongsToMany
    {
        return $this->belongsToMany(Airport::class, 'airport_airline', 'airline_id', 'airport_id');
    }
}
