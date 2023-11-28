<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';


	// Fichier appelé par suppressionEvenement.php pour la suppression d'un évènement
	$array_Where = array();
	$array_Where["ID_Evenement"] = $_GET['ID_Evenement'];

	// On supprime tous les assignations d'agent par rapport à l'évènement
	DELETE ('agent_evenement',$array_Where);

	// On supprime l'évènement de la table Evenement
	DELETE ('evenement',$array_Where);
		
	// Retour à la page des évènements
	header('Location: evenement.php');
			
?>