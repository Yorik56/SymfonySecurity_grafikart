<?php
namespace App\DB_Factory;



use Doctrine\DBAL\Driver\Connection;
use phpDocumentor\Reflection\Types\Mixed_;

class PgSQL implements DBInterface
{
    public function connect($parameter)
    {
        return pg_connect("host=".$parameter['HOSTNAME'].", port=5432 dbname=".$parameter['DATABASE']." user=".$parameter['USERNAME']." password=".$parameter['PASSWORD']);
    }

    public function query($connexion, $query): ?array
    {
        $response = null;
        //Check if records exist
        $search = pg_query($connexion, $query);
        if (!$search) {
            echo "Une erreur s'est produite.\n";
            exit;
        }
        while ($row = pg_fetch_row($search)) {
            $response[] = $row;
        }
        return $response;
    }
}