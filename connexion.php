<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
        <title>Connexion</title>
        <meta charset ="utf-8" />
        <!-- balise de script -->
        <script src="main.js"></script>
        <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="inscri_connex.css" />
    </head>

    <body>
      <header>
        <div id = "heure"></div>
        <h1><a href="main.php">Calendrier en ligne</a></h1>
        <div id="inscri_connex">
        <?php
        //SI L'UTILISATEUR EST CONNECTE
        if (isset($pseudo)){
         echo "<a href='compte.php' id='pseudo'>$pseudo</a>
         <a href='deconnexion.php' class='id_bouton'>Déconnexion</a>"
         ;

         //SINON
         }
         else{echo"
         <a href='inscription.php' class='id_bouton'>Inscription</a>
         <a href='connexion.php' class='id_bouton'>Connexion</a>";
         }
         ?>
      </div>
    </header>
    <script>horloge();
    setInterval(horloge, 1000);</script>

      <div id="champSaisie">

          <form action="verifConnexion.php" method="post">

          <h2>Connexion</h2>

          <label for="id">Identifiant ou adresse email :</label><br/>
              <input type="text" name="id" id="id" required/><br />

          <label for="mdp">Mot de passe :</label><br />

              <input type="password" name="mdp" id="mdp" required/><br />
              <p class="lien">Mot de passe oublié ? <a href="oublimdp.php">Cliquez ici</a></p>

          <input type="submit" id="bouton" value="Confirmer" />
          </form>
          <p class="lien">Pas encore inscrit ? <a href="inscription.php">Cliquez ici</a></p>
              <!-- MESSAGE D'ERREUR -->
            </div>
              <?php
              if (isset($_SESSION["erreur"])){
                  echo"<div id='msgerreur'><p><b>Erreur</b><br/><br/>";
                  switch ($_SESSION["erreur"] ) {
                      case "info" : echo"Identifiant ou mot de passe incorrect"; break;
                      case "serv" : echo"Problème de connexion avec le serveur. veuillez réessayer"; break;
                  }
                  echo"</div>";
              $_SESSION=array();
              }
              ?>
              <?php
            if (isset($_SESSION["erreur"])){
                echo "<div id='msgerreur'>";
                switch ($_SESSION["erreur"]){
                    case "invalid" : echo"L'adresse email entrée est invalide"; break;
                    case "serv" : echo"Problème de connexion avec le serveur. veuillez réessayer"; break;
                    case "confirm" : echo"Les mots de passes entrées ne sont pas similaires "; break;
                    case "exist" : echo"Ces informations sont déjà utilisées par un autre compte : ";
                                    if (!empty($_SESSION["check1"])){
                                        echo $_SESSION["check1"];
                                        if (!empty($_SESSION["check2"])){
                                            echo ', ';
                                        }
                                    }
                                    if (!empty($_SESSION["check2"])){
                                        echo $_SESSION["check2"];
                                    }

                }
            echo"</p></div>";
            $_SESSION=array();
            }
            ?>






      		</div>




      </body>
      </html>
