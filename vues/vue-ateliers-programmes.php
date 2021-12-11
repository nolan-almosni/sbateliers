<!DOCTYPE html>
<head>
  <title>page d'accueil</title>
  <meta charset="utf-8">
</head>

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

$Ateliers = $connection->query("SELECT * FROM `Atelier`");

?>
<body>
  <table>
    <thead>
      <tr>
        <th>Ateliers</th>
        <th>numeroResponsable</th>
        <th>dateEnregistrement</th>
        <th>dateHeureProgramme</th>
        <th>duree</th>
        <th>nbPlace</th>
        <th>theme</th>
        <th>commentaire</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $numCom=0;
      foreach($Ateliers as $Atelier){
        $numAtelierInscrit = $connection->query("SELECT numeroAtelier, commentaire FROM Participation WHERE numeroClient =" . $_SESSION['numClient'] );
        $numAtelierInscrit = $numAtelierInscrit->fetchall();

        $nomAtelierInscrit = array();

        for($i=0;$i<count($numAtelierInscrit);$i++){
          $nomAtelier = $connection->query("SELECT theme FROM Atelier WHERE numero = " . $numAtelierInscrit[$i]['numeroAtelier']);
          $nomAtelier = $nomAtelier->fetchall();
          array_push($nomAtelierInscrit, $nomAtelier[0][0]);
        }
        if(in_array($Atelier['theme'], $nomAtelierInscrit)){?>
        <tr>
          <td><?php echo $Atelier['numero'];?></td>
          <td><?php echo $Atelier['numeroResponsable'];?></td>
          <td><?php echo $Atelier['dateEnregistrement'];?></td>
          <td><?php echo $Atelier['dateHeureProgramme'];?></td>
          <td><?php echo $Atelier['duree'];?></td>
          <td><?php echo $Atelier['nbPlace'];?></td>
          <td><?php echo $Atelier['theme'];?></td>
          <?php if($numAtelierInscrit[$numCom]['commentaire'] == "NULL"){ ?>         
          <form method="POST" action="../controleurs/ctrl-commenter-atelier.php">
            <input type="hidden" name="themeAtelier" value='<?php echo $Atelier['theme'] ?>'/>
          <td><input name="commentaire" placeholder="laisser un commentaire"></td></form>
          <?php }else{ ?>
            <td><?php echo $numAtelierInscrit[$numCom]['commentaire'] ?></td>
            <form method="POST" action="../controleurs/ctrl-supp-commentaire.php">
            <input type="hidden" name="numAtelier" value='<?php echo $numAtelierInscrit[$i]['numeroAtelier'] ?>'/>
          <td><input type="submit" value="supprimer commantaire"></td></form>
          <?php }$numCom +=1 ; ?>
        </tr>
      <?php }} ?>
    </tbody>
  </table>
  <a href="vue-consultation-profil.php" type="button">consulter mon profil</a>
  <br>
  <a href="vue-liste-ateliers.php" type="button">acceder a la liste des ateliers</a>

</body>