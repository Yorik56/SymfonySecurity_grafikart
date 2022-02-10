<?php
namespace App\DB_Factory;

use mysqli;

class MySQL implements DBInterface
{

    public function connect($parameter)
    {
        //Connect to the database
        $con = mysqli_connect(
            $parameter['HOSTNAME'],
            $parameter['USERNAME'],
            $parameter['PASSWORD'],
            $parameter['DATABASE']
        )
        or die (
            "html>script language='JavaScript'>alert('Impossible de se connecter à la base de données ! Réessayez plus tard.'),history.go(-1)/script>/html>"
        );
        return $con;
    }

    public function query($connexion, $query): ?array
    {
        $response = null;
        // Execute request
        $search = mysqli_query($connexion, $query);
        //Check if records exist
        if(is_object($search)){
            foreach ($search as $row ) {
                $response[] = $row;
            }
        }
        return $response;
    }
}