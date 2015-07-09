<?php

try
{
$bdd = new PDO('mysql:host=Ip;dbname=name', 'login', 'pass',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
		die('Erreur : ' . $e->getMessage());
}

?>
