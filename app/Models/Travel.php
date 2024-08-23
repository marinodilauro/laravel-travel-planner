<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    use HasFactory;

    protected $table = 'travels';

    protected $fillable = ['user_id', 'name', 'slug', 'destination', 'start_date', 'end_date', 'description', 'photo'];

    /**
     * The user linked to the travel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The stage that belong to the DoctorProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}
