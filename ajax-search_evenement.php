<?php

require '/tools/cnx_param.php';

// Fonction d'appel Ajax pour la recherche d'évènements

	try
	{
		// Connexion à la base de données
		$connexion = Get_cnx();
		$req = 'SELECT ID_Evenement, Categorie_Evenement, Date, Heure_Debut, Heure_Fin FROM Evenement WHERE Categorie_Evenement LIKE "'.$_GET['q'].'%" AND Date LIKE "'.$_GET['r'].'%" ORDER BY Date DESC, Heure_Debut DESC, Heure_Fin DESC, Categorie_Evenement LIMIT 18';
		$st = $connexion->query($req);
		$evenement = $st -> fetchAll( PDO::FETCH_ASSOC);
		$var ="";
		$val ="";
		$var_contenu = '<h1 title="...">Résultat(s) de la recherche</h1>
							<ul>';

		foreach($evenement as $k => $v)
		{
			foreach($v as $sous_key=>$sous_val)
			{
				$last_key = end(array_keys($v));
				
				if($sous_key == "ID_Evenement"){
					
					// On stocke l'ID de l'évènement dans la variable $val
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
						
					}
					else{
					
						$var .= $sous_val.' ';
					
					}
					
				}
			}
			
			$var_contenu .= '<a><li alt="'.$val.'">'.$var.'</li></a>';
			
			// On réinitialise la variable $var
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