<?php

require 'verif_login.php';
require '/tools/helper.php';
require 'fonctions_mySQL.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	
		<title>Assignation Evènements</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
		<script src="ui/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script src="ui/jquery.ui.core.js"></script>
		<script src="ui/jquery.ui.widget.js"></script>
		<script src="ui/jquery.ui.mouse.js"></script>
		<script src="ui/jquery.ui.draggable.js"></script>
		<script src="ui/jquery.ui.droppable.js"></script>
		<script src="ui/jquery.ui.sortable.js"></script>
		<script src="ui/jquery.ui.accordion.js"></script>
		
		<script src="bootstrap/js/sort.js"></script>
		
		<script src="js/drag_drop.js"></script>
		
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker-fr.js"></script>
		<script type="text/javascript" src="bootstrap/js/ui/jquery-ui-timepicker-addon.js"></script>
		
		<script type="text/javascript" src="bootstrap/js/modalbox.js"></script>
		
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox-skin-rounded-black.css"/>
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox.css"/>
		
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		
		<style>
		input{height:15px};
		</style>

	</head>

	<body>
		<br/>
		
		<h2>
			<em>ASSIGNER LES EVENEMENTS</em>
			<a href="accueil.php" class="btn btn-large">Retour à l'accueil</a>
		</h2>
		
		<br/>
		
		<div align="right">
			<button id="bouton2" class="btn btn-info btn-large">Ajout d'un évènement</button>
		</div>
		
		<br/>
		<br/>		
		
		<!--début du formulaire de recherche Ajax des évènements-->
		<form class="ajax">
			<p>
				<label for="q">Rechercher par Catégorie</label>
				<input type="text" name="q" id="q" />
				
				<label for="r">Rechercher par Date (forme AAAA-MM-JJ)</label>
				<input type="text" name="r" id="r" />
				
			</p>
		</form>
		<!--fin du formulaire-->

		
		<?php
		
		// Fichier concernant les évènements
			
		try
		{	
			// Connexion à la base de données
			$connexion = Get_cnx();
			
			// On récupère les informations des 10 derniers évènements
			$req = 'SELECT ID_Evenement, Categorie_Evenement, Date, Heure_Debut, Heure_Fin FROM Evenement ORDER BY Date DESC, Heure_Debut DESC, Heure_Fin DESC, Categorie_Evenement LIMIT 10';
			$st = $connexion->query($req);
			$evenement = $st -> fetchAll( PDO::FETCH_ASSOC);
			$var ="";
			$val ="";
			$var_contenu = '<div class="span4" id="evenements">
			<h1 title="...">Les 10 derniers Evènements</h1>
				<ul>';

			foreach($evenement as $k => $v)
			{
				foreach($v as $sous_key=>$sous_val)
				{
					$last_key = end(array_keys($v));
					
					if($sous_key == "ID_Evenement"){
					
						$val= $sous_val;
						
					}else{
					
						if($sous_key == $last_key){
						
							// On récupère l'Heure de Fin sous la forme HH:MM au lieu de HH:MM:SS à l'aide de la fonction substr
							$var .= '<b>'.substr($sous_val, 0, 5).'</b>';
							
						}elseif($sous_key == "Heure_Debut"){
							
							// On récupère l'Heure de Début sous la forme HH:MM au lieu de HH:MM:SS à l'aide de la fonction substr
							$var .= '<b>'.substr($sous_val, 0, 5).'</b> ';
							
						}elseif($sous_key == "Date"){
							
							// On affiche la Date sous le format français à l'aide de la fonction substr en sélectionnant les différentes parties qui la composent (Jour, Mois et Année)
							$var .= '<em>'.substr($sous_val, 8, 10).'-'.substr($sous_val, 5, -2).substr($sous_val, 0, 4).'</em> ';
							
						}else{
						
							$var .= $sous_val.' ';
						
						}
					}
				}
				
				$var_contenu .= '<a><li alt="'.$val.'">'.$var.'</li></a>';
				$var="";
			}
			
			$var_contenu .= '</ul>
							</div>';
						
			echo $var_contenu;
			
			$st -> closeCursor();
			
		}
		catch(Exception $f)
		{
			echo 'err : '.$f->getMessage().'<br />';
		}
		
		?>


		
		
		<script>
			
			// Fonction qui permet de créer un lien vers l'assignation d'agents, pour chaque évènement de la liste
			$(function() {
											
				$( "a li" ).click(function(){

					id_evenement = $(this).attr("alt");
																	
					document.location.href = 'evenement2.php?id_evenement='+ id_evenement;
														
				});

			});
									
		

					
					
		$(document).ready( function() {
		
			// On stocke les 10 derniers évènements dans la variable events
			  
			var events = $('#evenements').html();

			// détection de la saisie dans le champ de recherche
			$('#q, #r').keyup( function(){
			  
				$field = $(this);
				$('#results').html(''); // on vide les resultats
				$('#ajax-loader').remove(); // on retire le loader
			 
				// on commence à traiter à partir du 2ème caractère saisi
				if( $('#q').val().length > 1 || $('#r').val().length > 1 )
				{
					// on envoie la valeur recherché en GET au fichier de traitement
					$.ajax({
					type : 'GET', // envoi des données en GET ou POST
					url : 'ajax-search_evenement.php' , // url du fichier de traitement
					data : 'q='+$('#q').val()+'&r='+$('#r').val() , // données à envoyer en  GET ou POST
					beforeSend : function() { // traitements JS à faire AVANT l'envoi
						$field.after('<img src="img/ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
					},
					success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
						$('#ajax-loader').remove(); // on enleve le loader
						$('#evenements').html(''); // on vide les resultats
						$('#evenements').html(data); // affichage des résultats dans le bloc
															
							// On ajoute un lien vers l'assignation d'agents pour les évènements trouvés avec la recherche Ajax
							$( "a li" ).click(function(){
																										
								id_evenement = $(this).attr("alt");
									 
								document.location.href = 'evenement2.php?id_evenement='+ id_evenement;
													
							});
													
						}
						
					});
					
				}
				
				// On réaffiche les 10 derniers évènements dans le cas où les inputs de recherchent ne contiennent plus un minimum de 2 caractères, grâce à la variable events		
				if( $('#q').val().length < 1 && $('#r').val().length < 1 )
				{
					$('#evenements').html(''); // on vide les resultats
					$('#evenements').html(events); // affichage des 10 derniers évènements
					
					// On ajoute un lien vers l'assignation d'agents pour les évènements trouvés avec la recherche Ajax
					$( "a li" ).click(function(){
														
						id_evenement = $(this).attr("alt");
						 
						document.location.href = 'evenement2.php?id_evenement='+ id_evenement;
																														
					});

				}
				
			});
			
		});


			
			
			// Affichage du Modal pour l'ajout d'un évènement
			function testDirectCall_Source_formulaireEvenement_Ajout2(){

				jQuery.fn.modalBox({
					directCall :
					{
					 source : 'formulaireEvenement_Ajout2.php'
					}

				});
			}
			
			
			//Appel ajax du Formulaire formulaireEvenement_Ajout2
			$('#bouton2').click(function(){
				testDirectCall_Source_formulaireEvenement_Ajout2();				
			});
			
		</script>

	</body>
</html>

