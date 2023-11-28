<?php

require 'fonctions_mySQL.php';

function jour_ferie($timestamp)
//a partir du timestamp, retourne 1 si le jour est férié ou dimanche
// sinon 0, jour de la semaine
{
	$jour = date("d", $timestamp);
	$mois = date("m", $timestamp);
	$annee = date("Y", $timestamp);
	$EstFerie = 0;
	// dates fériées fixes
	if($jour == 1 && $mois == 1) $EstFerie = 1; // 1er janvier
	if($jour == 1 && $mois == 5) $EstFerie = 1; // 1er mai
	if($jour == 8 && $mois == 5) $EstFerie = 1; // 8 mai
	if($jour == 14 && $mois == 7) $EstFerie = 1; // 14 juillet
	if($jour == 15 && $mois == 8) $EstFerie = 1; // 15 aout
	if($jour == 1 && $mois == 11) $EstFerie = 1; // 1 novembre
	if($jour == 11 && $mois == 11) $EstFerie = 1; // 11 novembre
	if($jour == 25 && $mois == 12) $EstFerie = 1; // 25 décembre
	// fetes religieuses mobiles
	$pak = easter_date($annee);
	$jp = date("d", $pak);
	$mp = date("m", $pak);
	if($jp == $jour && $mp == $mois){ $EstFerie = 1;} // Pâques
	$lpk = mktime(date("H", $pak), date("i", $pak), date("s", $pak), date("m", $pak)
	, date("d", $pak) +1, date("Y", $pak) );
	$jp = date("d", $lpk);
	$mp = date("m", $lpk);
	if($jp == $jour && $mp == $mois){ $EstFerie = 1; }// Lundi de Pâques
	$asc = mktime(date("H", $pak), date("i", $pak), date("s", $pak), date("m", $pak)
	, date("d", $pak) + 39, date("Y", $pak) );
	$jp = date("d", $asc);
	$mp = date("m", $asc);
	if($jp == $jour && $mp == $mois){ $EstFerie = 1;}//ascension
	$pe = mktime(date("H", $pak), date("i", $pak), date("s", $pak), date("m", $pak),
	 date("d", $pak) + 49, date("Y", $pak) );
	$jp = date("d", $pe);
	$mp = date("m", $pe);
	if($jp == $jour && $mp == $mois) {$EstFerie = 1;}// Pentecôte
	$lp = mktime(date("H", $asc), date("i", $pak), date("s", $pak), date("m", $pak),
	 date("d", $pak) + 50, date("Y", $pak) );
	$jp = date("d", $lp);
	$mp = date("m", $lp);
	if($jp == $jour && $mp == $mois) {$EstFerie = 1;}// lundi Pentecôte
	// Dimanches
	$jour_sem = jddayofweek(unixtojd($timestamp), 0);
	if($jour_sem == 0){
	$EstFerie = 1;}
	return $EstFerie;
}


