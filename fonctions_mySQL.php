<?php

require '/tools/cnx_param.php';
require '/tools/fonctions_conversion.php';
	
// Fonction SELECT_ALL_TABLE affiche tout le contenu d'une table avec tous les champs également
function SELECT_ALL_TABLE ($table)
{		
	try
	{
		$connexion = Get_cnx();
		$req = 'SELECT * FROM '.$table;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table incorrect";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Table vide";
			}else{
				$var = "";			
				foreach($donnees as $key => $val)
				{
					foreach($val as $sous_key=>$sous_val)
					{
						$last_key = end(array_keys($val));

						if($sous_key == $last_key){
							$var .= $sous_key.' = '.'"'.$sous_val.'"<br />';
						}else{
							$var .= $sous_key.' = '.'"'. $sous_val.'"  ';
						}
					}
					
				}
				echo $var;
				$st -> closeCursor();
			}
		}
	
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT_ALL affiche tous les champs d'une table résultant d'une requête Select avec utilisation du WHERE
function SELECT_ALL ($table,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT * FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
			$var = "";	
			foreach($donnees as $key => $val)
			{
				foreach($val as $sous_key=>$sous_val)
				{
					$last_key = end(array_keys($val));

					if($sous_key == $last_key){
						$var .= $sous_key.' = '.'"'.$sous_val.'"<br />';
					}else{
						$var .= $sous_key.' = '.'"'. $sous_val.'"  ';
					}
				}
			
			}
			echo $var;
			$st -> closeCursor();
			}
		}
		$connexion = null;
	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT affiche les champs sélectionnés d'une table résultant d'une requête Select avec utilisation du WHERE
function SELECT ($table,$array_Champs,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Champs = toString_CHAMPS($array_Champs);
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT '.$chaine_Champs.' FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
				$var = "";	
				foreach($donnees as $key => $val)
				{
					foreach($val as $sous_key=>$sous_val)
					{
						$last_key = end(array_keys($val));

						if($sous_key == $last_key){
							$var .= $sous_key.' = '.'"'.$sous_val.'"<br />';
						}else{
							$var .= $sous_key.' = '.'"'. $sous_val.'"  ';
						}
					}
				
				}
				echo $var;
				$st -> closeCursor();
			}
		}
	$connexion = null;
	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}

	
