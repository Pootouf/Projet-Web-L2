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

function calendrier(nombreJours, date){

  this.nj = nombreJours;
  this.d = date;
  this.dateReelle = new Date();

  this.afficheDate = function(id){
    let div = document.getElementById(id);
    var nomMois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
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
    for(var i = 1; i<=5; i++){
      let tr = document.createElement('tr');
      tbody.append(tr);
      for(var j = 1; j<= 7; j++){
        let td = document.createElement('td');
        tr.append(td);
        if((i == 1 && j>= jour+1) || i!= 1){
          let date = document.createTextNode(j-jour + 7*(i-1));
          if(j-jour + 7*(i-1) <= nj){
            td.append(date);
          }
        }
        if((j == 6 || j == 7) && j-jour + 7*(i-1) <= nj){
          td.setAttribute("class", "weekend");
        }
        if((j-jour + 7*(i-1) == this.dateReelle.getDate()) && this.d.getMonth() == this.dateReelle.getMonth() && this.d.getFullYear() == this.dateReelle.getFullYear() ){
          td.setAttribute("id", "today");
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

  this.majCalendrier = function(id, idmois){
    this.createCalendrier(id);
    this.afficheDate(idmois);
  }

}
