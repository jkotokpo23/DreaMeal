<?php
    $host = "localhost";
    $port = "5432";
    $dbname = "projet_bd";
    $user = "postgres";
    $password = "t26DY8+N";
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $connexion = pg_connect($conn_string);
    
    if (!$connexion) {
        echo "Erreur de connexion : ";
    } else {
         
    }
?>