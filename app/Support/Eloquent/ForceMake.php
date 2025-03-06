<?php

namespace App\Support\Eloquent;

trait ForceMake
{
    public static function forceMake(array $attributes): static
    {
        return (new static)->forceFill($attributes);
    }
}
