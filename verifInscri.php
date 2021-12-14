<?php session_start();
// A FINIR ----------> EN CAS DE DOUBLE COORDONNEES SIMILAIRES
$pseudo=$_POST['pseudo'];
$mail=$_POST['mail'];
$mdp=$_POST['mdp'];
$mdpc=$_POST['mdpc'];

//BUT DU SCRIPT : VERIFIE SI LE MAIL OU LE PSEUDO SONT DEJA ASSOCIES A UN COMPTE, SINON ON CREER UN NOUVEAU COMPTE

 //On vérifie si le mot de passe a bien été confirmé
if ($mdp==$mdpc)
    {
        //On vérifie si l'adresse email est bien rédigé
        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            //On vérifie si on se connecte bien à la bdd
            try {
              $dsn = "mysql:host=localhost;dbname=calendrier"; // machin lehucrb
              $connexion = new PDO($dsn, "root", ""); //lehucrob 04072001
              }
            catch(PDOException $e) {
              // Erreur de connexion à la bdd
              $_SESSION["erreur"] = "serv";
              header( "Location: inscription.php" );
              }
                //encodage utf8
                $encodage="SET NAMES utf8";
                $req1=$connexion->query($encodage);
                $req1->execute();
                unset($req1);

                //Recherche si le pseudo entré existe déjà
                $req2 = "SELECT * FROM comptes WHERE pseudo= ?";
                $result = $connexion->prepare($req2);
                $result->execute(array($pseudo));
                $data1 = $result->fetch();
                unset($result);

                //Recherche si le mail entré existe déjà
                $req3 = "SELECT * FROM comptes WHERE email=?";
                $result = $connexion->prepare($req3);
                $result->execute(array($mail));
                $data2 = $result->fetch();
                unset($result);

                //Si le mail et le pseudo n'ont pas déjà été utilisé, on crée le compte
                if (empty($data1) && empty($data2)){
                    $query="INSERT INTO comptes VALUES(?,?,?)";
                    $result = $connexion->prepare($query);
                    $result->execute(array($pseudo,password_hash($mdp,PASSWORD_BCRYPT),$mail));
                    unset($result);
                    $connexion=null;
                    //Retour à la page d'accueil avec le compte déjà connecté
                    $_SESSION["pseudo"] = $pseudo;
                    header("Location: main.php");
                }

                // Partie erreur : on détecte où est le problème et on renvoie l'utilisateur à la page d'inscription
                // avec un message selon l'erreur

                // Le mail ou le pseudo sont déjà associés à un compte
                else{
                    $_SESSION["erreur"] = "exist";
                    if (!empty($data1)){
                        $_SESSION["check1"] = "Identifiant";
                        }
                    if (!empty($data2)){
                        $_SESSION["check2"] = "Adresse email";
                        }
                        $connexion=null;
                    header( "Location: inscription.php" );
                    }
          }

          // Mail invalide
          else{
              $_SESSION["erreur"] = "invalid";
              header( "Location: inscription.php" );
          }

    }

    //Mot de passe mal confirmé
    else{
        $_SESSION["erreur"] = "confirm";
        header( "Location: inscription.php" );
    }

?>
