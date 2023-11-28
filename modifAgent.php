<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

		
	// Fichier appelé par modificationAgent.php pour la modification d'un agent
		
	$array = array();
	if ((isset($_POST['Nom']) && $_POST['Nom'] != "")){

		$array['Nom'] = $_POST['Nom'];
		
	}
	if ((isset($_POST['Prenom']) && $_POST['Prenom'] != "")){

		$array['Prenom'] = $_POST['Prenom'];
		
	}
	if ((isset($_POST['Fonction']) && $_POST['Fonction'] != "")){

		$array['Fonction'] = $_POST['Fonction'];
		
	}
	if ((isset($_POST['Date_Entree_Collectivite']) && $_POST['Date_Entree_Collectivite'] != "")){

		$array['Date_Entree_Collectivite'] = $_POST['Date_Entree_Collectivite'];
		
	}
	if ((isset($_POST['Matricule']) && $_POST['Matricule'] != "")){

		$array['Matricule'] = $_POST['Matricule'];
		
	}
	if ((isset($_POST['ID_Collectivite']) && $_POST['ID_Collectivite'] != "")){

		$array['ID_Collectivite'] = $_POST['ID_Collectivite'];
		
	}
	if ((isset($_POST['ID_Service']) && $_POST['ID_Service'] != "")){

		$array['ID_Service'] = $_POST['ID_Service'];
		
	}


	$reponse = array();
	$reponse['ID_Agent'] = $_POST['ID_Agent'];

	// On effectue un UPDATE de l'agent avec toutes les données entrées dans le formulaire (on ne prend que les champs renseignés grâce à des vérifications isset)
	UPDATE('agent',$array,$reponse);

	// Retour à la page d'accueil
	header('Location: accueil.php');
						

?>