// fonction qui prend en paramètres 3 tableaux contenant les heures de début, les heures de fin et la date des évènements et qui renvoie les heures de jour, les heures de dimanche et les heures de nuit sous forme de tableaux
function Calcul_heures ($tab_HD, $tab_HF, $tab_date){

	$tableau = array();

	$taille = count($tab_HD);

	$tableau_jour = array();
	$tableau_dimanche = array();
	$tableau_nuit = array();

	for ($i = 0 ; $i < $taille ; $i++) {

		$bool = FALSE;
		
		$heure_debut= $tab_HD[$i];
		$heure_fin= $tab_HF[$i];
		
		if ($heure_debut == $heure_fin){
		
			//echo "Heure de début et Heure de fin identiques";
			
		}else{

			$d1=new DateTime("22:00:00");   // $d1 = Heure de début des heures de nuit
			$d2=new DateTime("07:00:00");   // $d2 = Heure de fin des heures de nuit
			
			$d3=new DateTime("00:00:00");

			if($d1<$d2){
			
				$v = $d1;
				$d1 = $d2;
				$d2 = $v;
				$bool = TRUE;
			
			}
														
			if ( $heure_debut < $heure_fin ){
			
				if ( $heure_debut > $d2 AND $heure_fin < $d1 ){
				
					$calcul_jour = $heure_fin->diff($heure_debut);
					
				}elseif( $heure_debut >= $d3 AND $heure_fin <= $d2 ){
				
					$calcul_jour = $heure_debut->diff($heure_debut);    //  =0
					
				}elseif( $heure_debut > $d2 AND $heure_fin >= $d1 ){
						
					if ($heure_debut > $d1){
							
						$calcul_jour = $heure_debut->diff($heure_debut);
						
					}else{
																	
						$calcul_jour = $d1->diff($heure_debut);
						
					}
			
				}elseif( $heure_debut <= $d2 AND $heure_fin < $d1 ){
				
					$calcul_jour = $heure_fin->diff($d2);
					
				}elseif( $heure_debut <= $d2 AND $heure_fin >= $d1 ){
				
					$calcul_jour = $d1->diff($d2);
					
				}
				
			}elseif ( $heure_debut > $heure_fin ){
			
				if ( $heure_debut < $d1 AND $heure_fin > $d2 ){
				
				$calcul_jour1 = ($heure_fin->diff($d2));
				$calcul_jour2 = ($d1->diff($heure_debut));
				$calcul_jour_h = $calcul_jour1->h + $calcul_jour2->h;
				$calcul_jour_i = $calcul_jour1->i + $calcul_jour2->i;
				
				if ($calcul_jour_i >= 60){
				
					$calcul_jour_i = $calcul_jour_i%60;
					$calcul_jour_h++;
					
				}

				$var=new DateTime($calcul_jour_h.':'.$calcul_jour_i);
				
				$calcul_jour = $var->diff($d3);

				}elseif( $heure_debut < $d1 AND $heure_fin <= $d2 ){
						
						if ($heure_debut < $d2){
																									
							$calcul_jour = $d1->diff($d2);
							
						}else{
																										
							$calcul_jour = $d1->diff($heure_debut);
							
						}
			
				}elseif( $heure_debut >= $d1 AND $heure_fin > $d2 ){
						
						if ($heure_fin > $d1){
																										
							$calcul_jour = $d1->diff($d2);
																									
						}else{
																										
							$calcul_jour = $heure_fin->diff($d2);
							
						}
			
				}elseif( $heure_debut >= $d1 AND $heure_fin <= $d2 ){	
																							
					$calcul_jour = $heure_debut->diff($heure_debut);
				
				}
										


										
										
				
			}

			$calcul_total = $heure_fin->diff($heure_debut);
			
			if ( $heure_debut > $heure_fin ){

				if ($calcul_total->i == 0){
				
					$calcul_jour_h = $calcul_total->h*-1+24;
					$calcul_jour_i = $calcul_total->i;
				
				}else{
				
					$calcul_jour_h = $calcul_total->h*-1+23;
					$calcul_jour_i = $calcul_total->i*-1+60;
				
				}
				
				$var=new DateTime($calcul_jour_h.':'.$calcul_jour_i);
				$calcul_total = $var->diff($d3);
			
			}

			$d3=new DateTime("00:00:00");
			$calcul_nuit_h = $calcul_total->h - $calcul_jour->h;
			$calcul_nuit_i = $calcul_total->i - $calcul_jour->i;
			if ($calcul_nuit_i < 0){
			
				$calcul_nuit_i = $calcul_nuit_i+60;
				$calcul_nuit_h--;

			}

			$var=new DateTime($calcul_nuit_h.':'.$calcul_nuit_i);

			$calcul_nuit = $var->diff($d3);
			
			if ($bool){

				$temp = $calcul_jour;
				$calcul_jour = $calcul_nuit;
				$calcul_nuit = $temp;
			
			}
					
			$calcul_dimanche = $d3->diff($d3);
			
			if(jour_ferie($tab_date[$i])){
			
				$calcul_dimanche = $calcul_jour;
				$calcul_jour = $d3->diff($d3);
				
			}
			
			$calcul_jour_int = $calcul_jour->h *60 + $calcul_jour->i;
			$calcul_dimanche_int = $calcul_dimanche->h *60 + $calcul_dimanche->i;
			$calcul_nuit_int = $calcul_nuit->h *60 + $calcul_nuit->i;
				
			$tableau_jour [] = $calcul_jour_int;
			$tableau_dimanche [] = $calcul_dimanche_int;
			$tableau_nuit [] = $calcul_nuit_int;

		
		}
		

		
		
	}
		
	$tableau = array($tableau_jour, $tableau_dimanche, $tableau_nuit, $d1, $d2);
	
	return $tableau;
	
}


