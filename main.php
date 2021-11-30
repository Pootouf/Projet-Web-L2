<!DOCTYPE html>
<?php session_start();
if (isset($_SESSION["pseudo"])){
    $pseudo=$_SESSION["pseudo"];
    $ajout=true;
}
?>
<html>

<head>
        <title>Projet Web</title>
        <meta charset ="utf-8" />
        <!-- balise de script -->
        <script src="main.js"></script>
        <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="main.css" />
    </head>

    <body>
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
      <div id = "heure"></div>

      <input type="button" value="<<" id="previousMonth">
      <input type="button" value=">>" id="nextMonth">
      <br/>
      <br/>
      <br/>
      <br/>

      Changement de mois:
      <select name="mois" id = "mois">
        <option value="0">Janvier</option>
        <option value="1">Février</option>
        <option value="2">Mars</option>
        <option value="3">Avril</option>
        <option value="4">Mai</option>
        <option value="5">Juin</option>
        <option value="6">Juillet</option>
        <option value="7">Aout</option>
        <option value="8">Septembre</option>
        <option value="9">Octobre</option>
        <option value="10">Novembre</option>
        <option value="11">Décembre</option>
      </select>
      <br/>
      <br/>
      Changement d'année:<input type="number" id="an" required>
      <br/>
      <br/>
      <input type="button" value="Confirmer" id="nouveaumois">

      <div id= "dateMois"></div>
      <div id= "calendrier"></div>
      <script>
        horloge();
        setInterval(horloge, 1000);
        var c = new calendrier();
        c.majCalendrier("calendrier", "dateMois");
        var previousMonth = document.getElementById("previousMonth");
        previousMonth.onclick = function(){c.changeMois(false, "calendrier", "dateMois");}
        var nextMonth = document.getElementById("nextMonth");
        nextMonth.onclick = function(){c.changeMois(true, "calendrier", "dateMois");};
        var nouveaumois = document.getElementById("nouveaumois");
        nouveaumois.onclick = function(){
          let mois = document.getElementById("mois");
          mois = mois.value;
          let annee = document.getElementById("an");
          annee = annee.value;
          c.changeAnnee("calendrier", "dateMois", mois, annee);
        };
      </script>
    </body>

</html>
