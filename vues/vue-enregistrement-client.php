<!DOCTYPE html>
<head>
	<title>enregistrement</title>
	<meta charset="utf-8">
</head>

<body>
	<?php 
	if($_GET['err']== 1){echo "nom invalide";}
	if($_GET['err']== 2){echo "prenom invalide";}
	if($_GET['err']== 3){echo "adresse postale invalide";}
	if($_GET['err']== 4){echo "code postale invalide";}
	if($_GET['err']== 5){echo "ville invalide";}
	if($_GET['err']== 6){echo "numero de téléphone invalide";} ?>
	<form method="POST" action="../controleurs/ctrl-enregistrer-client.php">
		<h2>enregistrement :</h2>
		<input type="radio" name="civilite" value="homme" checked />Homme
		<input type="radio" name="civilite" value="femme">Femme</label>
		<br>
		<br>
		<input type="text" name="nom" placeholder="entrer votre nom"/>
		<br>
		<br>
		<input type="text" name="prenom" placeholder="entrer votre prenom"/>
		<br>
		<br>
		<input type="date" name="dateNaissance" placeholder="entrer votre date de naissance"/>
		<br>
		<br>
		<input type="text" name="mail" placeholder="entrer votre adresse mail"/>
		<br>
		<br>
		<input type="password" name="mdp" placeholder="entrer votre mot de passe"/>
		<br>
		<br>
		<input type="text" name="adressePostale" placeholder="entrer votre adresse postale"/>
		<br>
		<br>
		<input type="text" name="codePostale" placeholder="entrer votre code postale"/>
		<br>
		<br>
		<input type="text" name="ville" placeholder="entrer votre ville"/>
		<br>
		<br>
		<input type="text" name="numTel" placeholder="entrer votre numero de telephone"/>
		<br>
		<br>
		<input type="submit" value="valider">
	</form>
</body>