<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ProduitRepository.php';
require_once './app/entities/Produit.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class ProduitController extends Controller {

	use FormTrait;
	use AuthTrait;

	public function index() {
		$repository = new ProduitRepository();
		$produits = $repository->findAll();

        // Ensuite, affiche la vue
        $this->view('/produit/gestionProduits.html.twig',  ['produits' => $produits]);
        
    }


	public function create() {
		$data = $this->getAllPostParams(); // Récupération des données soumises
		$errors = [];

		if (!empty($data)) {
			try {
				$errors = [];

				// Validation des données
				if (empty($data['nomProd'])) {
					$errors[] = 'Le nom du produit est requis.';
				}
				if (empty($data['qs']) || !is_numeric($data['qs'])) {
					$errors[] = 'Le quantité en stock doit être valide.';
				}
				if (empty($data['prixProd']) || !is_numeric($data['prixProd'])) {
					$errors[] = 'Le prix du produit doi être valide.';
				}
				if (empty($data['imgProd'])) {
					$errors[] = 'Le produit nécessite une image.';
				}

				if (!empty($errors)) {
					throw new Exception(implode(', ', $errors));
				}

				// Création de l'objet utilisateur
				$produit = new Produit(0, $data['nomProd'], (int)$data['qs'], (float)$data['prixProd'], $data['imgProd']);

				// Sauvegarde dans la base de données
				$produitRepo = new ProduitRepository();
				if (!$produitRepo->create($produit)) {
					throw new Exception('Erreur lors de l\'enregistrement du produit.');
				}

				$this->redirectTo('produits.php'); // Redirection après création
			} catch (Exception $e) {
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}

		// Affichage du formulaire
		$this->view('/produit/form.html.twig',  [
			'data' => $data,
			'errors' => $errors,
		]);
	}

	public function update()
	{
		$idProd = $this->getQueryParam('idProd');

		$repository = new ProduitRepository();
		$produit = $repository->findById($idProd);

		if ($produit === null) {
			throw new Exception('Produit non trouvé');
		}

		$data = array_merge([
			'idProd'=>$produit->getIdProd(),
			'nomProd'=>$produit->getNomProd(),
			'qs'=>$produit->getQs(),
			'prixProd'=>$produit->getPrixProd(),
			'imgProd'=>$produit->getImgProd()
		],$this->getAllPostParams()); //Get submitted data
		$errors = [];

		if (!empty($this->getAllPostParams())) {
			try {
				$errors = [];

				// Data validation
				if (empty($data['nomProd'])) {
					$errors[] = 'Le nom du produit est requis.';
				}
				if (empty($data['qs']) || !is_numeric($data['qs'])) {
					$errors[] = 'Le quantité en stock doit être valide.';
				}
				if (empty($data['prixProd']) || !is_numeric($data['prixProd'])) {
					$errors[] = 'Le prix du produit doit être valide.';
				}
				if (empty($data['imgProd'])) {
					$errors[] = 'Le produit nécessite une image.';
				}

				if (!empty($errors)) {
					throw new Exception(implode(', ', $errors));
				}

				// Mise à jour de l'objet produit
				$produit->setNomProd($data['nomProd']);
				$produit->setQs((int)$data['qs']);
				$produit->setPrixProd((float)$data['prixProd']);
				$produit->setImgProd($data['imgProd']);

				// Sauvegarde dans la base de données
				if (!$repository->update($produit)) {
					throw new Exception('Erreur lors de la mise à jour du produit.');
				}

				$this->redirectTo('produits.php'); // Redirect after update

			} catch (Exception $e) {
				$errors = explode(', ', $e->getMessage()); // Error retrieval
			}
		}

		// Display update form
		$this->view('/produit/form.html.twig',  ['data' => $data, 'errors' => $errors, 'idProd' => $idProd]);
	}

	public function delete()
	{
		$idProd = $this->getQueryParam('idProd');

		$repository = new ProduitRepository();
		$produit = $repository->findById($idProd);

		if ($produit === null) {
			throw new Exception('Produit non trouvé');
		}

		try {
			if (!$repository->deleteById($produit->getIdProd())) {
				throw new Exception('Erreur lors de la suppression du produit.');
			}

			$this->redirectTo('produits.php'); // Redirection après suppression
		} catch (Exception $e) {
			$this->view('/produit/gestionProduits.html.twig', [
				'errors' => [$e->getMessage()]
			]);
		}
	}
}
