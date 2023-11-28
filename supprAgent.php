<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';


	// Fichier appelé par suppressionAgent.php pour la suppression d'un agent
	$array_Where = array();
	$array_Where["ID_Agent"] = $_GET['ID_Agent'];

	// On supprime toutes les assignations d'évènements de cet agent
	DELETE ('agent_evenement', $array_Where);

	// On le supprime de la table Agent
	DELETE ('agent',$array_Where);

	$array_Where2 = array();
	$array_Where2["ID_Login"] = $_GET['ID_Agent'];

	// On supprime également son Login
	DELETE ('login',$array_Where2);

	// Retour à la page d'accueil
	header('Location: accueil.php');
		
?>