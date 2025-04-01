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

        // Récupérer les données POST nettoyées
        $postData = $this->getAllPostParams();
        $data = [];

        // Si aucune donnée n'est envoyée en POST ou si la connexion échoue, afficher le formulaire
        if (!empty($postData))
        {
            $utilisateurRepository = new UtilisateurRepository();

            $utilisateur = $utilisateurRepository->findById($this->getPostParam('numero_etudiant'));

            if($utilisateur !== null && $this->verify($this->getPostParam('password'),$utilisateur->getMdp()))
            {
                $authService->setUtilisateur($utilisateur);
                $this->redirectTo('index.php');
            }
            $data= empty($postData) ? []:['error'=>'Email ou mot de passe invalide'];// si des données existent, elles ne sont pas valide

        }

        $this->view('utilisateur/login.html.twig', $data ); // Affiche la vue login.php
    }
}