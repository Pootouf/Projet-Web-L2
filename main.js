function horloge() {
  d = new Date();
  var heure = todayDate(d);
  let div = document.getElementById('heure');
  let text = div.firstChild;
  if(text != null){
    div.removeChild(text);
  }
  let p = document.createElement('p');
  let date = document.createTextNode(heure);
  div.append(p);
  p.append(date);
}

todayDate = function(date){
  return twoInt(date.getHours()) + ":" + twoInt(date.getMinutes()) + ":" + twoInt(date.getSeconds());
}

twoInt = function(n){
  if(n<10){
    return "0" + n.toString();
  }
  return n.toString();
}

Number.prototype.isBi = function(){
  let a = this;
  if(a % 4 != 0){
    return false;
  }else{
    if(a % 100 != 0){
      return true;
    }else{
      if(a % 400 == 0){
        return true;
      }else{
        return false;
      }
    }
  }
}

nbJours = function(m, a){
  m = m+1;
  if(m == 2){
    if(a.isBi()){
      return 29;
    }else{
      return 28;
    }
  }
  if(m == 1 || m==3 || m==5 || m==7 || m==8 || m==10 || m==12){
    return 31;
  }else{
    return 30;
  }
}

var nomMois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
var nomCompletJour = ["Dimanche","Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
function calendrier(){

  this.d = new Date();
  this.nj = nbJours(this.d.getMonth(), this.d.getFullYear());
  this.dateReelle = d;

  this.afficheDate = function(id){
    let div = document.getElementById(id);
    var mois = this.d.getMonth();
    var annee = this.d.getFullYear();
    let ptmp = div.firstChild;
    if(ptmp != null){
      div.removeChild(ptmp);
    }
    let p = document.createElement('p');
    let date = document.createTextNode(nomMois[mois] + " " + annee);
    p.setAttribute("class", "nomMois");
    div.append(p);
    p.append(date);
  }

  this.createCalendrier = function(id){
    let div = document.getElementById(id);
    let tabtmp = div.firstChild;
    if(tabtmp != null){
      div.removeChild(tabtmp);
    }
    let tab = document.createElement('table');
    let tbody = document.createElement('tbody');
    var datetmp = new Date(this.d.getFullYear(), this.d.getMonth(), 1);
    var jour = datetmp.getDay();
    --jour;
    if(jour == -1){
      jour = 6;
    }
    let tr = document.createElement('tr');
    tbody.append(tr);
    var nomJour = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
    for(var i = 0; i< 7; i++){
      let td = document.createElement('td');
      tr.append(td);
      let nom = document.createTextNode(nomJour[i]);
      td.append(nom);
      td.setAttribute("class", "nomJour");
    }
    for(var i = 1; i<=6; i++){
      let tr = document.createElement('tr');
      tbody.append(tr);
      for(var j = 1; j<= 7; j++){
        var dtmp = new Date(this.d.getFullYear(), this.d.getMonth(), j-jour + 7*(i-1));
        let td = document.createElement('td');
        if(7*(i-1) - jour + 1 <= this.nj){
          tr.append(td);
        }
        if((i == 1 && j>= jour+1) || i!= 1){
          let date = document.createTextNode(j-jour + 7*(i-1));
          if(j-jour + 7*(i-1) <= this.nj){
            td.append(date);
            td.dataset.date=dtmp.getFullYear()+'-'+(dtmp.getMonth()+1)+'-'+dtmp.getDate();
          }
        }
        if((j == 6 || j == 7) && j-jour + 7*(i-1) <= this.nj && j-jour + 7*(i-1)>0){
          td.classList.add("weekend");
        }
        if((j-jour + 7*(i-1) == this.dateReelle.getDate()) && this.d.getMonth() == this.dateReelle.getMonth() && this.d.getFullYear() == this.dateReelle.getFullYear() ){
          td.classList.add("today");
        }

        if(j-jour + 7*(i-1) <= this.nj && estunjourferie(dtmp) != ""){
          td.classList.add("ferie");
        }
      }
    }
    div.append(tab);
    tab.append(tbody);
  }


  this.changeMois = function(plus, id, idmois){
    if(plus == true){
      this.d.setMonth(this.d.getMonth() + 1);
    }else{
      this.d.setMonth(this.d.getMonth() - 1);
    }
    this.majCalendrier(id, idmois);
  }

  this.changeAnnee = function(id, idmois, mois, annee){
    if(isNaN(annee) || annee == ""){
      return -1;
    }
    this.d.setMonth(mois);
    this.d.setFullYear(annee);
    this.majCalendrier(id, idmois);
  }

  this.majCalendrier = function(id, idmois){
    this.nj = nbJours(this.d.getMonth(), this.d.getFullYear());
    this.createCalendrier(id);
    this.afficheDate(idmois);
  }

}

estunjourferie = function(d){
  var y = d.getFullYear();
  var n = y%19;
  var u = y%100;
  var c = Math.floor(y/100);
  var t = c%4;
  var s = Math.floor(c/4);
  var p = Math.floor((c+8)/25);
  var q = Math.floor((c-p+1)/3);
  var e = (19*n+c-s-q+15)%30;
  var b = Math.floor(u/4);
  var d2 = u%4;
  var l = (2*t+2*b-e-d2+32)%7;
  var h = Math.floor((n+11*e+22*l)/451);
  var m = Math.floor((e+l-7*h+114)/31);
  var j = (e+l-7*h+114)%31;
  if(m==3 || m==4){
    j = j+1;
  }
  if(j==0){
    j = 1;
  }

  var mR = d.getMonth() + 1;
  var dR = d.getDate();

  var paque = new Date(y, m-1, j);

  if(mR == m && dR == j){
    return "Paques";
  }
  if(mR == 1 && dR == 1){
    return "nAn";
  }
  if(mR == 5 && dR==1){
    return "travail";
  }
  if(mR == 5 && dR == 8){
    return "8mai";
  }
  if(mR == 7 && dR == 14){
    return "national";
  }
  if(mR == 11 && dR == 11){
    return "armistice";
  }
  if(mR == 8 && dR == 15){
    return "assomption";
  }
  if(mR == 11 && dR == 1){
    return "toussaint";
  }
  if(mR == 12 && dR == 25){
    return "noel";
  }
  paque.setDate(paque.getDate() + 39);
  if(mR == (paque.getMonth() + 1) && dR == paque.getDate()){
    return "ascension";
  }
  paque.setDate(paque.getDate() + 10);
  if(mR == (paque.getMonth() + 1) && dR == paque.getDate()){
    return "pentecote";
  }
  return "";

}
