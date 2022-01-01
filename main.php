<!DOCTYPE html>
<?php session_start();
if (isset($_SESSION["pseudo"])){
    $pseudo=$_SESSION["pseudo"];
    $ajout=true;
    try {
      $dsn = "mysql:host=localhost;dbname=calendrier"; // machin lehucrb
      $connexion = new PDO($dsn, "root", ""); //lehucrob 04072001
      }
    catch(PDOException $e) {
      // Erreur de connexion à la bdd
      exit("Erreur".$e->getMessage());
      }
      $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
      $encodage="SET NAMES utf8";
      $req1=$connexion->query($encodage);
      $req1->execute();
      unset($req1);

      $req = "SELECT id,titre,lieu,dateDebut,dateFin,heureDebut,heureFin,content,surPlusieursJours FROM agenda WHERE pseudo=? ORDER BY dateDebut ASC, heureDebut ASC";
      $result = $connexion->prepare($req);
      $result->execute(array($pseudo));
      $data = $result->fetchAll(PDO::FETCH_ASSOC);
      $dateTab=json_encode($data);
      unset($req);

      $req2 = "SELECT * FROM preferences WHERE pseudo=?";
      $result2 = $connexion->prepare($req2);
      $result2->execute(array($pseudo));
      $pref= $result2->fetchAll(PDO::FETCH_ASSOC);
      unset($req2);

      $req3 = "SELECT id,titre,lieu,dateDebut,dateFin,heureDebut,heureFin,content,surPlusieursJours FROM agenda WHERE pseudo=? AND dateDebut>curdate()  ORDER BY dateDebut ASC, heureDebut ASC LIMIT ?";
      $result3 = $connexion->prepare($req3);
      $result3->execute(array($pseudo,$pref[0]["nbProchainsEvents"]));
      $data = $result3->fetchAll(PDO::FETCH_ASSOC);
      $nextTab=json_encode($data);
      unset($req3);

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
      <div id="cache"></div>
      <header>
        <div id ="heure"></div>
        <h1><a href="main.php">Calendrier en ligne</a></h1>
        <div id="inscri_connex">
        <?php
        //SI L'UTILISATEUR EST CONNECTE
        if (isset($pseudo)){
         echo "<a id='pseudo'>$pseudo</a>
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
    <h2 id="titreAgenda" class="titreOnglet">Agenda</h2>
    <div id="agenda" class="onglet">
      <h2>Vos prochains évenements</h2>
    </div>

    <h2 id="titrePreferences" class="titreOnglet">Préférences</h2>
    <div id="preferences" class="onglet">
        <h2>Couleurs</h2>
        <form action="changePref.php" method="post">
        <div class="pref">
          <div class="color_changer" id="color_ferie">
            <label for="color_ferie">Jour Feriés</label>
            <div class="preview_color"></div>
            <input class="r_number" type="number" min="0" max="255"  /><br/>
            <input class="g_number" type="number" min="0" max="255" /><br/>
            <input class="b_number" type="number" min="0" max="255" />
            <input type="hidden" name="hexa_ferie"/>
          </div>
          <div class="color_changer" id="color_samedi">
            <label for="color_samedi">Samedis</label>
            <div class="preview_color"></div>
            <input class="r_number" type="number" min="0" max="255" /><br/>
            <input class="g_number" type="number" min="0" max="255"  /><br/>
            <input class="b_number" type="number" min="0" max="255"  />
            <input type="hidden" name="hexa_samedi"/>
          </div>
          <div class="color_changer" id="color_dimanche">
            <label for="color_dimanche">Dimanches</label>
            <div class="preview_color"></div>
            <input class="r_number" type="number" min="0" max="255"  /><br/>
            <input class="g_number" type="number" min="0" max="255"  /><br/>
            <input class="b_number" type="number" min="0" max="255"  />
            <input type="hidden" name="hexa_dimanche"/>
          </div>
          <div class="color_changer" id="color_vide">
            <label for="color_vide">Cases vides</label>
            <div class="preview_color"></div>
            <input class="r_number" type="number" min="0" max="255"  /><br/>
            <input class="g_number" type="number" min="0" max="255"  /><br/>
            <input class="b_number" type="number" min="0" max="255"  />
            <input type="hidden" name="hexa_vide"/>
          </div>
        </div>
        <hr/>
        <h2>Affichage des évenements</h2>
        <div class="pref">
          <p id="event_preview" class="get_event">0 1 2 3 4 5 6 7 8 9</p>
          <div>
            <input type="checkbox" class="check" name="underlined" value="true"/>
            <label for="underlined">Souligné</label>
          </div>
          <div>
            <input type="checkbox" class="check" name="bold" value="true"/>
            <label for="bold">Gras</label>
        </div>
          <div class="color_changer" id="color_event">
            <label for="color_event">Couleur</label><br/>
            <input class="r_number" type="number" min="0" max="255"  /><br/>
            <input class="g_number" type="number" min="0" max="255"  /><br/>
            <input class="b_number" type="number" min="0" max="255"  />
            <input type="hidden" name="hexa_event"/>
          </div>
        </div>
      <div id="next_event_nb">
        <label for="color_event">Nombres de prochains évenements affichés : </label>
        <input id="nb_next" type="number" name="next_event_nb"/>
      </div>
      <br/>
        <input type="submit" value="Enregistrer"/>
      </form>
    </div>


    <div id="nav_calendrier">
      Mois:
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

      Année:<input type="number" id="an" required>

      <br/><input type="button" value="Confirmer" id="nouveaumois">
    </div>
     <div id="date_calendrier">
    <input type="button" value="<<" id="previousMonth">
    <div id= "dateMois"></div>
     <input type="button" value=">>" id="nextMonth">
   </div>
      <div id= "calendrier"></div>
      <script>
      var verifInscri = false;
      var dateTab = <?php if (isset($pseudo)){echo $dateTab;}else{echo "[]";}?>;
      console.log(dateTab);

      var pref = <?php if (isset($pseudo)){echo json_encode($pref);}else{echo "[]";}?>;
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
        var nextTab = <?php
        if (isset($pseudo)){echo $nextTab;}else{echo "[]";}
         ?>;
      </script>
      <div id="carteDate"><img id="croix" src="img/croix.png"/><h4 id="titreDate"></h4>
        <?php if(isset($_SESSION["pseudo"])){
                  echo "<script> verifInscri=true;</script>";
        }?></div>
        <?php
          if(isset($_SESSION["retour"])){
            if($_SESSION["retour"]=="serv"){
              echo"<script>alert('Erreur durant la connexion au serveur. Veuillez réessayer.');</script>";
              unset($_SESSION["retour"]);
            }
            else if($_SESSION["retour"]=="ajout"){
              echo"<script>alert(\"L'évenement a bien été ajouté à votre agenda\");</script>";
              unset($_SESSION["retour"]);
            }
            else if($_SESSION["retour"]=="maj"){
              echo"<script>alert('Vos préférences ont bien été mis à jour');</script>";
              unset($_SESSION["retour"]);
            }
          }?>
      <div id="form_modif" class='form'>
        <img id="croix" src="img/croix.png"/>
        <h5>Modifier un évènement</h5>
        <form id='formM' method='post' action='modifAgenda.php'>
        <label for='titre'> Titre : </label><input type='text' name='titre' maxlength='50' required id="titreM"><br/>
        <label for='lieu'> Lieu : </label><input type='text' name='lieu'  maxlength='30' id="lieuM"><br/>
        <textarea style='resize:none' cols='50' rows='4' name='content' id="contentM" maxlength='200' placeholder='Votre mémo ... (200 caractères max)' required></textarea><br/>
        <label for='dateDebut'>Du : </label><input type='date' id="dateDM" name='dateDebut'/>
        <label for='heureDebut'>  À : </label><input type='time' id="heureDM" name='heureDebut'><br/>
        <label for='dateFin'> Au : </label><input type='date' id="dateFM" name='dateFin'/>
        <label for='heureFin'>  À : </label><input type='time' id="heureFM" name='heureFin'><br/>
        <input type='hidden' name='id' id="hiddenM"/>
        <input type='submit' value='Enregistrer'/>
      </form>
      </div>
      <script src="main_connected.js"></script>

    </body>

</html>
