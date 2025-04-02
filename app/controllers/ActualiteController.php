<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ActualiteRepository.php';
require_once './app/entities/Role.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class ActualiteController extends Controller
{

	use FormTrait;
	use AuthTrait;

	public function index()
	{
		$repository = new ActualiteRepository();
		$actualites = $repository->findAll();

		// Ensuite, affiche la vue
		$this->view('/gestionActualite.html.twig',  ['actualites' => $actualites]);
	}


	public function create()
	{
		$errors = [];

		$data = $this->getAllPostParams();

		if (!empty($data))
		{
			try
			{
				$errors = [];

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

				// Création de l'objet Actualite
				$actualite = new Actualite(0, $data['titreActu'], $data['descActu']);

				// Sauvegarde dans la base de données
				$actualiteRepo = new ActualiteRepository();
				if (!$actualiteRepo->create($actualite))
				{
					throw new Exception(message: 'Erreur lors de l\'enregistrement de l\'actualité.');
				}

				$this->redirectTo('/gestionActualite.php'); // Redirection après création
			}
			catch (Exception $e)
			{
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}

		// Affichage du formulaire
		$this->view('/gestionActualite.html.twig',  [
			'data' => $data,
			'errors' => $errors,
		]);
	}

	public function update()
	{
		$idActu = $this->getQueryParam('idActu');

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
