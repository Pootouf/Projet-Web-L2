<?php session_start();
$titre=$_POST["titre"];
$lieu=$_POST["lieu"];
if (empty($lieu)){
  $lieu=null;
}
$content=$_POST["content"];
if (empty($_POST["heureDebut"])){
  $_POST["heureDebut"]=null;
}
if (empty($_POST["heureFin"])){
  $_POST["heureFin"]=null;
}
if (empty($_POST["dateFin"]) || $_POST["dateFin"]==$_POST["dateDebut"]){
  $_POST["dateFin"]=null;
  $surPlusieursJours=0;
}
else{
  $surPlusieursJours=1;
}
$heureD=$_POST["heureDebut"];
$heureF=$_POST["heureFin"];
$dateD=$_POST["dateDebut"];
$dateF=$_POST["dateFin"];

if($surPlusieursJours==0&&$heureD==null&&$heureF!=null){
  $heureD=$heureF;
  $heureF=null;
}

if($surPlusieursJours==1&&$dateD>$dateF){
  $mem=$dateF;
  $dateF=$dateD;
  $dateD=$mem;
}

print_r($_POST);
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



  $query="INSERT INTO agenda (pseudo,titre,lieu,dateDebut,dateFin,heureDebut,heureFin,content,surPlusieursJours) VALUES(?,?,?,?,?,?,?,?,?)";
  $result = $connexion->prepare($query);
  $result->execute(array($_SESSION["pseudo"],$titre,$lieu,$dateD,$dateF,$heureD,$heureF,$content,$surPlusieursJours));
  unset($result);
  $connexion=null;
  //Retour à la page d'accueil avec le compte déjà connecté
  $_SESSION["retour"] = "ajout";
  header( "Location: main.php" );
?>
