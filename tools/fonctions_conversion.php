<?php

//Convertit un tableau associatif en chaine de caractères (pour WHERE du SELECT, pour WHERE du UPDATE, pour WHERE du DELETE)


function toString_WHERE ($array)
{
	$var="";
	foreach($array as $cle => $element)
	{
		$last_key = end(array_keys($array));
		if($cle == $last_key){
			$var .= $cle .' = '.'"'.$element.'"';
		}else{
			$var .= $cle .' = '.'"'. $element.'"'.' AND ';
		}
	}

	return $var;
}
	
	
//Convertit un tableau en chaine de caractères (pour les CHAMPS du SELECT)


function toString_CHAMPS ($array)
{
	$var="";
	foreach($array as $cle => $element)
	{
		$last_key = end(array_keys($array));
		if($cle == $last_key){
			$var .= $element;
		}else{
			$var .= $element.', ';
		}
	}

	return $var;
}

	
//Convertit un tableau associatif en chaine de caractères (pour VALUES du INSERT INTO)


function toString_VALUES ($array)
{
	$var="(";
	foreach($array as $cle => $element)
	{
		$last_key = end(array_keys($array));
		if($cle == $last_key){
			$var .='"'. $element.'"'.' )';
		}else{
			$var .= '"'.$element.'"'.', ';
		}
	}

	return $var;
}

	
//Convertit un tableau associatif en chaine de caractères (pour SET du UPDATE)


function toString_SET ($array)
{
	$var="";
	foreach($array as $cle => $element)
	{
		$last_key = end(array_keys($array));
		if($cle == $last_key){
			$var .= $cle .' = '.'"'.$element.'"';
		}else{
			$var .= $cle .' = '.'"'. $element.'", ';
		}
	}

	return $var;
}
	
	
?>