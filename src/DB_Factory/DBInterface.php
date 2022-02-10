<?php
namespace App\DB_Factory;

interface DBInterface
{
    public function connect(array $parameter);
    public function query($connexion, $query): ?array;
}