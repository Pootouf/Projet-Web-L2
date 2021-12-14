<?php session_start();
$mdp = $_POST['mdp'];
$id = $_POST['id'];
// BUT DU SCRIPT: VERIFIER SI LES COORDONNEES ENTRES EXISTENT DANS LA BDD

    //Connexion à la bdd, on vérifie si la connexion se réalise bien.
    try {
      $dsn = "mysql:host=localhost;dbname=calendrier"; // machin lehucrb
      $connexion = new PDO($dsn, "root", ""); //lehucrob 04072001
      }
    catch(PDOException $e) {
      // Erreur de connexion à la bdd
      $_SESSION["erreur"] = "serv";
      header( "Location: connexion.php" );
      }
        //encodage utf8
        $encodage="SET NAMES utf8";
        $req1=$connexion->query($encodage);
        $req1->execute();
        unset($req1);

        //on cherche si le pseudo ou le mail entré est associé à un compte, et si le mdp entré est associé à ce même compte
        //comme le pseudo et le mail sont uniques (1 seul utilisation peu importe le compte), on ne craint pas les doublon.
        $req = "SELECT pseudo, mdp FROM comptes WHERE pseudo=? OR email=?";
        $result = $connexion->prepare($req);
        $result->execute(array($id,$id));
        $data = $result->fetch(PDO::FETCH_NUM);
        unset($result);
        print_r($data);
        $connexion=null;

        if (password_verify($mdp,$data[1]))
        {
            $_SESSION["pseudo"] = $data[0];
            header( "Location: main.php" );

        }

        // Partie erreur : on détecte où est le problème et on renvoie l'utilisateur à la page d'inscription
        // avec un message selon l'erreur

        // Le pseudo/mail ou le mot de passe sont incorrects
        else {
            $_SESSION["erreur"] = "info";
            header( "Location: connexion.php" );
      }


?>
