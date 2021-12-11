<!DOCTYPE html>
<head>
	<title>page d'accueil</title>
	<meta charset="utf-8">
</head>

<body>
	<form method="POST" action="../controleurs/ctrl-connecter.php">
		<h2>Connexion :</h2>
		<input type="text" name="identifiant" placeholder="entrer votre identifiant"/>
		<input type="password" name="mdp" placeholder="entrer votre mot de passe"/>
		<input type="submit" value="valider">
	</form>
</body>

