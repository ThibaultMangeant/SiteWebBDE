<?php

class Inscription
{
	public function __construct(private Evenement $evenement, private Utilisateur $utilisateur, private int $note, private string $commentaire) {}

	// Getters
	public function getEvenement(): Evenement { return $this->evenement; }
	public function getUtilisateur(): Utilisateur { return $this->utilisateur; }
	public function getNote(): int { return $this->note; }
	public function getCommentaire(): string { return $this->commentaire; }


	// Setters
	public function setEvenement(Evenement $evenement): void { $this->evenement = $evenement; }
	public function setUtilisateur(Utilisateur $utilisateur): void { $this->utilisateur = $utilisateur;	}
	public function setNote(int $note): void { $this->note = $note;	}
	public function setCommentaire(string $commentaire): void { $this->commentaire = $commentaire; }

	public function __serialize(): array
	{
		return [
			'evenement' => $this->evenement,
			'utilisateur' => $this->utilisateur,
			'note' => $this->note,
			'commentaire' => $this->commentaire
		];
	}
	public function __unserialize(array $data): void
	{
		$this->evenement = $data['evenement'];
		$this->utilisateur = $data['utilisateur'];
		$this->note = $data['note'];
		$this->commentaire = $data['commentaire'];
	}
	public function __toString(): string
	{
		return "Inscription: {$this->evenement}, Utilisateur: {$this->utilisateur}, Note: {$this->note}, Commentaire: {$this->commentaire}";
	}
}