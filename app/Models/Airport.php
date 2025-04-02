<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Airport extends Model
{
    protected $hidden = ['country_id', 'position_id'];
    public $timestamps = false;
    protected $fillable = [
        'name',
        'country_id',
        'position_id'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function airlines(): BelongsToMany
    {
        return $this->belongsToMany(Airline::class, 'airport_airline', 'airport_id', 'airline_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
