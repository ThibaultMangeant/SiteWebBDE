<?php

require_once './app/core/Controller.php';
require_once './app/repositories/CommandeRepository.php';
require_once './app/entities/Commande.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class UtilisateurController extends Controller {

    use FormTrait;
    use AuthTrait;

	public function index() {
		$repository = new CommandeRepository();
		$utilisateur = (new AuthService())->getUtilisateur();
		
		if ($utilisateur != null) {
			$commandes = $repository->findByUtilisateur($utilisateur->getNetud());
		}
		// Ensuite, affiche la vue
		$this->view('panier.html.twig',  ['commandes' => $commandes]);	
	}

	public function create() {
		$errors = [];

		$data = $this->getAllPostParams();

		if (!empty($data)) {
			try {
				$errors = [];

				// Validation des données
				if (empty($data['qa']) || !is_numeric($data['qa'])) {
					$errors[] = 'La quantité d\'achat doit être valide.';
				}
				if (empty($data['idProduit'])) {
					$errors[] = 'La description de l\'évènement est requis.';
				}
				if (empty($data['idUtilisateur'])) {
					$errors[] = 'La date de l\'évènement est requis.';
				}

				if (!empty($errors)) {
					throw new Exception(implode(', ', $errors));
				}

				// Création de l'objet evenement
				$commande = new Commande(0, (int)$data['qa'],(new ProduitRepository())->findById($data['idProduit']),(new UtilisateurRepository())->findById($data['idUtilisateur']));

				// Sauvegarde dans la base de données
				$commandeRepo = new CommandeRepository();
				if (!$commandeRepo->create($commande)) {
					throw new Exception(message: 'Erreur lors de l\'enregistrement de la commande.');
				}

				$this->redirectTo('boutique.php'); // Redirection après création
			} catch (Exception $e) {
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}

		// Affichage du formulaire
		$this->view('/evenement/form.html.twig', [
			'data' => $data,
			'errors' => $errors,
		]);
	}
}