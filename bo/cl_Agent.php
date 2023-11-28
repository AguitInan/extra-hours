<?php

class Agent
{
	private $nom;
	private $prenom;
	
	public function Getnom()
	{
		return $this->nom;
	}
	public function Setnom($nvo_nom)
	{
		$this->nom = $nvo_nom;
	}
	public function Getprenom()
	{
		return $this->prenom;
	}
	public function Setprenom($nvo_prenom)
	{
		$this->prenom = $nvo_prenom;
	}	
}
?>