// fonction qui prend en paramètres 4 tableaux contenant les heures de jour, les heures de dimanche, les heures de nuit et la valeur du booléen Payer et qui sépare les heures -14 et +14
function Traitement ($jour, $dimanche, $nuit, $payer){

	$compteur_jour1 = 0;			// compteur 1 ==> avant les 14
	$compteur_jour2 = 0;			// compteur 2 ==> après  les 14

	$compteur_dimanche1 = 0;
	$compteur_dimanche2 = 0;

	$compteur_nuit1 = 0;
	$compteur_nuit2 = 0;

	$jourP_14 = 0;					//compteur payé ==> avant les 14 ET Payer
	$dimancheP_14 = 0;			
	$nuitP_14 = 0;

	$jourP14 = 0;					//compteur payé ==> après les 14 ET Payer
	$dimancheP14 = 0;
	$nuitP14 = 0;

	$drapeau = FALSE;
	$bool_jour = TRUE;
	$bool_dimanche = TRUE;

	$taille = count($jour);

	for ($i = 0 ; $i < $taille ; $i++) {

		// drapeau ==> dépassement des 14
		if($drapeau){
		
		
			for ($i ; $i < $taille ; $i++) {
			
				$compteur_jour2 += $jour[$i];
				$compteur_dimanche2 += $dimanche[$i];
				$compteur_nuit2 += $nuit[$i];
				
				if ($payer[$i] == 1 ){
				
					$jourP14 += $jour[$i];
					$dimancheP14 += $dimanche[$i];
					$nuitP14 += $nuit[$i];
				
				}
			}
			
		}else{
		
		
			//Jour			
			// 840  ==> 14 x 60
			if((($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1) < 840) AND $bool_jour){
						
				$compteur_jour1 += $jour[$i];
				if ($payer[$i] == 1 ){
				
					$jourP_14 += $jour[$i];
				
				}
							
				$bool_jour = FALSE;
				
				if(($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1) > 840){
									
					$modulo = ($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1)%840;
					$compteur_jour1 -= $modulo;
					$compteur_jour2 += $modulo;					
					
					if ($payer[$i] == 1 ){
								
						$jourP_14 -= $modulo;
						$jourP14 += $modulo;
				
					}
					
					
				
				}
				
			}else{
							
				$compteur_jour2 += $jour[$i];
				
				if ($payer[$i] == 1 ){
									
					$jourP14 += $jour[$i];
				
				}
				
				$bool_jour = FALSE;
			
			}
			
			
			//Dimanche
			
			if((($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1) < 840) AND ($bool_jour == FALSE)){
							
				$compteur_dimanche1 += $dimanche[$i];
				
				if ($payer[$i] == 1 ){
								
					$dimancheP_14 += $dimanche[$i];
				
				}
				
				
				$bool_dimanche = FALSE;
				
				if(($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1) > 840){
				
				
					$modulo = ($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1)%840;
					$compteur_dimanche1 -= $modulo;
					$compteur_dimanche2 += $modulo;
									
					if ($payer[$i] == 1 ){
									
						$dimancheP_14 -= $modulo;
						$dimancheP14 += $modulo;
				
					}
					
					
				
				}
				
			}else{
							
				$compteur_dimanche2 += $dimanche[$i];
								
				if ($payer[$i] == 1 ){
								
					$dimancheP14 += $dimanche[$i];
				
				}
							
				$bool_dimanche = FALSE;
			
			}
			
			//Nuit
			
				if((($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1) < 840) AND $bool_dimanche == FALSE){
							
					$compteur_nuit1 += $nuit[$i];
					
					if ($payer[$i] == 1 ){
										
						$nuitP_14 += $nuit[$i];
					
					}
					
					
					$bool_dimanche = TRUE;
					$bool_jour = TRUE;
					
					if(($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1) > 840){
							// quand cumul de tous les compteurs > 14, drapeau = TRUE				
						$drapeau = TRUE;
						
						$modulo = ($compteur_jour1 + $compteur_dimanche1 + $compteur_nuit1)%840;
						$compteur_nuit1 -= $modulo;
						$compteur_nuit2 += $modulo;
												
						if ($payer[$i] == 1 ){
											
							$nuitP_14 -= $modulo;
							$nuitP14 += $modulo;
					
						}
					
					}
				
			}else{
				
						
				$compteur_nuit2 += $nuit[$i];
				
				if ($payer[$i] == 1 ){
									
					$nuitP14 += $nuit[$i];
				
				}
				
				
				$bool_dimanche = TRUE;
				$bool_jour = TRUE;
				
				$drapeau = TRUE;
			
			}
		
		}

	}
		
	$resultat = array ($compteur_jour1, $compteur_dimanche1,$compteur_nuit1, $compteur_jour2, $compteur_dimanche2, $compteur_nuit2, $jourP_14, $dimancheP_14, $nuitP_14, $jourP14, $dimancheP14, $nuitP14);

	return $resultat;

}


