<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    public const CHILD_AGE_THRESHOLD = 12;

    public static function categoryForAge(int $age): string
    {
        return $age < self::CHILD_AGE_THRESHOLD ? 'Kanak-Kanak' : 'Dewasa';
    }

    protected $fillable = [
        'registration_code',
        'name',
        'age',
        'phone',
        'category',
        'house_id',
        'guardian_id',
        'status',
        'notes',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function sportRegistrations(): HasMany
    {
        return $this->hasMany(SportRegistration::class);
    }

    public function getIsChildAttribute(): bool
    {
        return self::categoryForAge((int) $this->age) === 'Kanak-Kanak';
    }
}
