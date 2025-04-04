<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ActualiteRepository.php';
require_once './app/entities/Role.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';
require_once './app/services/AuthService.php';

class ActualiteController extends Controller
{

	use FormTrait;
	use AuthTrait;

	public function index()
	{
		$repository = new ActualiteRepository();
		$actualites = $repository->findAll();

		$service = new AuthService();
		$isAdmin = $service->isAdmin();

		// Ensuite, affiche la vue
		$this->view('/gestionActualite.html.twig',  ['actualites' => $actualites, 'isAdmin' => $isAdmin]);
	}


	public function create()
	{
		$repository = new ActualiteRepository();
		
		$service = new AuthService();
		$isAdmin = $service->isAdmin();

		$actualite = new Actualite(0, "VIDE", "VIDE");

		// Sauvegarde dans la base de données
		if (!$repository->create($actualite))
		{
			throw new Exception(message: 'Erreur lors de l\'enregistrement de l\'actualité.');
		}

		$actualites = $repository->findAll();
		// Affichage du formulaire
		$this->view('/gestionActualite.html.twig',  ['actualites' => $actualites, 'isAdmin' => $isAdmin]);
	}

	public function update()
	{
		if (isset($_POST['idActu']))
		{
			$idActu = $this->getPostParam('idActu');
			// Vérifiez si $idActu existe dans votre base de données et continuez le traitement
		}
		else
		{
			// Gérer le cas où l'ID n'est pas envoyé
			echo "L'ID de l'actualité est manquant.";
		}

		if (!$idActu)
		{
			throw new Exception('ID de l\'actualité manquant.');
		}

		$repository = new ActualiteRepository();
		$actualite = $repository->findById($idActu);

		if ($actualite === null)
		{
			throw new Exception('Actualité non trouvé');
		}

		$data = array_merge([
			'idActu'   =>$actualite->getIdActu(),
			'titreActu'=>$actualite->getTitreActu(),
			'descActu' =>$actualite->getDescActu(),
		],$this->getAllPostParams()); //Get submitted data
		$errors = [];



		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			try
			{
				// Validation des données
				if (empty($data['titreActu']))
				{
					$errors[] = 'Le titre de l\'actualité est requis.';
				}
				if (empty($data['descActu']))
				{
					$errors[] = 'La description de l\'actualité est requis.';
				}

				if (!empty($errors))
				{
					throw new Exception(implode(', ', $errors));
				}

				// Mise à jour de l'objet Actualité
				$actualite->setIdActu   ($idActu);
				$actualite->setTitreActu($data['titreActu']);
				$actualite->setDescActu ($data['descActu']);


				// Sauvegarde dans la base de données
				if (!$repository->update($actualite))
				{
					throw new Exception('Erreur lors de la mise à jour de l\'actualité.');
				}

				$this->redirectTo('/gestionActualite.php'); // Redirection après mise à jour
			}
			catch (Exception $e)
			{
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}

		// Affichage du formulaire de mise à jour
		$this->view('/gestionActualite.html.twig', ['data' => $data, 'errors' => $errors, 'idActu' => $idActu]);
	}

	public function delete()
	{
		$idActu = $this->getQueryParam('idActu');

		$repository = new ActualiteRepository();
		$actualite = $repository->findById($idActu);

		if ($actualite === null)
		{
			throw new Exception('Actualité non trouvé');
		}

		try
		{
			if (!$repository->deleteById($actualite->getIdActu()))
			{
				throw new Exception('Erreur lors de la suppression de l\'actualité.');
			}

			$this->redirectTo('/gestionActualite.php'); // Redirection après suppression
		}
		catch (Exception $e)
		{
			$this->view('/gestionActualite.html.twig', [
				'errors' => [$e->getMessage()]
			]);
		}
	}
}
