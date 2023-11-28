<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';


// Fonction d'appel Ajax pour la recherche d'agents
	
	try
	{
		// Connexion à la base de données
		$connexion = Get_cnx();
		$req = 'SELECT * FROM Agent WHERE Nom LIKE "'.$_GET['q'].'%" AND Prenom LIKE "'.$_GET['r'].'%" ORDER BY Nom';
		$st = $connexion->query($req);
		if ($st==FALSE){
		
			echo "Nom de table ou attributs incorrects";
			
		}else{
		
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				
				// Si on ne trouve aucun résultat
				echo "Aucun résultat pour cette recherche";
				
			}else{
				// On affiche les résultat trouvées en utilisant la fonction afficherTable pour l'affichage des données
				afficherTable ($donnees);
				$st -> closeCursor();
				
			}
		}
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}

?>