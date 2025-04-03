<?php

require_once './app/core/Controller.php';
require_once './app/repositories/UtilisateurRepository.php';
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
			'idEvent' => $this->getQueryParam('idEvent')
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

				$idEvent       = $data['idEvent'];
				$idUtilisateur = $data['idUtilisateur'];

				// Création de l'objet commande
				$event       = new EvenementRepository()->findById($idEvent);
				$inscription = new Inscription($event, $utilisateur,  -1, null);

				// Sauvegarde dans la base de données
				$inscriptionRepo = new InscriptionRepository();

				// Vérifie que l'utilisateur n'est pas déjà inscrit
				if ($inscriptionRepo->findByUtilisateurAndEvenement($idUtilisateur, $idEvent) !== null)
				{
					$inscription = null;
					$this->redirectTo('detailEvenement.php?idEvent=' + $idEvent); // Redirection si l'utilisateur est déjà inscrit
				}
				elseif (!$inscriptionRepo->create($inscription))
				{
					throw new Exception(message: 'Erreur lors de l\'enregistrement de la commande.');
				}

				$this->redirectTo('detailEvenement.php?idEvent=' + $idEvent); // Redirection après création
			}
			catch (Exception $e)
			{
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}
	}

	public function update()
	{
		$idEvent = $this->getQueryParam('idEvent');

		$eventRepository = new EvenementRepository();
		$evenement       = $eventRepository->findById($idEvent);

		if ($evenement === null)
			throw new Exception('Evennement non trouvé');

		$errors = [];

		$data = array_merge([
			'idEvent' => $this->getQueryParam('idEvent')
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
				if (empty($data['note']))
				{
					$errors[] = 'La note de l\'avis sur l\'évenement est requis.';
				}
				if (empty($data['commentaire']))
				{
					$errors[] = 'Le commentaire de l\'avis sur l\'évenement est requis.';
				}

				if (!empty($errors))
				{
					throw new Exception(implode(', ', $errors));
				}

				$idEvent       = $data['idEvent'];
				$idUtilisateur = $data['idUtilisateur'];


				// Mise à jour de l'objet inscription
				$inscriptionRepo = new InscriptionRepository();
				$inscription = $inscriptionRepo->findByUtilisateurAndEvenement($idUtilisateur, $idEvent);

				if ($inscription == null)
					throw new Exception('Inscription non trouvé');

				// Sauvegarde dans la base de données
				if (!$inscriptionRepo->update($data['note'], $data['commentaire']))
				{
					throw new Exception(message: 'Erreur lors de l\'enregistrement de l\'avis.');
				}

				$this->redirectTo('detailEvenement.php?idEvent=' + $idEvent); // Redirection après mise à jour
			}
			catch (Exception $e)
			{
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
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