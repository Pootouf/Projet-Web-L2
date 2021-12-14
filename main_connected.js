$(document).ready(function(){
function afficheCarteDate(){
    var k = new Date ($(this).attr("data-date"));
    let titreDate = "<h4>"+nomCompletJour[k.getDay()-1]+" "+k.getDate()+" "+nomMois[k.getMonth()]+" "+k.getFullYear();
    $("#carteDate").css("display","block");
    $("#titreDate").html(titreDate);
    console.log(verifInscri);
    if(verifInscri){
      var contenuDate = null;
      for(k=0;k<dateTab.length;k++){
        if (dateTab[k]["date"]==$(this).attr("data-date")){
          contenuDate = dateTab[k]["content"];
          break;
        }
      }
      if(contenuDate == null){
       $("#contentCarte").append("<form method='post' action='ajoutAgenda.php'>  <textarea style='resize:none' cols='50' rows='10' name='content' id='content' maxlength='500' placeholder='Votre mémo ... (500 caractères max)'></textarea><input type='hidden' name='date' value='"+$(this).attr("data-date")+"'/><input type='submit' value='Enregistrer'/></form>");
     }
      else{
         $("#contentCarte").append(contenuDate);
      }


    }else{
      $("#contentCarte").append("<b>Connectez-vous pour pouvoir utiliser l'agenda</b><p>Vous n'êtes pas encore inscrit ? <a href='inscription.php'>Cliquez ici<a/>");
    }
    $("#cache").css("display","block");
    $("#cache").animate({
      opacity:0.5
    },{duration :500, queue: false });
    $("#carteDate").animate({
      top:0
    },{duration :500, queue: false });
  };
  $("#calendrier").on("click","td",afficheCarteDate);
});
