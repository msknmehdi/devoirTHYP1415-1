$(function(){
	AfficherChart();
});

function AjoutAbsence(idEtudiant){
	var id = idEtudiant;
		
	$.ajax({
        url  : '../Ecrire/ecrire',
        data : {"id": id, "type":1},
        type : 'POST' ,
        success : function(result){alert(" l'absence a été enregistrée ");}
	});
}

function AjoutPresence(idEtudiant){
	var id = idEtudiant;
	
	$.ajax({
        url  : '../Ecrire/ecrire',
        data : {"id": id,"type":2},
        type : 'POST' ,
        success : function(result){alert(" la présence a été enregistrée ");}
	});
	
}

function lirePresence(idEtudiant,div){
	var id = idEtudiant;
	var listab = $(div).parent().parent().parent().find("#listeTable");
	var tab = $(div).parent().parent().parent().find("#bodyListe");
	var alert = $(div).parent().parent().parent().find("#alert");
	
	var OK = function(result){
		var data = jQuery.parseJSON(result);
		if(data != null){
			$(tab).html('');
			for(var i=0;i<data.length;i++){
				$(tab).append("<tr><td>Present le :</td><td>"+data[i].date_presence+"</td></tr>");
				
			}
			$(listab).fadeIn('slow');
		}
		else{$(listab).fadeOut('slow');$(alert).fadeIn('slow');}
			
	}
		
	$.ajax({
        url  : '../Lire/lire',
        data : {"id": id,"type":1},
        type : 'POST' ,
        success : OK
	});	
}

function lireAbsence(idEtudiant,div){
	var id = idEtudiant;
	var listab = $(div).parent().parent().parent().find("#listeTable");
	var tab = $(div).parent().parent().parent().find("#bodyListe");
	var alert = $(div).parent().parent().parent().find("#alert");
	
	var OK = function(result){
		var data = jQuery.parseJSON(result);
		if(data != null){
			$(tab).html('');
			for(var i=0;i<data.length;i++){
				$(tab).append("<tr><td>Absent le :</td><td>"+data[i].date_absence+"</td></tr>");
				
			}
			$(listab).fadeIn('slow');
		}
		else{$(listab).fadeOut('slow');$(alert).fadeIn('slow');}
			
	}
		
	$.ajax({
        url  : '../Lire/lire',
        data : {"id": id,"type":2},
        type : 'POST' ,
        success : OK
	});	
}
function getListeAbsencePresence(idEtudiant,div){
	var id = idEtudiant;
	var listab = $(div).parent().parent().parent().find("#listeTable");
	var tab = $(div).parent().parent().parent().find("#bodyListe");
	var alert = $(div).parent().parent().parent().find("#alert");
	var nombreP = $(div).parent().parent().parent().find("#nombreP");
	var nombreA = $(div).parent().parent().parent().find("#nombreA");
	
	var OK = function(result){
		var data = jQuery.parseJSON(result);
		if(data != null){
			$(tab).html('');
			var HtmlString = "";
			var nombrepre = 0;
			var nombreabs = 0;
			for(var i=0;i<data.length;i++){
				if(data[i].date_absence != null){
					$(tab).append("<tr><td>Absent le :</td><td>"+data[i].date_absence+"</td></tr>");
					nombreabs++;
				}
				if(data[i].date_presence != null){
					$(tab).append("<tr><td>Present le :</td><td>"+data[i].date_presence+"</td></tr>");
					nombrepre++;
				}
			}
			$(nombreP).html('Nombre présences : '+nombrepre);
			$(nombreA).html('Nombre absences : '+nombreabs);
			$(listab).fadeIn('slow');
		}
		else{$(listab).fadeOut('slow');$(alert).fadeIn('slow');}
			
	}
		
	$.ajax({
        url  : '../Lire/lire',
        data : {"id": id,"type":3},
        type : 'POST' ,
        success : OK
	});	
}
function AfficherChart(id,div){
	var id_bloc = $(div).parent().parent().parent().parent().parent().attr('id');
	var alert = $(div).parent().parent().parent().find("#alert");
	
	var OK = function(result){
		var data = jQuery.parseJSON(result);
		var donnee= [];
		var nombreabs=0;
		var nombrepre = 0;
		if(data != null){
			for(var i=0;i<data.length;i++){
				if(data[i].date_absence != null){
					nombreabs++;
					donnee.push({ "type": "absence", "nombre": nombreabs});
				}
				if(data[i].date_presence != null){
					nombrepre++
					donnee.push({ "type": "presence", "nombre": nombrepre});
				}
			}
			var svg = dimple.newSvg("#"+id_bloc, 200, 200),
		    c = new dimple.chart(svg, donnee),
		    x = c.addCategoryAxis("x", "type"),
		    y = c.addMeasureAxis("y", "nombre"),
		    s = c.addSeries(null, dimple.plot.bar);
	
			c.draw();
			
			// This line changes number formats in the tooltip
			y.tickFormat = ",.f";
		}
		else
			$(alert).fadeIn('slow');
	}
	
	$.ajax({
        url  : '../Lire/lire',
        data : {"id": id,"type":3},
        type : 'POST' ,
        success : OK
	});	
}
