<?php session_start();
$id=$_POST["id"];
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

    $query="DELETE FROM agenda WHERE id=?";
    $result = $connexion->prepare($query);
    $result->execute(array($id));
    print_r($result->errorInfo());
    unset($result);
  $connexion=null;
  //Retour à la page d'accueil avec le compte déjà connecté
  header( "Location: main.php" );
?>
