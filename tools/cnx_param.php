<?php

// Fichier comportant la fonction Get_cnx qui permet une connexion PDO à la base de données

function Get_cnx()
{
	$PARAM_hote='localhost';
	$PARAM_port='3306';
	$PARAM_nom_bd='mydb';
	$PARAM_utilisateur='root';
	$PARAM_mdp='';
	$PARAM_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES \'UTF8\'';


	try
	{
		$connexion= new PDO('mysql:host='.$PARAM_hote.'; port='.$PARAM_port.';
		dbname='.$PARAM_nom_bd,$PARAM_utilisateur, $PARAM_mdp, $PARAM_options);
		return $connexion;
	}
	catch(Exception $e)
	{
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
	}
}


?>