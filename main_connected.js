$(document).ready(function(){

  if(!verifInscri){
    $(".onglet").css("display","none");
    $(".titreOnglet").css("display","none");
  }

function afficheFormModif(){
  $("#cache").css("z-index","3");
  $("#form_modif").css("display","block");
  let tabModif = JSON.parse($(this).val());
  $("#titreM").val(tabModif["titre"]);
  $("#lieuM").val(tabModif["lieu"]);
  $("#contentM").html(tabModif["content"]);
  $("#dateDM").val(tabModif["dateDebut"]);
  $("#dateFM").val(tabModif["dateFin"]);
  $("#heureDM").val(tabModif["heureDebut"]);
  $("#heureFM").val(tabModif["heureFin"]);
  $("#hiddenM").val(tabModif["id"]);
  $("#form_modif > img").click(function(){
      $("#form_modif").css("display","none");
      $("#cache").css("z-index","0");
  })
}

function display_events(tab,d,mode){
  var contenuDate = " ";
  for(k=0;k<tab.length;k++){
    if ((mode=="local" &&(tab[k]["dateDebut"]==d || tab[k]["dateDebut"]<=d&&tab[k]["dateFin"]>=d)) || mode=="next"){
      contenuDate += "<div class='event'> <b class='titreEvent'>"+tab[k]["titre"]+"</b><br/>";
      if(tab[k]["dateFin"]==null){
        contenuDate += "<p class='dateEvent'>Aujourd'hui";
        if(tab[k]["heureDebut"]!=null){
          if(tab[k]["heureFin"]!=null){
            contenuDate += " de <i>"+tab[k]["heureDebut"].slice(0,-3)+"</i> à <i>"+tab[k]["heureFin"].slice(0,-3)+"</i></p>";
          }
          else{
            contenuDate += " à <i>"+tab[k]["heureDebut"].slice(0,-3)+"</i></p>";
          }
        }
      }
      else{
        contenuDate += "<p class='dateEvent'> Du "+tab[k]["dateDebut"];
        if(tab[k]["heureDebut"]!=null){
          contenuDate += " à <i>"+tab[k]["heureDebut"].slice(0,-3)+"</i>";
        }
        contenuDate += " au "+tab[k]["dateFin"];
        if(tab[k]["heureFin"]!=null){
          contenuDate += " à <i>"+(tab[k]["heureFin"].slice(0,-3))+"</i>";
        }
      }
      if(tab[k]["lieu"]!=null){
        contenuDate += "<br/>Lieu : <i>"+tab[k]["lieu"]+"</i>";
      }
      contenuDate += "</p><p class='content_event'>"+tab[k]["content"]+"</p>";
      contenuDate += "<form method='post' action='supprimeAgenda.php' onSubmit='return confirm(\"Êtes-vous sur de vouloir supprimer cette évenement?\")'><input type='hidden' name='id' value='"+dateTab[k]["id"]+"'/> <input type='submit' value='Supprimer'/></form>";
      contenuDate += "<button class='lienModif' value='"+JSON.stringify(tab[k])+"'>Modifier</button></div>";
    }
  }
  return contenuDate;
}

console.log(nextTab);
var nextEvents=display_events(nextTab,null,"next");
if(nextEvents==" "){
  $("#agenda").append("<p id='no_next'>Vous n'avez pas d'évenements à venir</p>");
}
else{
  $("#agenda").append("<div id='liste_nextEvents'></div>");
  $("#liste_nextEvents").append(nextEvents);
  $(".lienModif").click(afficheFormModif);
}

function agenda_positionOver(){
    $("#titreAgenda").animate({
      right:"1%"
    },{duration:500});
    $("#agenda").animate({
      right:"-38%"
    },{duration:500});
  }

function agenda_positionInitiale(){
    $("#titreAgenda").animate({
      right:"-1%"
    },{duration:500,queue:false});
    $("#agenda").animate({
      right:"-40%"
    },{duration:500,queue:false});
  }

  function preferences_positionOver(){
      $("#titrePreferences").animate({
        left:"1%"
      },{duration:500});
      $("#preferences").animate({
        left:"-38%"
      },{duration:500});
    }

  function preferences_positionInitiale(){
      $("#titrePreferences").animate({
        left:"-1%"
      },{duration:500,queue:false});
      $("#preferences").animate({
        left:"-40%"
      },{duration:500,queue:false});
    }


function ouvrir_onglet(){
    $(this).unbind("mouseenter mouseleave");
    $(this).unbind("click");
    $("#cache").css("display","block");
    if($(this).is($("#titreAgenda"))){
      $("#titreAgenda").animate({
        right:"39%"
      },{duration:500,queue:false});
      $("#agenda").animate({
        right:"0"
      },{duration:500,queue:false});
      $("#titreAgenda").on("click",fermer_onglet);
    }
    else{
      $("#titrePreferences").animate({
        left:"39%"
      },{duration:500,queue:false});
      $("#preferences").animate({
        left:"0"
      },{duration:500,queue:false});
    }
    $("#cache").animate({
      opacity:0.5
    },{duration :500, queue: false });
    $("#titrePreferences").on("click",fermer_onglet);
  }

function fermer_onglet(){
      $(this).unbind("click");
      $("#cache").animate({
        opacity:0
      },{duration :500, queue: false });
      setTimeout(function(){
      $("#cache").css("display","none");
    },500);
    if($(this).is("#titreAgenda")){
      agenda_positionInitiale();
      $(this).mouseenter(agenda_positionOver);
      $(this).mouseleave(agenda_positionInitiale);

    }
    else{
      preferences_positionInitiale();
      $(this).mouseenter(preferences_positionOver);
      $(this).mouseleave(preferences_positionInitiale);
    }
    $(this).on("click",ouvrir_onglet);
  }




$("#titreAgenda").mouseenter(agenda_positionOver);
$("#titreAgenda").mouseleave(agenda_positionInitiale);
$("#titreAgenda").on("click",ouvrir_onglet);

$("#titrePreferences").mouseenter(preferences_positionOver);
$("#titrePreferences").mouseleave(preferences_positionInitiale);
$("#titrePreferences").on("click",ouvrir_onglet);




function valueRGBToHexa(c) {
  var hexa = c.toString(16);
  return hexa.length == 1 ? "0" + hexa : hexa;
}

function getValRGB(str) {
  return str.substring(str.indexOf('(') +1, str.length -1).split(', ');
}

function rgbToHexa(r, g, b) {
  return "#" + valueRGBToHexa(parseInt(r)) + valueRGBToHexa(parseInt(g)) + valueRGBToHexa(parseInt(b));
}

function setupInputColor(c,i){
  let tabRGB = getValRGB(c.css("background-color"));
  i.find(".preview_color").css("background-color",c.css("background-color"));
  i.find(".r_number").val(parseInt(tabRGB[0]));
  i.find(".g_number").val(parseInt(tabRGB[1]));
  i.find(".b_number").val(parseInt(tabRGB[2]));
  i.find("input[type='hidden']").val(rgbToHexa(tabRGB[0],tabRGB[1],tabRGB[2]));

}

if (verifInscri){
  if(pref[0]["coul_samedi"]!=null){
    $(".samedi").css("background-color",pref[0]["coul_samedi"]);
  }
  setupInputColor($(".samedi"),$("#color_samedi"));

  if(pref[0]["coul_dimanche"]!=null){
    $(".dimanche").css("background-color",pref[0]["coul_dimanche"]);
  }
  setupInputColor($(".dimanche"),$("#color_dimanche"));

  if(pref[0]["coul_ferie"]!=null){
    $(".ferie").css("background-color",pref[0]["coul_ferie"]);
  }
  setupInputColor($(".ferie"),$("#color_ferie"));

  if(pref[0]["coul_vide"]!=null){
    $(".vide").css("background-color",pref[0]["coul_vide"]);
  }
$("#nb_next").val(pref[0]["nbProchainsEvents"]);

setupInputColor($(".vide"),$("#color_vide"));



  $(".color_changer > input[type='number']").on("input",function(){
      if ($(this).val()>255){
        $(this).val(255);
      }
      else if ($(this).val()<0) {
        $(this).val(0);
      }

      let k = rgbToHexa($(this).parent().find(".r_number").val(),$(this).parent().find(".g_number").val(),$(this).parent().find(".b_number").val());
      $(this).parent().find(".preview_color").css("background-color",k);
      $(this).parent().find("input[type='hidden']").val(k);
  });

  $("input[name='underlined']").on("input",function(){
    if($(this).is(":checked")){
      $("#event_preview").css("text-decoration","underline");
    }
    else{
      $("#event_preview").css("text-decoration","none");
    }
  });

  $("input[name='bold']").on("input",function(){
    if($(this).is(":checked")){
      $("#event_preview").css("font-weight","bold");
    }
    else{
      $("#event_preview").css("font-weight","normal");
    }
  });


  if(pref[0]["coul_event"]!=null){
    $(".get_event").css("color",pref[0]["coul_event"]);
  }
  if(pref[0]["event_underlined"]==1){
    $(".get_event").css("text-decoration","underline");
    $("input[name='underlined']").attr("checked",true);
    $("#event_preview").css("text-decoration","underline");
  }
  if(pref[0]["event_bolded"]==1){
    $(".get_event").css("font-weight","bold");
    $("input[name='bold']").attr("checked",true);
    $("#event_preview").css("font-weight","bold");
  }


    var tabEventRGB = getValRGB($(".get_event").css("color"));
    $("#event_preview").css("color",$(".get_event").css("color"));
    $("#color_event").find(".r_number").val(parseInt(tabEventRGB[0]));
    $("#color_event").find(".g_number").val(parseInt(tabEventRGB[1]));
    $("#color_event").find(".b_number").val(parseInt(tabEventRGB[2]));
    $("#color_event").find("input[type='hidden']").val(rgbToHexa(tabEventRGB[0],tabEventRGB[1],tabEventRGB[2]));


    $("#color_event > input[type='number']").on("input",function(){
        if ($(this).val()>255){
          $(this).val(255);
        }
        else if ($(this).val()<0) {
          $(this).val(0);
        }

        let k = rgbToHexa($(this).parent().find(".r_number").val(),$(this).parent().find(".g_number").val(),$(this).parent().find(".b_number").val());
        $("#event_preview").css("color",k);
        $(this).parent().find("input[type='hidden']").val(k);
    });
}





function confirmSuppr(){
  return confirm("Êtes-vous sur de vouloir supprimer cette évenement?");
}




function afficheCarteDate(){
  if(!($(this).hasClass("vide"))&&!($(this).hasClass("nomJour"))){
    var k = new Date ($(this).attr("data-date"));
    let titreDate = "<h4>"+nomCompletJour[k.getDay()]+" "+k.getDate()+" "+nomMois[k.getMonth()]+" "+k.getFullYear();
    $("#carteDate").css("display","block");
    $("#titreDate").html(titreDate);
    console.log(verifInscri);
    if(verifInscri){
      $("#carteDate").append("<div id='contentCarte'>");
      $("#contentCarte").append("<div id='eventsDate' class='container_carte'><h5>Évenements du jour</h5>");
      let liste=display_events(dateTab,$(this).attr("data-date"),"local");
      if(liste == " "){
        $("#eventsDate").append("Aucun évenement n'est prévu pour cette date </div></div>");
     }
     else{
       $("#eventsDate").append("<div id='liste_events'>");
       $("#liste_events").append(liste+"</div></div>");
       $(".lienModif").click(afficheFormModif);
     }
      $("#contentCarte").append("<div id='formAjout' class='container_carte form'><h5>Ajouter un évenement</h5>");
      $("#formAjout").append("<form id='formA' method='post' action='ajoutAgenda.php'>");
      $("#formA").append("<label for='titre'> Titre : </label><input type='text' name='titre' maxlength='50' required><br/>");
      $("#formA").append("<label for='lieu'> Lieu : </label><input type='text' name='lieu'  maxlength='30'><br/>");
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
        $("#cache").css("display","none");
        $("#contentCarte").empty();
        $("#contentCarte").remove();
        $("#rappelInscri").remove();},500);

    });
  }
}
  $("#calendrier").on("click","td",afficheCarteDate);

});
