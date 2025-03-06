<?php

namespace App\Support\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUniqueIds;
use Illuminate\Support\Str;

trait HasStringId
{
    use HasUniqueIds;

    public function uniqueIds(): array
    {
        return [$this->getKeyName()];
    }

    /**
     * Determine if the model uses unique ids.
     *
     * @return bool
     */
    public function usesUniqueIds()
    {
        return true;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return false;
        }

        return $this->incrementing;
    }

    public function newUniqueId(): string
    {
        return Str::ulid()->toString();
    }
}
