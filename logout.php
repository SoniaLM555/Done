<?php 
require_once __DIR__."/lib/session.php";
// Pour prévenir les attaques de fixation de session
session_regenerate_id(true);

//Pour supprimer les données du serveur
session_destroy();

//Pour supprimer les données du tableau session
unset($session);

header('location: login.php');

