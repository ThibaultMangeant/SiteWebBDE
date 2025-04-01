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
			'evenement' => $this->evenement->__serialize(),
			'utilisateur' => $this->utilisateur->__serialize(),
			'note' => $this->note,
			'commentaire' => $this->commentaire
		];
	}
	public function __unserialize(array $data): void
	{
		$this->evenement = new Evenement(0,"","",new DateTime(),"",0.0,new Role("",0));
		$this->evenement->__unserialize($data['evenement']);
		$this->utilisateur = new Utilisateur(0,"","","","","","", new Role("",0), true);
		$this->utilisateur->__unserialize($data['utilisateur']);
		$this->note = $data['note'];
		$this->commentaire = $data['commentaire'];
	}
	public function __toString(): string
	{
		return "Inscription: {$this->evenement}, Utilisateur: {$this->utilisateur}, Note: {$this->note}, Commentaire: {$this->commentaire}";
	}
}