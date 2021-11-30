<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
        <title>Connexion</title>
        <meta charset ="utf-8" />
        <!-- balise de script -->
        <script src="main.js"></script>
        <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="main.css" />
    </head>

    <body>
      <div id="champSaisie">

          <form action="verifConnexion.php" method="post">

          <h2>Connexion</h2>

          <label for="id">Identifiant ou adresse email :</label>
              <input type="text" name="id" id="id" required/><br />

          <label for="mdp">Mot de passe :</label>

              <input type="password" name="mdp" id="mdp" required/><br />
              <p class="lien">Mot de passe oublié ? <a href="oublimdp.php">Cliquez ici</a></p>

          <input type="submit" id="bouton" value="Confirmer" />
          </form>
          <p class="lien">Pas encore inscrit ? <a href="inscription.php">Cliquez ici</a></p>
              <!-- MESSAGE D'ERREUR -->

              <?php
              if (isset($_SESSION["erreur"])){
                  echo"<div id='msgerreur'>";
                  switch ($_SESSION["erreur"] ) {
                      case "info" : echo"<p>Identifiant ou mot de passe incorrect</p>"; break;
                      case "serv" : echo"<p>Problème de connexion avec le serveur. veuillez réessayer</p>"; break;
                  }
                  echo"</div>";
              $_SESSION=array();
              }
              ?>






      		</div>




      </body>
      </html>
