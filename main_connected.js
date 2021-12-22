$(document).ready(function(){
function confirmSuppr(){
  return confirm("Êtes-vous sur de vouloir supprimer cette évenement?");
}
function afficheCarteDate(){
    var k = new Date ($(this).attr("data-date"));
    let titreDate = "<h4>"+nomCompletJour[k.getDay()]+" "+k.getDate()+" "+nomMois[k.getMonth()]+" "+k.getFullYear();
    $("#carteDate").css("display","block");
    $("#titreDate").html(titreDate);
    console.log(verifInscri);
    if(verifInscri){
      $("#carteDate").append("<div id='contentCarte'>");
      var contenuDate = " ";
      for(k=0;k<dateTab.length;k++){
        if (dateTab[k]["dateDebut"]==$(this).attr("data-date")){
          if(dateTab[k]["dateFin"]==null){
            contenuDate += "<p class='dateEvent'>Aujourd'hui";
            if(dateTab[k]["heureDebut"]!=null){
              if(dateTab[k]["heureFin"]!=null){
                contenuDate += " de <i>"+dateTab[k]["heureDebut"]+"</i> à <i>"+dateTab[k]["heureFin"]+"</i>";
              }
              else{
                contenuDate += " à <i>"+dateTab[k]["heureDebut"]+"</i>";
              }
            }
          }
          else{
            contenuDate += "<p class='dateEvent'> Du "+dateTab[k]["dateDebut"];
            if(dateTab[k]["heureDebut"]!=null){
              contenuDate += " à <i>"+dateTab[k]["heureDebut"]+"</i>"
            }
            contenuDate += " Au "+dateTab[k]["dateDebut"];
            if(dateTab[k]["heureFin"]!=null){
              contenuDate += " à <i>"+dateTab[k]["heureFin"]+"</i>";
            }
          }
          contenuDate += "</p><div class='event'><p>"+dateTab[k]["content"]+"</p>";
          contenuDate += "<form method='post' action='supprimeAgenda.php' onSubmit='return confirm(\"Êtes-vous sur de vouloir supprimer cette évenement?\")'><input type='hidden' name='id' value='"+dateTab[k]["id"]+"'/> <input type='submit' value='Supprimer'/></form></div>";
        }
      }
      $("#contentCarte").append("<div id='eventDate'><h5>Votre agenda</h5>");
      console.log(contenuDate);
      if(contenuDate == " "){
        $("#eventDate").append("Aucun évenement n'est prévu pour cette date </div>");
     }
     else{
       $("#eventDate").append(contenuDate+"</div>");
     }
      $("#contentCarte").append("<div id='formAjout'><h5>Ajouter un évenement</h5>");
      $("#formAjout").append("<form id='formA' method='post' action='ajoutAgenda.php'>");
      $("#formA").append("<textarea style='resize:none' cols='50' rows='4' name='content' id='content' maxlength='200' placeholder='Votre mémo ... (200 caractères max)' required></textarea><br/>");
      $("#formA").append("<label for='dateDebut'>Du : </label><input type='date' name='dateDebut' readonly value='"+$(this).attr("data-date")+"'/>");
      $("#formA").append("<label for='heureDebut'>  À : </label><input type='time' name='heureDebut'><br/>");
      $("#formA").append("<label for='dateFin'> Au : </label><input type='date' name='dateFin' value='"+$(this).attr("data-date")+"'/>");
      $("#formA").append("<label for='heureFin'>  À : </label><input type='time' name='heureFin'><br/>");
      $("#formA").append("<input type='hidden' name='date' value='"+$(this).attr("data-date")+"'/>");
      $("#formA").append("<input type='submit' value='Enregistrer'/>");
    }else{
      $("#carteDate").append("<div id='rappelInscri'><b>Connectez-vous pour pouvoir utiliser l'agenda</b><p>Vous n'êtes pas encore inscrit ? <a href='inscription.php'>Cliquez ici<a/></div>");
    }
    $("#cache").css("display","block");
    $("#cache").animate({
      opacity:0.5
    },{duration :500, queue: false });
    $("#carteDate").animate({
      top:0
    },{duration :500, queue: false });

    $("#croix").on("click",function(){
      $("#carteDate").animate({
        top:"200%"
      },{duration :500, queue: false });
      $("#cache").animate({
        opacity:0
      },{duration :500, queue: false });
      setTimeout(function(){
        $("#cache").delay(500).css("display","none");
        $("#contentCarte").empty();
        $("#contentCarte").remove();
        $("#rappelInscri").remove();},500);

    });

  };
  $("#calendrier").on("click","td",afficheCarteDate);

});
