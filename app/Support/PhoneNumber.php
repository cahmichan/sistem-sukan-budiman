<?php

namespace App\Support;

class PhoneNumber
{
    public static function normalize(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (blank($digits)) {
            return null;
        }

        if (str_starts_with($digits, '60')) {
            return '0'.substr($digits, 2);
        }

        return $digits;
    }

    public static function toWhatsApp(?string $phone): ?string
    {
        $normalized = self::normalize($phone);

        if (! $normalized || ! preg_match('/^01[0-9]{8,9}$/', $normalized)) {
            return null;
        }

        return '60'.substr($normalized, 1);
    }
}
