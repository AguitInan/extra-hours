// Fichier JS de configuration du Drag and Drop

$(function() {

	var new_tab_js = new Array;
	var id_evenement;
	var bool = new Array;
	var test = false;
	var id = new Array;
	
	// On rend Draggable la zone avec la liste des agents
	$( "#agents li" ).draggable({
	
		appendTo: "body",
		helper: "clone"
		
	});

	// Configuration de la zone Droppable
	$( "#cart2 ol" ).droppable({
	
		activeClass: "ui-state-default",
		hoverClass: "ui-state-hover",
		accept: "#agents li",
		
		// Configuration de l'action Drop
		drop: function( event, ui ) {
		
			var draggableId = ui.draggable.attr("alt");

			$( this ).find( ".placeholder" ).remove();
			
			// On ajoute une ligne avec le Nom et le Prénom de l'agent ainsi que la valeur du booléen Payer puis la gomme
			$( "<li>" ).html(ui.draggable.text()+'<span> Payé</span> <img id="gomme" src="img/gomme.gif" width="30px" height="30px">' ).attr( 'alt', draggableId ).appendTo( this );
			
			// On efface la ligne de l'agent dans la liste des agents
			ui.draggable.remove();
			$( "#cart2 ol li span:last" ).attr( 'class', "1" );
						
			// On applique les fonctionnalités de la gomme de l'agent que l'on vient de lier à l'évènement avec le drag and drop

			gomme($( "#cart2 img:last" ));
			
			// On applique la fonction booleen à l'agent que l'on vient de lier à l'évènement avec le drag and drop
					
			booleen($( "#cart2 ol li span:last" ));
			
		}
	});


		
	// On récupère la liste des ID des agents déjà liés à l'évènement
	$( "#cart2 ol li" ).each(function(index){
	
		 id[index] = $(this).attr("alt");
		 
	});
	// On vérifie au chargement de la page si la liste des agents liés à cet évènement est vide
	if ( $( "#cart2 ol li ").hasClass("placeholder")){
	
		test = true;
	
	}
		
		
	// Configuration du bouton Procéder	
	$( "#bouton" ).click(function(){
	
		// Lorsqu'aucun agent n'est sélectionné, on en informe l'utilisateur
		if ( $( "#cart2 ol li ").hasClass("placeholder") && test == true ){
		
			alert ("Aucun agent sélectionné");
		
		}else{
			// On récupère les ID des agents liés à l'évènement, les valeurs pour le booléen Payer et l'ID de l'évènement
			$( "#cart2 ol li ").each(function(index, value){

				new_tab_js[index] = $(this).attr("alt");
				bool[index] = $(this).children().attr("class");
				id_evenement = $( "#cart li").attr("alt");
				document.location.href = 'drag_drop.php?tab_js='+new_tab_js+'&bool='+bool+'&id_evenement='+id_evenement;									 
					 
			});
	
		}
						
	});



	// Effacement des personnes, déjà liées à l'évènement, de la liste des agents
	$( "#agents li" ).each(function(index){
					
		id2 = $(this).attr("alt");
	
		if( $.inArray(id2, id) >= 0 ){
			
			$( "#agents li[alt='"+id2+"']" ).remove();

		}
						
	});
	
	
	
	// Pour chaque gomme trouvée dans la liste de départ
	$("#cart2 li img").each(function(){
	
		// On ajoute les contrôles
		gomme($(this));
		
	});
	
	
	
	
	// Pour chaque élément trouvé dans la liste de départ d'agents
	$("#agents li").each(function(){
	
		// On ajoute les contrôles
		doubleclique($(this));
		
	});
	
	
	
	// Pour chaque information "Payé" ou "Non Payé" trouvé dans la liste de départ
	$("#cart2 ol li span").each(function(){
	
		// On ajoute les contrôles
		booleen($(this));
		
	});
	
	
	
	// Cette fonction sert à paramétrer la gomme
	
	function gomme(elt){
	
		$(elt).click(function(){
		
			var Nom = $(elt).parent().text();

			if($(elt).parent().children().hasClass("1")){
			
				Nom = Nom.substring(0, Nom.length - 6);
				
			}else{
			
				Nom = Nom.substring(0, Nom.length - 10);
				
			}
			var Id = $(elt).parent().attr("alt");

			// On remet l'agent dans la liste des agents
			$( "<li>" ).html('<img src="img/user.png" width="30px" height="30px"><span>'+Nom+'</span>' ).attr( 'alt', Id ).addClass("ui-draggable").appendTo( "#agents ul" );

			$( "#agents li:last-child" ).draggable({
			
				appendTo: "body",
				helper: "clone"
			
			});
			
			// On applique la fonctionnalité double clique dans la liste pour l'agent que l'on vient de "gommer"	
			doubleclique($( "#agents li:last-child" ));
			
			// On range par ordre alphabétique la liste des agents
			$("#agents ul li").sortElements(function(a, b){
			
				return $(a).text() > $(b).text() ? 1 : -1;
			
			});
			
			var count = $("#cart2 ol li").length;
			
			// Si l'agent effacé était le seul qui était lié à l'évènement, on réinitialise le champ avec la ligne "Placer les Agents"
			if( count == 1 ){
						
				$(elt).parent().parent().html('<li class="placeholder">Placer les Agents</li>');
				//$(this).parent().remove();
				
			}else{
			
				$(elt).parent().remove();
			}
						
		});
			
	}
	
	
	
	// Cette fonction sert à gérer le double clique pour lier un agent à un évènement
		
	function doubleclique(elt){

		$( elt).dblclick(function() {

			var draggableId = $(elt).attr("alt");
			var donnees = $(elt).text();
			$(".placeholder" ).remove();

			$(elt).remove();
			
			$( "<li>" ).html(donnees+'<span> Payé</span> <img id="gomme" src="img/gomme.gif" width="30px" height="30px">' ).attr( 'alt', draggableId ).appendTo( "#cart2 ol" );
			
			$( "#cart2 ol li span:last" ).attr( 'class', "1" );
			
			// On applique les fonctionnalités de la gomme de l'agent que l'on vient de lier à l'évènement avec le double clique
			
			gomme($( "#cart2 img:last" ));
		
			// On applique la fonction booleen à l'agent que l'on vient de lier à l'évènement avec le double clique
			
			booleen($( "#cart2 ol li span:last" ));

		});
				
	}
	
	
	
	// Cette fonction sert à changer la valeur du booléen Payer à chaque clique en Payé ou Non Payé pour les agents déjà liés à l'évènement	
	
	function booleen (elt){
	
		$(elt).click(function(){
				
		if($(this).hasClass("1")){

			$(this).removeClass("1").addClass("0");
			txt = $(this).text();
			$(this).html(txt.substring(0, txt.length - 4));
			$(this).html(' Non Payé');								 

		}else{

			$(this).removeClass("0").addClass("1");
			txt = $(this).text();
			$(this).html(txt.substring(0, txt.length - 8));
			$(this).html(' Payé');

		}
					
											
		});
	
	}
	
		
		
});
