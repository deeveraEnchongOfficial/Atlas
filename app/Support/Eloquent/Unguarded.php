<?php

namespace App\Support\Eloquent;

trait Unguarded
{
    public static function bootUnguarded(): void
    {
        static::unguard();
    }
}
