<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Travel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'slug', 'destination', 'start_date', 'end_date', 'description', 'photo'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
