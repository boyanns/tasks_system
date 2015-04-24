<?php
    $host = "37.148.204.143";
    $user = "testdb81";
    $pass = "Shorence81!";
    $dbname = "testdb81";
    try 
    {
        $PDO = new PDO( "mysql:host=".$host.";"."dbname=".$dbname, $user, $pass);  
    }
    catch(PDOException $e) 
    {
        die($e->getMessage());  
    }
?>
