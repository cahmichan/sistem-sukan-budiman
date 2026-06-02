<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function allAsArray(): array
    {
        return static::pluck('value', 'key')->all();
    }

    public static function registrationIsOpen(): bool
    {
        if (static::getValue('registration_is_open', '1') !== '1') {
            return false;
        }

        $deadline = static::getValue('registration_deadline');

        return blank($deadline) || Carbon::parse($deadline)->isFuture();
    }
}
