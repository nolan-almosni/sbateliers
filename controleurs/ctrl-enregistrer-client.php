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

$errLog = fopen('/var/log/sbateliers/arr_input.log', 'a+');

$civilite = $_POST['civilite'];

if(preg_match("/[A-Z]{3,}|[a-z]{3,}/",$_POST['nom'] )){
  $nom = $_POST['nom'];
}else{
  header("Location: ../vues/vue-enregistrement-client.php?err=1");
  $journal = $_SERVER['REMOTE_ADDR'] . " " . date("Y-M-d : H:i:s") . " inscription client nom : " . $_POST['nom'] . "\n";
  $fwrite($errLog,$journal);
  $fclose($errLog); 
  exit();
}

if(preg_match("/[A-Z]{3,}|[a-z]{3,}/",$_POST['prenom'] )){
  $prenom = $_POST['prenom'];
}else{
  header("Location: ../vues/vue-enregistrement-client.php?err=2");
  $journal = $_SERVER['REMOTE_ADDR'] . " " . date("Y-M-d : H:i:s") . " inscription client prenom : " . $_POST['prenom'] . "\n";
  $fwrite($errLog,$journal);
  $fclose($errLog); 
  exit();
}

$dateNaissance = $_POST['dateNaissance'];

$mail = $_POST['mail'];

$mdp = $_POST['mdp'];

if(preg_match("/[A-Z]{2,}|[a-z]{2,}|[0-9]{1,}/",$_POST['adressePostale'])){
  $adressePostale = $_POST['adressePostale'];
}else{
  header("Location: ../vues/vue-enregistrement-client.php?err=3");
  $journal = $_SERVER['REMOTE_ADDR'] . " " . date("Y-M-d : H:i:s") . " inscription client adresse postale : " . $_POST['adressePostale'] . "\n";
  $fwrite($errLog,$journal);
  $fclose($errLog); 
  exit();
}

if(preg_match("/^([0-9]{5}|2([A]|[B])[0-9]{3})$/",$_POST['codePostale'])){
  $codePostale = $_POST['codePostale'];
}else{
  header("Location: ../vues/vue-enregistrement-client.php?err=4");
  $journal = $_SERVER['REMOTE_ADDR'] . " " . date("Y-M-d : H:i:s") . " inscription client code postale : " . $_POST['codePostale'] . "\n";
  $fwrite($errLog,$journal);
  $fclose($errLog); 
  exit();
}

if(preg_match("/[A-Z]{3,}|[a-z]{3,}/",$_POST['ville'])){
$ville = $_POST['ville'];
}else{
  header("Location: ../vues/vue-enregistrement-client.php?err=5");
  $journal = $_SERVER['REMOTE_ADDR'] . " " . date("Y-M-d : H:i:s") . " inscription client ville : " . $_POST['ville'] . "\n";
  $fwrite($errLog,$journal);
  $fclose($errLog); 
  exit();
}

if(preg_match("/^([0][6]|[0][7])[0-9]{8}$/",$_POST['numTel'])){
  $numTel=$_POST['numTel'];
}else{
  header("Location: ../vues/vue-enregistrement-client.php?err=6");
  $journal = $_SERVER['REMOTE_ADDR'] . " " . date("Y-M-d : H:i:s") . " inscription client numéro de téléphone : " . $_POST['numTel'] . "\n";
  $fwrite($errLog,$journal);
  $fclose($errLog);
  exit();
}


$dernierNumClient = $connection->query("SELECT MAX(numero) FROM `Client`");
$dernierNumClient = $dernierNumClient->fetchall();

$nouveauNumClient = $dernierNumClient[0][0]+1;

$mailDejaConnu = $connection->query("SELECT numero from `Client` where adresseMail IN('" . $mail . "')");
$mailDejaConnu = $mailDejaConnu->fetchall();

if($mailDejaConnu[0][0]==null){
$enregistrementClient = $connection->query("INSERT INTO `Client` VALUES(" . $nouveauNumClient . ",'" . $civilite . "',AES_ENCRYPT('" 
                                      . $nom . "',SHA2('password', 512)),AES_ENCRYPT('" . $prenom . "',SHA2('password', 512)),'" . $dateNaissance 
                                      . "',AES_ENCRYPT('" . $mail . "',SHA2('password', 512)),SHA2('" . $mdp  . "',512)"
                                      . ",AES_ENCRYPT('" . $adressePostale . "',SHA2('password', 512)),'" . $codePostale . "','" . $ville 
                                      . "',AES_ENCRYPT('" . $numTel . "',SHA2('password', 512)))");


$fichier = fopen('/var/log/sbateliers/access.log', 'a+');
fwrite($fichier, "\n" . $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['HTTP_USER_AGENT'] . ' - ' . $_SESSION['identifiant'] . ' - ' . date("Y-M-d : H:i:s"));
fclose($fichier);

header('Location: ../');
}else{
  $fichier = fopen('/var/log/sbateliers/access.log', 'a+');
  fwrite($fichier, "\n" . $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['HTTP_USER_AGENT'] . ' - ' . $_SESSION['identifiant'] . ' - ' . date("Y-M-d : H:i:s"));
  fclose($fichier);
  header('Location: ../vues/vue-enregistrement-client.php');
}
