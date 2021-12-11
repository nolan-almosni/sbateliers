<?php

session_start();

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

$requete = $connection->query('SELECT * FROM Client where numero = '. $_SESSION['numClient']);
$infosClient = $requete->fetch();

?>
<body>
  <table>
    <thead>
      <tr>
        <th>Numero</th>
        <th>civilite</th>
        <th>nom</th>
        <th>prenom</th>
        <th>date de naissance</th>
        <th>adresse mail</th>
        <th>adresse postale</th>
        <th>code postale</th>
        <th>ville</th>
        <th>numero de téléphone</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td><?php echo $infosClient['numero'];?></td>
          <td><?php echo $infosClient['civilité'];?></td>
          <td><?php echo $infosClient['nom'];?></td>
          <td><?php echo $infosClient['prenom'];?></td>
          <td><?php echo $infosClient['dateNaissance'];?></td>
          <td><?php echo $infosClient['adresseMail'];?></td>
          <td><?php echo $infosClient['adressePostale'];?></td>
          <td><?php echo $infosClient['codePostale'];?></td>
          <td><?php echo $infosClient['ville'];?></td>
          <td><?php echo $infosClient['numeroTelephone'];?></td>
        </tr>
    </tbody>
  </table>

<br/>

<a href="vue-liste-ateliers.php" type="button">acceder a la liste des ateliers</a>
<br>
<a href="vue-ateliers-programmes.php" type="button">voir les ateliers programés</a>


</body>