// fonction qui prend en paramètres un tableau contenant les ID des agents et qui affiche sous forme de tableau la synthèse des heures supplémentaires
function Tableau ($id){

	try
	{
	
		$connexion = Get_cnx();
		$tab_date2 = array();
		$tab_HD2 = array();
		$tab_HF2 = array();
		$payer = array();

		if (isset ($_GET['Mois'])){
		
			$periode = $_GET['Annee'].'-'.$_GET['Mois'];
			
		}else{
		
			$periode = substr(date("Y-m-d"), 0, 7);
			
		}

		$taille_id = count($id);

		for ($i = 0 ; $i < $taille_id ; $i++) {
			
			$tab_date2 = array();
			$tab_HD2 = array();
			$tab_HF2 = array();
			$payer = array();
			$categorie_evenement = array();

			
			try
			{
				
				$req = 'SELECT Nom, Prenom FROM Agent WHERE ID_Agent ='.$id[$i];
				$st = $connexion->query($req);
				while ($obj = $st->fetch(PDO::FETCH_OBJ)){
				
					$nom = $obj->Nom;
					$prenom = $obj->Prenom;
				
				}
				$st -> closeCursor();

			}	
			catch(Exception $f)
			{
				echo 'err : '.$f->getMessage().'<br />';
			}
			
						
			$req = 'SELECT * FROM Evenement A, Agent_Evenement B WHERE A.ID_Evenement=B.ID_Evenement AND Date LIKE "'.$periode.'%" AND ID_Agent = "'.$id[$i].'" ORDER BY Date ASC';  //////////////////////////////// MODIFIER
			$st = $connexion->query($req);
			while($obj = $st->fetch(PDO::FETCH_OBJ)){
			
				$tab_date2[] = $obj->Date;
				$tab_HD2[] = $obj->Heure_Debut;
				$tab_HF2[] = $obj->Heure_Fin;
				$payer[] = $obj->Payer;
				$categorie_evenement[] = $obj->Categorie_Evenement;
			
			}
					
			$tab_HD3 = $tab_HD2;
			$tab_HF3 = $tab_HF2;
			$tab_date3 = $tab_date2;
			
			$taille = count($tab_HD2);

			for ($j = 0 ; $j < $taille ; $j++) {
					
				$tab_date2[$j] = mktime(0,0,0,substr($tab_date2[$j], 5, -3),substr($tab_date2[$j], 8, 10),substr($tab_date2[$j], 0, 4));
				$tab_HD2[$j] = new DateTime($tab_HD2[$j]);
				$tab_HF2[$j] = new DateTime($tab_HF2[$j]);
		
			}
						
					
			$traitement = Calcul_heures ($tab_HD2, $tab_HF2, $tab_date2);
			$jour = $traitement[0];
			$dimanche = $traitement[1];
			$nuit = $traitement[2];
			$array = Traitement ($jour, $dimanche, $nuit, $payer);
			
			for ($j=0 ; $j < $taille ; $j++) {
				
				if($payer[$j] == 1){
				
					$payer[$j] = 'Oui';
					
				}else{
				
					$payer[$j] = 'Non';
					
				}
			
			}
					
			$array[] = $array[0] - $array[6] ;
			$array[] = $array[3] - $array[9] ;
							
			$array[] = $array[1] - $array[7] + $array[4] - $array[10] ;

			$array[] = $array[2] - $array[8] + $array[5] - $array[11] ;
					
					
			echo '<div class="tableau">
			<table class="table table-striped table-condensed" border="3">
		
					<thead>
						<tr>
						<th rowspan="3"><b>NOM - PRENOM</b></th><th rowspan="3"><b>DATE</b></th>
									<th rowspan="3"><b>OBJET</b></th><th rowspan="3"><b>HORAIRE</b></th><th rowspan="3"><b>PAYER</b></th><th colspan="4"><b>JOUR</b></th><th colspan="4"><b>DIMANCHE</b></th><th colspan="4"><b>NUIT*</b></th>
									
									</tr>
							<tr>

									<th colspan="2"><b>-14</b></th><th colspan="2"><b>+14</b></th><th colspan="2"><b>Payé</b></th><th rowspan="2" colspan="2"><b>Recupéré</b></th><th colspan="2"><b>Payé</b></th><th rowspan="2" colspan="2"><b>Récupéré</b></th>
							</tr>		
							<tr>		
									<th width="120"><b>Payé</b></th><th><b>Récupéré</b></th><th width="120"><b>Payé</b></th><th><b>Récupéré</b></th><th><b>-14</b></th><th><b>+14</b></th><th><b>-14</b></th><th><b>+14</b></th>

								</tr>	
					</thead>';
					

			for ($z=0 ; $z < $taille ; $z++) {

				if($z == 0){
				
					echo '<tr><td rowspan="'.$taille.'">'.$nom.' '.$prenom.'</td><td>'.substr($tab_date3[$z], 8, 10).'/'.substr($tab_date3[$z], 5, -3).'/'.substr($tab_date3[$z], 0, 4).'</td><td>'.$categorie_evenement[$z].'</td><td>'.substr($tab_HD3[$z], 0, 5).' - '.substr($tab_HF3[$z], 0, 5).'</td><td>'.$payer[$z].'</td><td rowspan="'.$taille.'">'.number_format($array[6]/60,2).'</td><td id="recupjour1" rowspan="'.$taille.'">'.number_format($array[12]/60,2).'</td><td rowspan="'.$taille.'">'.number_format($array[9]/60,2).'</td><td id="recupjour2" rowspan="'.$taille.'">'.number_format($array[13]/60,2).'</td><td rowspan="'.$taille.'">'.number_format($array[7]/60,2).'</td><td rowspan="'.$taille.'">'.number_format($array[10]/60,2).'</td><td id="recupdim" rowspan="'.$taille.'" colspan="2">'.number_format($array[14]/60,2).'</td><td rowspan="'.$taille.'">'.number_format($array[8]/60,2).'</td><td rowspan="'.$taille.'">'.number_format($array[11]/60,2).'</td><td id="recupnuit" rowspan="'.$taille.'" colspan="2">'.number_format($array[15]/60,2).'</td>';
				
				}else{
				
					echo '<tr><td>'.substr($tab_date3[$z], 8, 10).'/'.substr($tab_date3[$z], 5, -3).'/'.substr($tab_date3[$z], 0, 4).'</td><td>'.$categorie_evenement[$z].'</td><td>'.substr($tab_HD3[$z], 0, 5).' - '.substr($tab_HF3[$z], 0, 5).'</td><td>'.$payer[$z].'</td></tr>';
					
				}

			}

			unset($tab_date2);
			unset($tab_HD2);
			unset($tab_HF2);
			unset($payer);
			unset($categorie_evenement);
					
			echo '</table>
					</div>';
			
			echo 'Total des Heures à récupérer = '.number_format((($array[12]+$array[13]*1.25+$array[14]*1.75+$array[15]*2))/60,2).'</br>';
		
		}
				
		$st -> closeCursor();
		$connexion = null;

	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}

	echo '</br>* correspondant aux heures effectuées entre '. $traitement[3]->diff(new DateTime("00:00:00"))->format('%hH%I').' et '. $traitement[4]->diff(new DateTime("00:00:00"))->format('%hH%I');
	
}


