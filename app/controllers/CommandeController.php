<?php

require_once './app/core/Controller.php';
require_once './app/repositories/CommandeRepository.php';
require_once './app/repositories/RoleRepository.php';
require_once './app/repositories/ProduitRepository.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/entities/Commande.php';
require_once './app/entities/Utilisateur.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class CommandeController extends Controller {

    use FormTrait;
    use AuthTrait;

	public function index()
	{
		$repository = new CommandeRepository();
		$service = new AuthService();
		$utilisateur = $service->getUtilisateur();
		$isLoggedIn = $service->isLoggedIn();

		$commandes = [];
		$total = 0;
		if ($utilisateur != null)
		{
			$commandes = $repository->findByUtilisateur($utilisateur->getNetud());
			$total = $repository->getTotal($utilisateur->getNetud());
		}

		// Ensuite, affiche la vue
		$this->view('panier/panier.html.twig',  ['commandes'    => $commandes,
															'Total'      => $total,
															'isLoggedIn' => $isLoggedIn]);
	}

	public function create() {
		$errors = [];

		$data = array_merge([
			'idProd' => $this->getQueryParam('idProd')
		], $this->getAllPostParams()); //Get submitted data

		$data['idUtilisateur'] = (new AuthService())->getUtilisateur()->getNetud();

		if (!empty($data)) {
			try {
				$errors = [];

				// Validation des données
				if (empty($data['qa']) || !is_numeric($data['qa'])) {
					$errors[] = 'La quantité d\'achat doit être valide.';
				}
				if (empty($data['idProd'])) {
					$errors[] = 'L\'idProd est requis.';
				}
				if (empty($data['idUtilisateur'])) {
					$errors[] = 'L\'idUtilisateur est requis.';
				}

				if (!empty($errors)) {
					throw new Exception(implode(', ', $errors));
				}

				// Création de l'objet commande
				$qa = (int)($data['qa']);
				if ($qa > (new ProduitRepository())->findById($data['idProd'])->getQs()) {
					$qa = (new ProduitRepository())->findById($data['idProd'])->getQs();
				}
				$commande = new Commande(0, $qa,(new ProduitRepository())->findById($data['idProd']),(new UtilisateurRepository())->findById($data['idUtilisateur']));

				// Sauvegarde dans la base de données
				$commandeRepo = new CommandeRepository();

				if ($commandeRepo->findByProduitAndUtilisateur($data['idProd'], $data['idUtilisateur']) !== null) {
					$commande = $commandeRepo->findByProduitAndUtilisateur($data['idProd'], $data['idUtilisateur']);

					$qa = $commande->getQa() +(int)($data['qa']);

					if ($qa > $commande->getProduit()->getQs()) {
						$qa = $commande->getProduit()->getQs();
					}

					$commande->setQa($qa);
					$commandeRepo->update($commande);
				}
				elseif (!$commandeRepo->create($commande)) {
					throw new Exception(message: 'Erreur lors de l\'enregistrement de la commande.');
				}

				$this->redirectTo('boutique.php'); // Redirection après création
			} catch (Exception $e) {
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}
	}

	public function update() {
		$idCommande = $this->getQueryParam('idCommande');
		$change     = (int)($this->getQueryParam('change'));

		if ($idCommande === null) {
			throw new Exception('Commande non trouvée');
		}
		$repository = new CommandeRepository();
		$commande = $repository->findById($idCommande);

		if ($commande === null) {
			throw new Exception('Commande non trouvée');
		}

		$errors = [];

		$data = array_merge([
			'idCommande' => $commande->getNumCommande(),
			'qa' => $commande->getQa(),
			'idProduit' => $commande->getProduit()->getIdProd(),
			'idUtilisateur' => $commande->getUtilisateur()->getNetud()
		], $this->getAllPostParams()); //Get submitted data

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
				var_dump($data);
				// Création de l'objet evenement
				$commande->setQa((int)$data['qa']+$change);
				if ($commande->getQa() > $commande->getProduit()->getQs()) {
					$commande->setQa($commande->getProduit()->getQs());
				} elseif ($commande->getQa() <= 0) {
					$commande->setQa(1);
				}
				$commande->setProduit((new ProduitRepository())->findById($data['idProduit']));
				$commande->setUtilisateur((new UtilisateurRepository())->findById($data['idUtilisateur']));

				// Sauvegarde dans la base de données
				$commandeRepo = new CommandeRepository();
				if (!$commandeRepo->update($commande)) {
					throw new Exception(message: 'Erreur lors de l\'enregistrement de la commande.');
				}

				$this->redirectTo('panier.php'); // Redirection après création
			} catch (Exception $e) {
				$errors = explode(', ', $e->getMessage()); // Récupération des erreurs
			}
		}
	}

	public function delete() {
		$idCommande = $this->getQueryParam('idCommande');
		
		if ($idCommande === null) {
			throw new Exception('Commande non trouvée');
		}

		$commandeRepo = new CommandeRepository();
		if (!$commandeRepo->deleteById($idCommande)) {
			throw new Exception('Erreur lors de la suppression de la commande');
		}

		$this->redirectTo('panier.php'); // Redirection après suppression		
	}

	public function commander() {
		$repository = new CommandeRepository();
		$service = new AuthService();
		$utilisateur = $service->getUtilisateur();
		$isLoggedIn = $service->isLoggedIn();

		$isDiscounted = $utilisateur->getRole()->getNiveau() >= (new RoleRepository())->findByNom("adherant")->getNiveau();

		$commandes = $repository->findByUtilisateur($utilisateur->getNetud());
		$total = $repository->getTotal($utilisateur->getNetud());
		if ($isDiscounted){
			$total = $total - ($total * 0.25);
		}
		
		if ($utilisateur != null)
		{
			if (count($commandes) > 0) {
				foreach ($commandes as $commande) {
					$produit = $commande->getProduit();

					$produit->setQs($produit->getQs() - $commande->getQa());
					$produitRepository = new ProduitRepository();
					$produitRepository->update($produit);

					$repository->deleteById($commande->getNumCommande());
				}
			}
		}else {
			throw new Exception('Erreur lors de la commande');
		}

		$this->view('panier/panier_commande.html.twig',  ['utilisateur' => $utilisateur, 'commandes' => $commandes,'Total' => $total,'isLoggedIn' => $isLoggedIn, 'isDiscount' => $isDiscounted  ]);
	}
}