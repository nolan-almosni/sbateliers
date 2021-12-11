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



	$identifiant = $_POST['identifiant'];
	$mdp = $_POST['mdp'];
		
	$identifiantCrypt = $connection->query("SELECT AES_ENCRYPT('" . $identifiant . "',SHA2('password',512))");
	$identifiantCrypt = $identifiantCrypt->fetch();
	 
	$identification = $connection->query("SELECT mdp FROM `Client` WHERE adresseMail = '" . $identifiantCrypt[0] . "'");
	
	$mdpIdentification = $identification-> fetchall();

	$hashageMdp = $connection->query("SELECT SHA2('" . $mdp . "',512)");
	$mdp = $hashageMdp->fetch();

	if ($mdpIdentification[0]['mdp'] == $mdp[0] and $mdpIdentification[0]['mdp'] != null){
		$numeroClient = $connection->query("SELECT numero FROM `Client` WHERE adresseMail = '". $identifiantCrypt[0] ."'");
		$numeroClient = $numeroClient->fetchall();
		session_start();
		$_SESSION['numClient'] = $numeroClient[0][0];
		$_SESSION['identifiant'] = $identifiant;

		$fichier = fopen('/var/log/sbateliers/access.log', 'a+');
		fwrite($fichier, "\n" . $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['HTTP_USER_AGENT'] . ' - ' . $_SESSION['identifiant'] . ' - ' . date("Y-M-d : H:i:s"));
		fclose($fichier);


		header("Location: ../vues/vue-consultation-profil.php");

	}else{
		session_start();
		$_SESSION['identifiant'] = $identifiant;

		$fichier = fopen('/var/log/sbateliers/access.log', 'a+');
		fwrite($fichier, "\n" . $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['HTTP_USER_AGENT'] . ' - ' . $_SESSION['identifiant'] . ' - ' . date("Y-M-d : H:i:s"));
		fclose($fichier);
		session_destroy();
		header("Location: ../vues/vue-connexion.php");
	}
?>
