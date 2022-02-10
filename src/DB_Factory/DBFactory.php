<?php
namespace App\DB_Factory;

use JetBrains\PhpStorm\Pure;


class DBFactory
{
    #[Pure] public static function create($type): MySQL|PgSQL|null
    {
        return match ($type) {
            'postgres' => new PgSQL(),
            'mysql' => new MySQL(),
            default => null,
        };
    }
}