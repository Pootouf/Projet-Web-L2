<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
        <title>Inscription</title>
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

              <form action="verifInscri.php" method="post">
        			<h2>Inscription</h2>

        			<label for="pseudo">Identifiant</label><br/>
        				<input type="text" name="pseudo" maxlength="30" id="pseudo" required/><br/>

                <label for="mail">Adresse email</label><br/>

                <input type="email" name="mail" maxlength="100" id="mail" required/><br/>

        			<label for="mdp">Mot de passe</label><br/>

        				<input type="password" name="mdp" maxlength="25" id="mdp" required/><br/>

        			<label for="mdpc">Confirmer votre mot de passe</label><br/>

        				<input type="password" name="mdpc" maxlength="25" id="mdpc" required/><br/>
                <input type="submit" id="bouton" value="S'inscrire"/>
                </form>
                <i class="lien">Vous êtes déjà inscrit ? <a href="connexion.php"><u>Cliquez ici</u></a></i>
            </div>

                <?php
              if (isset($_SESSION["erreur"])){
                  echo "<div id='msgerreur'><p><b>Erreur</b><br/><br/>";
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





                  <!--LIEN CONNEXION.PHP -->




      		</div>




      </body>
      </html>
