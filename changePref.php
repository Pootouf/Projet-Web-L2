<?php session_start();
$ferie=$_POST["hexa_ferie"];
$samedi=$_POST["hexa_samedi"];
$dimanche=$_POST["hexa_dimanche"];
$vide=$_POST["hexa_vide"];
$nb_next=$_POST["next_event_nb"];
if(isset($_POST["bold"])){
  $bold=1;
}
else{
  $bold=0;
}
if(isset($_POST["underlined"])){
  $underline=1;
}
else{
  $underline=0;
}
$event=$_POST["hexa_event"];
try {
  $dsn = "mysql:host=localhost;dbname=calendrier"; // machin lehucrb
  $connexion = new PDO($dsn, "root", ""); //lehucrob 04072001
  }
catch(PDOException $e) {
  // Erreur de connexion à la bdd
  $_SESSION["retour"] = "serv";
  header( "Location: main.php" );
  }

  $encodage="SET NAMES utf8";
  $req1=$connexion->query($encodage);
  $req1->execute();
  unset($req1);

  $encodage="SET CHARACTER SET utf8";
  $req2=$connexion->query($encodage);
  $req2->execute();
  unset($req1);


  $query="UPDATE  preferences SET coul_ferie=?, coul_samedi=?, coul_dimanche=?,coul_vide=?, event_underlined=?,event_bolded=?,coul_event=?, nbProchainsEvents=? WHERE pseudo=?";
  $result = $connexion->prepare($query);
  $result->execute(array($ferie,$samedi,$dimanche,$vide,$underline,$bold,$event,$nb_next,$_SESSION["pseudo"]));
  unset($result);
  $connexion=null;
  //Retour à la page d'accueil avec le compte déjà connecté
  $_SESSION["retour"] = "maj";
  header( "Location: main.php" );
?>
