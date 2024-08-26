<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = ['travel_id', 'place', 'slug', 'day', 'note', 'photo'];


    /**
     * The travel linked to the stage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
}