// Fonction INSERT qui permet d'effectuer une requête de type INSERT
function INSERT ($table,$array_Values)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Values = toString_VALUES($array_Values);
		$req = 'INSERT INTO '.$table.' VALUES '.$chaine_Values;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Nom de table incorrect (ou clé étrangère non existante) !";
		}else{
			if ( $st != 0 ){
				//echo "L'entrée a bien été ajoutée !";
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction UPDATE qui permet d'effectuer une requête de type UPDATE
function UPDATE ($table,$array_Set,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Set = toString_SET($array_Set);
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'UPDATE '.$table.' SET '.$chaine_Set.' WHERE '.$chaine_Where;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Aucune modification !";
		}else{
	
			switch ($st)
			{ 
				case 0:
				//echo 'Aucune entrée n`\'a été modifiée ! <br/>';
				break;

				case 1:
				//echo 'Une entrée a été modifiée ! <br/>';
				break;

				default:
				//echo $st. ' entrées ont été modifiées ! <br/>';
				break;
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction DELETE_ALL qui permet d'effacer tout le contenu d'une table
function DELETE_ALL ($table)
{		
	try
	{
		$connexion = Get_cnx();
		$req = 'DELETE FROM '.$table;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Nom de table incorrect !";
		}else{
			if ( $st != 0 ){
				//echo "La table a été supprimée !";
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}

	
	
// Fonction DELETE qui permet d'effacer le contenu d'une table sélectionné par le WHERE
function DELETE ($table,$array_Where)
{		
	try
	{
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'DELETE FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->exec($req);
		$connexion = null;
		if ( $st == FALSE ){
			//echo "Nom de table ou attributs incorrects !";
		}else{
			switch ($st)
			{ 
				case 0:
				//echo 'Aucune entrée n`\'a été supprimée ! <br/>';
				break;

				case 1:
				//echo 'Une entrée a été supprimée ! <br/>';
				break;

				default:
				//echo $st. ' entrées ont été supprimées ! <br/>';
				break;
			}
		}
	}		
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT_ALL_TABLE_AFFICHAGE affiche tout le contenu d'une table avec tous les champs également avec affichage sous forme de tableau (utilisation de la fonction afficherTable)
function SELECT_ALL_TABLE_AFFICHAGE ($table)
{	
	try
	{
		$connexion = Get_cnx();
		$req = 'SELECT * FROM '.$table;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table incorrect";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Table vide";
			}else{
				afficherTable ($donnees);
				$st -> closeCursor();
			}
		$connexion = null;
		}
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


// Fonction SELECT_ALL affiche tous les champs d'une table résultant d'une requête Select avec utilisation du WHERE avec affichage sous forme de tableau (utilisation de la fonction afficherTable)
function SELECT_ALL_AFFICHAGE ($table,$array_Where)
{
	try
	{
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT * FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
				echo $st->rowCount() . ' résultat(s)';
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
}



// Fonction SELECT affiche les champs sélectionnés d'une table résultant d'une requête Select avec utilisation du WHERE avec affichage sous forme de tableau (utilisation de la fonction afficherTable)
function SELECT_AFFICHAGE ($table,$array_Champs,$array_Where)
{	
	try
	{
		$connexion = Get_cnx();
		$chaine_Champs = toString_CHAMPS($array_Champs);
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT '.$chaine_Champs.' FROM '.$table.' WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
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
}



// Fonction afficherTable qui étant donné un array $donnees, l'affiche sous forme de tableau
function afficherTable ($donnees)
{
	try
	{
	
		$connexion = Get_cnx();
		$req = 'SELECT * FROM Collectivite';
		$st = $connexion->query($req);
		$array_collectivite = array();
		while($obj = $st->fetch(PDO::FETCH_OBJ)){
				
			$array_collectivite[$obj->ID_Collectivite] = $obj->Collectivite;
		}
		$st -> closeCursor();

	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
	try
	{

		$req = 'SELECT ID_Service, Service FROM Service';
		$st = $connexion->query($req);
		$array_service = array();
		while($obj = $st->fetch(PDO::FETCH_OBJ)){
		
			$array_service[$obj->ID_Service] = $obj->Service;
			
		}
		$st -> closeCursor();

	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
	
	
	try
	{

		$req = 'SELECT ID_Agent FROM Responsable';
		$st = $connexion->query($req);
		$array_responsable = array();
		while($obj = $st->fetch(PDO::FETCH_OBJ)){
		
			$array_responsable[] = $obj->ID_Agent;
			
		}
		$st -> closeCursor();
		$connexion = null;
		
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
	
		
	$var_titre ="";
	$var_titre .= '<div class="row">
						<div class="span8">
							<table class="table table-striped table-condensed" border=0>
								<thead>
									<tr>
									';
	$var_contenu ="";
	$var_contenu = "			<tbody>
									<tr>";
	$var_final ="";
	foreach($donnees as $key => $val)
	{
		$last_key2 = end(array_keys($donnees));
		if($key == $last_key2){
			foreach($val as $sous_key2=>$sous_val2)
			{
				$last_key3 = end(array_keys($val));

				if($sous_key2 == "Prenom"){
				
					$sous_key2 = 'Prénom';
					
				}if($sous_key2 == "Date_Entree_Collectivite"){
				
					$sous_key2 = 'Date d\'Entree Collectivité';
					
				}if($sous_key2 == "ID_Collectivite"){
				
					$sous_key2 = 'Collectivité';
					
				}if($sous_key2 == "ID_Service"){
				
					$sous_key2 = 'Service';
					
				}if($sous_key2 == $last_key3){
				
					$var_titre .= '<th><b><em>Modifier</em></b></th>
									<th><b><em>Supprimer</em></b></th>
									</tr>
									</thead>';
									
				}elseif($sous_key2 == "Prénom"){
				
					$var_titre .= '<th><b>'.$sous_key2.'</b></th>
									<th></th>';
									
				}else{
				
					$var_titre .= '<th><b>'.$sous_key2.'</b></th>';
				}
			}
		}

		foreach($val as $sous_key=>$sous_val)
		{
			$last_key = end(array_keys($val));
			
			
			if($sous_key == "ID_Agent"){
			
				$ID_Agent = $sous_val;
				
			}if($sous_key == "Date_Entree_Collectivite"){
			
				$date = new DateTime($sous_val);
				$sous_val = $date->format('d-m-Y');	
			
			}if($sous_key == "ID_Collectivite"){
			
				$sous_val = $array_collectivite[$sous_val];	
				
			}if($sous_key == "ID_Service"){
			
				$sous_val = $array_service[$sous_val];
				
			}
			
			
			
			
			
			if($sous_key == $last_key){
						
				$var_contenu .= '<td class="rowusercenter width50"><a class="modifagent" ><img class="modifagent" alt="'.$ID_Agent.'" src="img/modify_user.png" width="30px" height="30px" title="Modifier l\'utilisateur"/></a> </td>
	
								<td class="rowusercenter width50"><a class="deleteagent" ><img class="deleteagent" alt="'.$ID_Agent.'" src="img/delete_user.png" width="30px" height="30px" title="Supprimer l\'utilisateur"/></a> </td>
								</tr>';
								
			}elseif($sous_key == "Prenom"){
			
				$var_contenu .= '<td class="tablo" valign="top">'.$sous_val.'</td>
									<td class="rowusercenter width50"><a class="bilan" ><img class="bilan" alt="'.$ID_Agent.'" src="img/loupe.png" width="30px" height="30px" title="Bilan Heures Supplémentaires"/></a> </td>';
									
			}elseif($sous_key == "ID_Agent"){
			
				if(in_array($sous_val, $array_responsable)){
			
					$var_contenu .= '<td class="tablo" valign="top"><img alt="'.$ID_Agent.'" src="img/etoile.png" width="20px" height="20px" title="Responsable"/> '.$sous_val.'</td>';
				
				}else{
					
					$var_contenu .= '<td class="tablo" valign="top">'.$sous_val.'</td>';
					
				}
									
			}else{
			
				$var_contenu .= '<td class="tablo" valign="top">'.$sous_val.'</td>';
				
			}
		}
				
	}
	$var_contenu .= '</tbody>
						</table>
							</div>
					</div>';
	$var_final .= $var_titre.$var_contenu;
	echo $var_final;
				
}

				
				
// Fonction Liste_Agent retourne un tableau contenant l'ID de l'agent pour indice et la concaténation Nom + Prénom pour valeur (pour tous les agents)
function Liste_Agent()
{
	try
	{	
		$connexion = Get_cnx();
		$req = 'SELECT ID_Agent, Nom, Prenom FROM agent ORDER BY Nom';
		$st = $connexion->query($req);
		$agents = $st -> fetchAll( PDO::FETCH_ASSOC);
		$array = array();
		$var ="";
		$val ="";

		foreach($agents as $k => $v)
		{
			foreach($v as $sous_key=>$sous_val)
			{
				$last_key = end(array_keys($v));
				
				if($sous_key == "ID_Agent"){
					$val= $sous_val;
				}else{
					if($sous_key == $last_key){
						$var .= $sous_val;
					}else{
						$var .= $sous_val.' ';
					}
				}
			}
			
			$array[$val] = $var;
			$var="";
		}
					
		return $array;
		
		$st -> closeCursor();
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
}

// Fonction Liste_Agent_Service retourne un tableau contenant l'ID de l'agent pour indice et la concaténation Nom + Prénom pour valeur (pour les agents du service sélectionné à l'aide du paramètre $service qui a pour valeur l'ID du service)
function Liste_Agent_Service($service)
{
	try
	{	
		$connexion = Get_cnx();
		$req = 'SELECT ID_Agent, Nom, Prenom FROM agent WHERE ID_Service = '.$service.' ORDER BY Nom';
		$st = $connexion->query($req);
		$agents = $st -> fetchAll( PDO::FETCH_ASSOC);
		$array = array();
		$var ="";
		$val ="";

		foreach($agents as $k => $v)
		{
			foreach($v as $sous_key=>$sous_val)
			{
				$last_key = end(array_keys($v));
				
				if($sous_key == "ID_Agent"){
					$val= $sous_val;
				}else{
					if($sous_key == $last_key){
						$var .= $sous_val;
					}else{
						$var .= $sous_val.' ';
					}
				}
			}
			
			$array[$val] = $var;
			$var="";
		}
					
		return $array;
		
		$st -> closeCursor();
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
}

// Fonction Liste_Evenement retourne un tableau contenant l'ID de l'évènement pour indice et la concaténation des informations de l'évènement pour valeur (pour tous les évènements)
function Liste_Evenement()
{
	try
	{	
		$connexion = Get_cnx();
		$req = 'SELECT ID_Evenement, Categorie_Evenement, Date, Heure_Debut, Heure_Fin FROM Evenement ORDER BY ID_Evenement';
		$st = $connexion->query($req);
		$evenement = $st -> fetchAll( PDO::FETCH_ASSOC);
		$array = array();
		$var ="";
		$val ="";

		foreach($evenement as $k => $v)
		{
			foreach($v as $sous_key=>$sous_val)
			{
				$last_key = end(array_keys($v));
				
				if($sous_key == "ID_Evenement"){
					$val= $sous_val;
				}else{
					if($sous_key == $last_key){
						$var .= $sous_val;
					}else{
						$var .= $sous_val.' ';
					}
				}
			}
			
			$array[$val] = $var;
			$var="";
		}
					
		return $array;
		
		$st -> closeCursor();
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
}


/*
	Fonction Listage_Tableau qui retourne un tableau contenant l'attribut $cle d'une table pour indice et l'attribut $valeur d'une table pour valeur (fonction utilisée pour stocker la liste des Collectivités avec leur ID sous forme de tableau, qui sera 
	ensuite utilisée comme paramètre de la fonction HlpForm::Select2 du fichier helper.php pour la création d'un formulaire HTML de type Select, même chose pour la liste des Services)
*/
function Listage_Tableau($table, $cle, $valeur)
{
	try
	{	
		$connexion = Get_cnx();
		if ( $valeur==$cle ){
			$req = 'SELECT '.$cle.' FROM '.$table.' ORDER BY '.$valeur;
		}else{
			$req = 'SELECT '.$cle.', '.$valeur.' FROM '.$table.' ORDER BY '.$valeur;
		}
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Table vide";
			}else{
				$array = array();
				$var ="";
				$val ="";

				foreach($donnees as $k => $v)
				{
					foreach($v as $sous_key=>$sous_val)
					{
						if ( $valeur==$cle ){
							$val= $sous_val;
							$var = $sous_val;
						}else{
							if($sous_key == $cle){
								$val= $sous_val;
							}else{							
								$var = $sous_val;									
							}
						}
					}
					
					$array[$val] = $var;
				}
				
				return $array;
			}
			
			$st -> closeCursor();
		}
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
	
}

// Fonction MOTEUR_RECHERCHE qui permet de sélectionner le contenu d'une table grâce à une requête de type SELECT contenant un WHERE LIKE
function MOTEUR_RECHERCHE ($table, $champs, $valeur)
{	
	try
	{
		$connexion = Get_cnx();
		$req = 'SELECT * FROM '.$table.' WHERE '.$champs.' LIKE "%'.$valeur.'%" ORDER BY Nom';
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attribut incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{
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

}

// Fonction SELECT_ALL_AFFICHAGE_PAGINATION affiche tous les champs d'une table résultant d'une requête Select avec utilisation du WHERE avec affichage sous forme de tableau (utilisation de la fonction afficherTable) et avec un système de pagination
function SELECT_ALL_AFFICHAGE_PAGINATION ($table,$array_Where)
{
	try
	{
		// Numero de page (1 par défaut)
		if( isset($_GET['page']) && is_numeric($_GET['page']) ){	
			$page = $_GET['page'];			
		}else{		
			$page = 1;
		}

		// Nombre d'info par page
		$pagination = 10;
		// Numéro du 1er enregistrement à lire
		$limit_start = ($page - 1) * $pagination;
		
		
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Where);
		$req = 'SELECT * FROM '.$table.' WHERE '.$chaine_Where.' LIMIT '.$limit_start.', '.$pagination;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{

				afficherTable ($donnees);
				$st -> closeCursor();
				
				$req2 = 'SELECT * FROM '.$table.' WHERE '.$chaine_Where;
				$st2 = $connexion->query($req2);
				echo $st2->rowCount() . ' résultat(s)';
				$nb_total = $st2->rowCount();
				// Pagination
				$nb_pages = ceil($nb_total / $pagination);

				echo '<p>[ Page :';
				// Boucle sur les pages
				for ($i = 1 ; $i <= $nb_pages ; $i++) {
					if ($i == $page )
						echo " $i";
					else
						echo " <a href=\"?page=$i\">$i</a> ";
				}
				echo ' ]</p>';

			}
		}
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}

// Fonction SELECT_ALL_TABLE_AFFICHAGE_PAGINATION affiche tout le contenu d'une table avec tous les champs également avec affichage sous forme de tableau (utilisation de la fonction afficherTable) et avec un système de pagination
function SELECT_ALL_TABLE_AFFICHAGE_PAGINATION ($table)
{
	try
	{
		// Numero de page (1 par défaut)
		if( isset($_GET['page']) && is_numeric($_GET['page']) ){
			$page = $_GET['page'];
		}else{
			$page = 1;
		}
		// Nombre d'info par page
		$pagination = 30;
		// Numéro du 1er enregistrement à lire
		$limit_start = ($page - 1) * $pagination;
		
		
		$connexion = Get_cnx();
		$req = 'SELECT * FROM '.$table.' LIMIT '.$limit_start.', '.$pagination;
		$st = $connexion->query($req);
		if ($st==FALSE){
			//echo "Nom de table ou attributs incorrects";
		}else{
			$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
			if($donnees == FALSE){
				//echo "Aucun résultat";
			}else{

				afficherTable ($donnees);
				$st -> closeCursor();
				
				$req2 = 'SELECT * FROM '.$table;
				$st2 = $connexion->query($req2);
				echo $st2->rowCount() . ' résultat(s)';
				$nb_total = $st2->rowCount();
				// Pagination
				$nb_pages = ceil($nb_total / $pagination);

				echo '<p>[ Page :';
				// Boucle sur les pages
				for ($i = 1 ; $i <= $nb_pages ; $i++) {
					if ($i == $page )
						echo " $i";
					else
						echo " <a href=\"?page=$i\">$i</a> ";
				}
				echo ' ]</p>';

			}
		}
		$connexion = null;
	}
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}
}


?>