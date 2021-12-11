<?php

try {
  $dbName = 'sbateliers';
  $host = 'localhost';
  $utilisateur = 'sanayabio';
  $motDePasse = 'sb2021';
  $port='3306';
  $dns = 'mysql:host='.$host .';dbname='.$dbName.';port='.$port;
  $connection = new PDO( $dns, $utilisateur, $motDePasse );

} catch ( Exception $e ) {
	echo 'probleme de connexion' ;
	die();
}
session_start();

$themeAtelier = $_POST['themeAtelier'];
$numAtelier = $connection->query("SELECT numero FROM Atelier WHERE theme = '" . $themeAtelier . "'");
$numAtelier = $numAtelier->fetchall();

$date = date('y-m-d');


$inscription = $connection->query("INSERT INTO `Participation` VALUES(". $_SESSION['numClient'] . ", ". $numAtelier[0][0] .", '". $date . "','NULL'" . ")");

$fichier = fopen('/var/log/sbateliers/access.log', 'a+');
fwrite($fichier, "\n" . $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['HTTP_USER_AGENT'] . ' - ' . $_SESSION['identifiant'] . ' - ' . date("Y-M-d : H:i:s"));
fclose($fichier);

header("Location: ../vues/vue-liste-ateliers.php");

?>