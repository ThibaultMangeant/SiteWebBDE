<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class AuthController extends Controller {
	use FormTrait;
	use AuthTrait;

	public function login() {
		$authService = new AuthService();

		// Vérifier si l'utilisateur est déjà connecté
		if ($authService->isLoggedIn()) {
			// Appeler la méthode compte() si l'utilisateur est connecté
			$this->compte();
			return;
		}

		// Récupérer les données POST nettoyées
		$postData = $this->getAllPostParams();
		$data = [];

		// Si des données sont envoyées en POST
		if (!empty($postData)) {
			$utilisateurRepository = new UtilisateurRepository();

			$utilisateur = $utilisateurRepository->findById($this->getPostParam('numero_etudiant'));

			// Vérifier si l'utilisateur existe et si le mot de passe est correct
			if ($utilisateur !== null /* && $this->verify($this->getPostParam('password'), $utilisateur->getMdp()) */) {
				$authService->setUtilisateur($utilisateur);
				$this->compte(); // Rediriger vers la méthode compte()
				return;
			}

			// Si les informations sont invalides
			$data = ['error' => 'Numéro étudiant ou mot de passe invalide'];
		}

		// Afficher la vue de connexion avec les éventuelles erreurs
		$this->view('utilisateur/login.html.twig', $data);
	}

	public function compte() {
		$authService = new AuthService();

		// Vérifier si l'utilisateur est connecté
		if (!$authService->isLoggedIn()) {
			// Rediriger vers la page de connexion si non connecté
			$this->redirectTo('login.php');
			return;
		}

		// Récupérer les informations de l'utilisateur connecté
		$utilisateur = $authService->getUtilisateur();

		// Passer les données de l'utilisateur à la vue compte.html.twig
		$this->view('utilisateur/compte.html.twig', [
			'utilisateur' => [
				'prenom' => $utilisateur->getPrenom(),
				'nom' => $utilisateur->getNom(),
				'email' => $utilisateur->getEmail(),
				'netud' => $utilisateur->getNetud(),
				'typeNotification' => $utilisateur->getTypeNotification() // Exemple de champ supplémentaire
			]
		]);
	}
}
