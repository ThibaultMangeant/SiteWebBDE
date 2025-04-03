<?php

require_once './app/core/Controller.php';
require_once './app/repositories/InscriptionRepository.php';
require_once './app/entities/Utilisateur.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class InscriptionController extends Controller
{

	use FormTrait;
	use AuthTrait;

	public function create()
	{
		$errors = [];

		$data = array_merge([
			'idEvent'   => $this->getQueryParam('idEvent'),
			'prixEvent' => $this->getQueryParam('prixEvent')
		], $this->getAllPostParams()); //Get submitted data

		$utilisateur = (new AuthService())->getUtilisateur();
		$data['idUtilisateur'] = $utilisateur->getNetud();

		if (!empty($data))
		{
			try
			{
				$errors = [];

				// Validation des données
				if (empty($data['idEvent']))
				{
					$errors[] = 'L\'idEvent est requis.';
				}
				if (empty($data['idUtilisateur']))
				{
					$errors[] = 'L\'idUtilisateur est requis.';
				}
				if (empty($data['prixEvent']))
				{
					$errors[] = 'Le prix de l\'évenement est requis.';
				}

				if (!empty($errors))
				{
					throw new Exception(implode(', ', $errors));
				}

				$idEvent       = $this->getQueryParam('idEvent'      );
				$idUtilisateur = $data['idUtilisateur'];

				// Création de l'objet commande
				$event       = (new EvenementRepository())->findById($idEvent);
				$inscription = new Inscription($event, $utilisateur,  0, "");

				// Sauvegarde dans la base de données
				$inscriptionRepo = new InscriptionRepository();

				// Vérifie que l'utilisateur n'est pas déjà inscrit
				if ($inscriptionRepo->findByUtilisateurAndEvenement($idUtilisateur, $idEvent) !== null)
				{
					$this->redirectTo('detailEvenement.php?idEvent='.$idEvent); // Redirection si l'utilisateur est déjà inscrit
				}
				else
				{
					if (!$inscriptionRepo->create($inscription))
					{
						throw new Exception(message: 'Erreur lors de l\'enregistrement de l\'inscription.');
					}
				}

				$this->redirectTo('detailEvenement.php?idEvent='.$idEvent); // Redirection après création
			}
			catch (Exception $e)
			{
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}
		else
		{
			throw new Exception("Données vides");
		}
	}

	public function update()
	{
		$idEvent = $this->getQueryParam('idEvent');

		$eventRepository = new EvenementRepository();
		$evenement       = $eventRepository->findById($idEvent);

		if ($evenement === null)
			throw new Exception('Evenement non trouvé');

		$errors = [];

		$data = array_merge([
			'idEvent'     => $this->getQueryParam('idEvent'),
			'note'        => $this->getQueryParam('note'),
			'commentaire' => $this->getQueryParam('commentaire')
		], $this->getAllPostParams()); //Get submitted data

		$utilisateur = (new AuthService())->getUtilisateur();
		$data['idUtilisateur'] = $utilisateur->getNetud();

		if (!empty($data))
		{
			try
			{
				$errors = [];

				// Validation des données
				if (empty($data['idEvent']))
				{
					$errors[] = 'L\'idEvent est requis.';
				}
				if (empty($data['idUtilisateur']))
				{
					$errors[] = 'L\'idUtilisateur est requis.';
				}
				if (empty($data['note']))
				{
					$errors[] = 'La note de l\'avis sur l\'évenement est requis.';
				}

				$note = $data['note'];
				if (!is_numeric($note))
				{
					$errors[] = 'La note doit être un nombre.';
				}
				else
				{
					// Convertir la note en entier et vérifier si elle est dans la plage
					$note = (int) $note;
					if ($note < 1 || $note > 5)
					{
						$errors[] = 'La note doit être un nombre compris entre 1 et 5';
					}
				}
				if (empty($data['commentaire']))
				{
					$errors[] = 'Le commentaire de l\'avis sur l\'évenement est requis.';
				}

				if (!empty($errors))
				{
					throw new Exception(implode(', ', $errors));
				}

				$idUtilisateur = $data['idUtilisateur'];


				// Mise à jour de l'objet inscription
				$inscriptionRepo = new InscriptionRepository();
				$inscription = $inscriptionRepo->findByUtilisateurAndEvenement($idUtilisateur, $idEvent);

				if ($inscription == null)
					throw new Exception('Inscription non trouvé');


				$inscription->setNote($note);
				$inscription->setCommentaire($data['commentaire']);

				// Sauvegarde dans la base de données
				if (!$inscriptionRepo->update($inscription))
				{
					throw new Exception(message: 'Erreur lors de l\'enregistrement de l\'avis.');
				}

				$this->redirectTo('detailEvenement.php?idEvent='.$idEvent); // Redirection après mise à jour
			}
			catch (Exception $e)
			{
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}
		else
		{
			throw new Exception("Données vide");
		}
	}

	public function delete()
	{
		$idEvent = $this->getQueryParam('idEvent');

		$utilisateur = (new AuthService())->getUtilisateur();
		$idUtilisateur = $utilisateur->getNetud();

		$eventRepository = new EvenementRepository();
		$evenement       = $eventRepository->findById($idEvent);

		if ($evenement === null)
			throw new Exception('Evennement non trouvé');
		
		$inscriptionRepo = new InscriptionRepository();
		$inscription = $inscriptionRepo->findByUtilisateurAndEvenement($idUtilisateur, $idEvent);

		if ($inscription == null)
			throw new Exception('Inscription non trouvé');

		// Mise à jour en base de données
		if (!$inscriptionRepo->deleteByUtilisateurAndEvenement($idUtilisateur, $idEvent))
		{
			throw new Exception('Erreur lors de la suppression de l\'inscription');
		}

		$this->redirectTo('detailEvenement.php?idEvent=' + $idEvent); // Redirection après suppression
	}
}