<?php

require_once './app/core/Controller.php';
require_once './app/repositories/CommandeRepository.php';
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

	}
}