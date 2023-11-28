<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

		
	// Fichier appelé par formulaireEvenement_Modif.php pour la modification d'un évènement
	$array = array();
	if ((isset($_POST['Date']) && $_POST['Date'] != "")){

		$array['Date'] = $_POST['Date'];
		
	}
	if ((isset($_POST['Categorie_Evenement']) && $_POST['Categorie_Evenement'] != "")){

		$array['Categorie_Evenement'] = $_POST['Categorie_Evenement'];
		
	}
	if ((isset($_POST['No_Manifestation']) && $_POST['No_Manifestation'] != "")){

		$array['No_Manifestation'] = $_POST['No_Manifestation'];
		
	}
	if ((isset($_POST['Nom_Evenement']) && $_POST['Nom_Evenement'] != "")){

		$array['Nom_Evenement'] = $_POST['Nom_Evenement'];
		
	}
	if ((isset($_POST['Type_Evenement']) && $_POST['Type_Evenement'] != "")){

		$array['Type_Evenement'] = $_POST['Type_Evenement'];
		
	}
	if ((isset($_POST['Heure_Debut']) && $_POST['Heure_Debut'] != "")){

		$array['Heure_Debut'] = $_POST['Heure_Debut'];
		
	}
	if ((isset($_POST['Heure_Fin']) && $_POST['Heure_Fin'] != "")){

		$array['Heure_Fin'] = $_POST['Heure_Fin'];
		
	}
		
	$reponse = array();
	$reponse['ID_Evenement'] = $_POST['ID_Evenement'];

	// On effectue un UPDATE de l'agent avec toutes les données entrées dans le formulaire (on ne prend que les champs renseignés grâce à des vérifications isset)
	UPDATE('evenement',$array,$reponse);

	// Retour à la page de l'évènement que l'on vient de modifier
	header('Location: evenement2.php?id_evenement='.$_POST["ID_Evenement"]);


?>