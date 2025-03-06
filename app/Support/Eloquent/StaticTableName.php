<?php

namespace App\Support\Eloquent;

trait StaticTableName
{
    private static array $tableNames = [];

    public static function getTableName(): string
    {
        if (isset(self::$tableNames[static::class])) {
            return self::$tableNames[static::class];
        }

        return self::$tableNames[static::class] = (new static)->getTable();
    }
}
