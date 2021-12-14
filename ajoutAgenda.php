<?php session_start();
$date=$_POST["date"];
$content=$_POST["content"];
print_r($_POST);
try {
  $dsn = "mysql:host=localhost;dbname=calendrier"; // machin lehucrb
  $connexion = new PDO($dsn, "root", ""); //lehucrob 04072001
  }
catch(PDOException $e) {
  // Erreur de connexion à la bdd
  $_SESSION["erreur"] = "serv";
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


  $query="INSERT INTO agenda VALUES(?,?,?)";
  $result = $connexion->prepare($query);
  $result->execute(array($_SESSION["pseudo"],$date,$content));
  print_r($result->errorInfo());
  unset($result);
  $connexion=null;
  //Retour à la page d'accueil avec le compte déjà connecté