// fonction qui prend en paramètres un tableau contenant les ID des agents et qui affiche sous forme de tableau les données à transmettre au Service Paye
function Excel($id){

	$excel = array ( array ('MATRICULE', 'COLLECTIVITE', 'PERIODE', 'RUBRIQUE', 'QUANTITE') );
	try
	{

		$connexion = Get_cnx();
		$tab_date2 = array();
		$tab_HD2 = array();
		$tab_HF2 = array();
		$payer = array();

		if (isset ($_GET['Mois'])){
		
			$periode = $_GET['Annee'].'-'.$_GET['Mois'];
			
		}else{
		
			$periode = substr(date("Y-m-d"), 0, 7);
			
		}
		
		echo '<div class="tableau">
			<table class="table table-striped table-condensed" border="3">
		
					<thead>
						<tr>
						<th><b>MATRICULE</b></th><th><b>COLLECTIVITE</b></th>
									<th><b>PERIODE</b></th><th><b>RUBRIQUE</b></th><th><b>QUANTITE</b></th>
									
									</tr>

									</thead>';
		
		$taille_id = count($id);

		for ($i = 0 ; $i < $taille_id ; $i++) {
			
			$tab_date2 = array();
			$tab_HD2 = array();
			$tab_HF2 = array();
			$payer = array();
			$categorie_evenement = array();
			
			try
			{
				
				$req = 'SELECT Matricule, Collectivite FROM Collectivite A, Agent B WHERE A.ID_Collectivite=B.ID_Collectivite AND ID_Agent ='.$id[$i];
				$st = $connexion->query($req);
				while ($obj = $st->fetch(PDO::FETCH_OBJ)){
				
					$matricule = $obj->Matricule;
					$collectivite = $obj->Collectivite;
				}
				$st -> closeCursor();

			}	
			catch(Exception $f)
			{
				echo 'err : '.$f->getMessage().'<br />';
			}
			

			
			
			
			$req = 'SELECT * FROM Evenement A, Agent_Evenement B WHERE A.ID_Evenement=B.ID_Evenement AND Date LIKE "'.$periode.'%" AND ID_Agent = "'.$id[$i].'" ORDER BY Date ASC';  //////////////////////////////// MODIFIER
			$st = $connexion->query($req);
			while($obj = $st->fetch(PDO::FETCH_OBJ)){
			
				$tab_date2[] = $obj->Date;
				$tab_HD2[] = $obj->Heure_Debut;
				$tab_HF2[] = $obj->Heure_Fin;
				$payer[] = $obj->Payer;
				$categorie_evenement[] = $obj->Categorie_Evenement;
			
			}

			$tab_HD3 = $tab_HD2;
			$tab_HF3 = $tab_HF2;
			$tab_date3 = $tab_date2;
			
			$taille = count($tab_HD2);

			for ($j = 0 ; $j < $taille ; $j++) {
					
			$tab_date2[$j] = mktime(0,0,0,substr($tab_date2[$j], 5, -3),substr($tab_date2[$j], 8, 10),substr($tab_date2[$j], 0, 4));
			$tab_HD2[$j] = new DateTime($tab_HD2[$j]);
			$tab_HF2[$j] = new DateTime($tab_HF2[$j]);
		
			}
						
					
			$traitement = Calcul_heures ($tab_HD2, $tab_HF2, $tab_date2);
			$jour = $traitement[0];
			$dimanche = $traitement[1];
			$nuit = $traitement[2];
			$array = Traitement ($jour, $dimanche, $nuit, $payer);
			$array2 = array ($array[6],$array[9],$array[7],$array[10],$array[8],$array[11],);
					

			for ($z=0 ; $z < $taille ; $z++) {
			
				if($z==0 AND $array2[$z]> 0){
				
					echo '<tr><td>'.$matricule.'</td><td>'.$collectivite.'</td><td>'.$periode.'</td><td>401.01</td><td>'.number_format($array2[$z]/60,1).'</td>';
					$excel[] = array ($matricule,$collectivite,$periode, "401.01",number_format($array2[$z]/60,1));

				}
				if($z==1 AND $array2[$z]> 0){
				
					echo '<tr><td>'.$matricule.'</td><td>'.$collectivite.'</td><td>'.$periode.'</td><td>402.01</td><td>'.number_format($array2[$z]/60,1).'</td>';
					$excel[] = array ($matricule,$collectivite,$periode, "402.01",number_format($array2[$z]/60,1));

				}
				if($z==2 AND $array2[$z]> 0){
				
					echo '<tr><td>'.$matricule.'</td><td>'.$collectivite.'</td><td>'.$periode.'</td><td>403.00</td><td>'.number_format($array2[$z]/60,1).'</td>';
					$excel[] = array ($matricule,$collectivite,$periode, "403.00",number_format($array2[$z]/60,1));

				}
				if($z==3 AND $array2[$z]> 0){
				
					echo '<tr><td>'.$matricule.'</td><td>'.$collectivite.'</td><td>'.$periode.'</td><td>403.02</td><td>'.number_format($array2[$z]/60,1).'</td>';
					$excel[] = array ($matricule,$collectivite,$periode, "403.02",number_format($array2[$z]/60,1));

				}
				if($z==4 AND $array2[$z]> 0){
				
					echo '<tr><td>'.$matricule.'</td><td>'.$collectivite.'</td><td>'.$periode.'</td><td>404.00</td><td>'.number_format($array2[$z]/60,1).'</td>';
					$excel[] = array ($matricule,$collectivite,$periode, "404.00",number_format($array2[$z]/60,1));

				}
				if($z==5 AND $array2[$z]> 0){
				
					echo '<tr><td>'.$matricule.'</td><td>'.$collectivite.'</td><td>'.$periode.'</td><td>404.02</td><td>'.number_format($array2[$z]/60,1).'</td>';
					$excel[] = array ($matricule,$collectivite,$periode, "404.02",number_format($array2[$z]/60,1));

				}

			}
					
			unset($tab_date2);
			unset($tab_HD2);
			unset($tab_HF2);
			unset($payer);
			unset($categorie_evenement);
						
		}
		
		echo '</table>
				</div>';
			
		$st -> closeCursor();
		$connexion = null;

	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}

	echo '* correspondant aux heures effectuées entre '. $traitement[3]->diff(new DateTime("00:00:00"))->format('%hH%I').' et '. $traitement[4]->diff(new DateTime("00:00:00"))->format('%hH%I');

	return $excel;

}


?>