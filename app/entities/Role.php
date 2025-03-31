<?php

class Role 
{
	public function __construct(private String $nomRole) {}

	public function getNomRole(): string { return $this->nomRole; }
	public function setNomRole(string $nomRole): void {	$this->nomRole = $nomRole; }
}