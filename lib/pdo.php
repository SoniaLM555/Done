<?php
try
{
    $pdo = new PDO("mysql:dbname=Done;host=localhost;charsert=utf8mb4", "root", "");
}
catch (Exception $e)
{
        die('Erreur :' . $e->getMessage());
}
?>