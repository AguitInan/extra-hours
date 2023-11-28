<?php

session_name('hsup');
session_start();
 
if( isset ($_POST['Login'])){
$_SESSION['Login'] = $_POST['Login'];
}

if( isset ($_POST['Password'])){
$_SESSION['Password'] = md5($_POST['Password']);
}

require '/tools/helper.php';
require 'fonctions_mySQL.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Accueil</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/themes/base/jquery.ui.all.css" />
		<link rel="stylesheet" media="all" type="text/css" href="bootstrap/css/jquery-ui-1.8.16.custom.css" />
		<script type="text/javascript" src="bootstrap/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="bootstrap/js/modalbox.js"></script>
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox-skin-rounded-black.css"/>
		<link rel="stylesheet" href="bootstrap/css/jquery.modalbox.css"/>

		<style>
		
		input{height:15px};
		.header{line-height:16px;margin:0 0 0.4em;}
		.user{width:60%;height:auto;margin-left:auto;margin-right:auto;padding-top:50px}
		.adduser{cursor:pointer}
		#footer {background: #EDEDED;width:100%;}
		.rowusercenter{text-align:center}
		.width200{width:200px}
		.width50{width:50px}
		.entete{font-family:'ARIAL BLACK';font-size:12px;color:#B1D662;background-color:#000}
		.pointer{cursor:pointer}
		#spajoutuser{margin:0px 0px 20px 20px;float:left}
		#actionajoutuser{cursor:pointer}
		#refresh{cursor:pointer}
		.modifagent{cursor:pointer}
		.deleteagent{cursor:pointer}
		.bilan{cursor:pointer}
		
		</style>
		
	</head>
	<body>
	
				<?php
				
				// Page d'accueil

				//Reception des données
				if ( isset ($_SESSION['Login']) && isset ($_SESSION['Password']) ){
				
					$login = $_SESSION['Login'];
					$password= $_SESSION['Password'];

					try
					{
						// Connexion à la base de données
						$connexion = Get_cnx();
						$req = 'SELECT * FROM Login WHERE Login = "'.$login.'" AND Password = "'.$password.'"';
						$st = $connexion->query($req);
						$donnees = $st->fetch( PDO::FETCH_OBJ);
						
						// On vérifie le Login et le Mot de passe
						if($donnees == FALSE){
						
							echo 'Utilisateur inconnu ou mauvais mot de passe';
							
						}else{

							echo '</br>
									<h2><em>ACCUEIL</em></h2><br/>

									<div class="row show-grid">

										<div class="row">
										<div class="span4"><br/></div>
										<div class="span10">
								<br/>';
									
							if ($donnees->Profil == 'Administrateur'){							// Administrateur
							
							$_SESSION['Profil'] = 'Administrateur';
							$_SESSION['ID_Login'] = $donnees->ID_Login;
							
							echo '<button id="bouton" class="btn btn-primary btn-large">Ajout d\'un agent</button>
								  <button id="bouton2" class="btn btn-info btn-large">Ajout d\'un évènement</button>
								  <a href="evenement.php" id="bouton3" class="btn btn-large">Assigner les évènements</a>
								   <a href="synthese_service.php" id="bouton4" class="btn btn-large">Synthèse</a>
								   <a href="excel.php" id="bouton5" class="btn btn-large">Paye</a>
								  <br/><br/>
								  <label for="q">Rechercher par Nom</label>
								  <input type="text" name="q" id="q">
								  <label for="r">Rechercher par Prénom</label>
								  <input type="text" name="r" id="r">
								  
								  <div id="evenements">';
							
							// On utilise la fonction d'affichage prévue pour l'authentification Administrateur (affiche tous les agents)  
							SELECT_ALL_TABLE_AFFICHAGE_PAGINATION ('Agent'); 
							
							echo '</div>';
													
							}elseif($donnees->Profil == 'Responsable'){													// Responsable
							
								$_SESSION['Profil'] = 'Responsable';
								$_SESSION['ID_Login'] = $donnees->ID_Login;
								
								echo '<button id="bouton2" class="btn btn-info btn-large">Ajout d\'un évènement</button>
									  <a href="evenement.php" id="bouton3" class="btn btn-large">Assigner les évènements</a>
									   <a href="synthese_service.php" id="bouton4" class="btn btn-large">Synthèse</a>
									   <a href="excel.php" id="bouton5" class="btn btn-large">Paye</a>';
								
								try
								{
								
									$req = 'SELECT ID_Service FROM Service WHERE ID_Responsable = (SELECT ID_Responsable FROM Responsable WHERE ID_Agent = "'.$donnees->ID_Login.'")';
									$st = $connexion->query($req);
									$donnees = $st->fetch( PDO::FETCH_ASSOC);
									
									// On utilise la fonction d'affichage prévue pour l'authentification Responsable (affiche les agents du service)
									SELECT_ALL_AFFICHAGE_PAGINATION ('Agent',$donnees);
																
								}
								catch(Exception $f)
								{
									echo 'err : '.$f->getMessage().'<br />';
								}
								
							}else{
							
								$_SESSION['Profil'] = 'Utilisateur';													// Utilisateur
							
								try
								{
								
									$req = 'SELECT * FROM Agent WHERE ID_Agent = "'.$donnees->ID_Login.'"';
									$st = $connexion->query($req);
									$donnees = $st->fetchAll( PDO::FETCH_ASSOC);
									
									afficherTable ($donnees);
															
								}
								catch(Exception $f)
								{
									echo 'err : '.$f->getMessage().'<br />';
								}
							}

							$st -> closeCursor();
							$connexion = null;
							
						}
						
					}
					catch(Exception $f)
					{
						echo 'err : '.$f->getMessage().'<br />';
					}
					
				}else{
				
					echo 'Veuillez passer par la page d\'authentification';
					
				}
				 

				?>

			</div>
		</div>
		</div>
		
		<div class="footer-content">
			<div class="footer-text">
				Mairie de Beauvais - communauté d'agglomération du Beauvaisis
			</div>	
		</div>
			
		<script>
		
		// Affichage du Modal pour la modification de l'agent
		function testDirectCall_Source_modificationAgent($id){

			jQuery.fn.modalBox({
				directCall :
				{
				 source : 'modificationAgent.php?ID_Agent='+$id
				}

			});
		}
				
		//Appel ajax du Formulaire modificationAgent
		$("img.modifagent").click(function(){
			$id=$(this).attr("alt");
			testDirectCall_Source_modificationAgent($id);				
		});	
		
		
		// Affichage du Modal pour la suppression de l'agent
		function testDirectCall_Source_deleteAgent($id){

			jQuery.fn.modalBox({
				directCall :
					{
						source : 'suppressionAgent.php?ID_Agent='+$id
					}
			});
		}
						
		//Appel ajax du Formulaire suppressionAgent
		$("img.deleteagent").click(function(){
			$id=$(this).attr("alt");
			testDirectCall_Source_deleteAgent($id);				
		});	
		
			

		
		// Affichage du Modal pour l'ajout d'un agent
		function testDirectCall_Source_formulaireAgent(){

			jQuery.fn.modalBox({
				directCall :
				{
				 source : 'formulaireAgent.php'
				}

			});
		}
		
		
		// Appel ajax du Formulaire formulaireAgent
		$('#bouton').click(function(){
			testDirectCall_Source_formulaireAgent();				
		});
		
		
		// Affichage du Modal pour l'ajout d'un évènement + assignation rapide à un agent
		function testDirectCall_Source_formulaireEvenement(){

			jQuery.fn.modalBox({
				directCall :
				{
				 source : 'formulaireEvenement_Ajout.php'
				}

			});
		}
		
		
		// Appel ajax du Formulaire formulaireEvenement_Ajout
		$('#bouton2').click(function(){
			testDirectCall_Source_formulaireEvenement();				
		});
			
		
		$('.closeModalBox').click(function() {
			jQuery.fn.modalBox.close();
		});
			
		// Appel ajax de la synthèse individuelle
		$("img.bilan").click(function(){
			
			$id=$(this).attr("alt");
			document.location.href = 'synthese_individuelle.php?ID_Agent='+$id;
					
		});	
	
								
		$(document).ready( function() {
		
			// On stocke les agents affichés dès le chargement de page dans la variable events
		
			var events = $('#evenements').html();
			 
			// détection de la saisie dans le champ de recherche
			$('#q, #r').keyup( function(){
			  
			  
				$field = $(this);
				$('#ajax-loader').remove(); // on retire le loader

				// on commence à traiter à partir du 2ème caractère saisi
				if( $('#q').val().length > 1 || $('#r').val().length > 1 ){
				
					// on envoie la valeur recherché en GET au fichier de traitement
					$.ajax({
					
						type : 'GET', // envoi des données en GET ou POST
						url : 'ajax-search_agent.php' , // url du fichier de traitement
						data : 'q='+$('#q').val()+'&r='+$('#r').val() , // données à envoyer en  GET ou POST
						beforeSend : function() { // traitements JS à faire AVANT l'envoi
							$field.after('<img src="img/ajax-loader.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
						},
						success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
						
							$('#ajax-loader').remove(); // on enleve le loader
							$('#evenements').html(''); // on vide les resultats
							$('#evenements').html(data); // affichage des résultats dans le bloc
								
							

							// On ajoute les contrôles pour les 3 fonctions suivantes...	
								
							//Appel ajax du Formulaire modificationAgent
							$("img.modifagent").click(function(){
							
								$id=$(this).attr("alt");
								testDirectCall_Source_modificationAgent($id);	
							
							});	
									
							//Appel ajax du Formulaire suppressionAgent
							$("img.deleteagent").click(function(){
							
								$id=$(this).attr("alt");
								testDirectCall_Source_deleteAgent($id);	
								
							});	
							
							
							// Appel ajax de la synthèse individuelle
							$("img.bilan").click(function(){
								
								$id=$(this).attr("alt");
								document.location.href = 'synthese_individuelle.php?ID_Agent='+$id;
										
							});	
														
										
						}
					});
																						  
				}
				
				
				// On réaffiche les agents présentés dès le chargement de page dans le cas où les inputs de recherchent ne contiennent plus un minimum de 2 caractères, grâce à la variable events		
				if( $('#q').val().length < 1 && $('#r').val().length < 1 ){
				
					$('#evenements').html(''); // on vide les resultats
					$('#evenements').html(events); // affichage des agents présentés dès le chargement de page
						
				
					// On remet les contrôles pour les 3 fonctions suivantes...


					//Appel ajax du Formulaire modificationAgent
					$("img.modifagent").click(function(){
					
						$id=$(this).attr("alt");
						testDirectCall_Source_modificationAgent($id);
					
					});	
							
					//Appel ajax du Formulaire suppressionAgent
					$("img.deleteagent").click(function(){
					
						$id=$(this).attr("alt");
						testDirectCall_Source_deleteAgent($id);
					
					});	
					
						
					// Appel ajax de la synthèse individuelle
					$("img.bilan").click(function(){
						
						$id=$(this).attr("alt");
						document.location.href = 'synthese_individuelle.php?ID_Agent='+$id;
								
					});	

				}

				
			});
							  						  
		});

		</script>
			
	</body>
	
</html>