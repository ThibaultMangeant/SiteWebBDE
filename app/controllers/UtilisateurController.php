<?php

require_once './app/core/Controller.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class UtilisateurController extends Controller {

    use FormTrait;
    use AuthTrait;


	public function index() {
		$repository = new UtilisateurRepository();
		$utilisateurs = $repository->findAll();

		// Ensuite, affiche la vue
		$this->view('/utilisateur/index.html.twig',  ['utilisateurs' => $utilisateurs]);
		
	}

	public function gestion() {
		$repository = new UtilisateurRepository();
		$utilisateurs = $repository->findAll();

		// Ensuite, affiche la vue
		$this->view('/utilisateur/gestionUtilisateurs.html.twig',  ['utilisateurs' => $utilisateurs]);
	}

	public function traiter(){
		$repository = new UtilisateurRepository();
		$utilisateurs = $repository->findAll();

		$netud = $this->getQueryParam('netud');
		$action = $this->getQueryParam('action');

		if ($netud === null) {
			throw new Exception('Numero étudiant nécéssaire.');
		}

		$repository = new UtilisateurRepository();
		$utilisateur = $repository->findById($netud);
		if ($utilisateur === null) {
			throw new Exception('Utilisateur non trouvé');
		}

		if ($action === 'accepter' || $action === 'promouvoir') {
			$utilisateur->setDemande(false);
			$repository->upgradeRole($utilisateur);
		} elseif ($action === 'refuser') {
			$utilisateur->setDemande(false);
			$repository->update($utilisateur);			
		} elseif ($action === 'retrograder') {
			$utilisateur->setDemande(false);
			$repository->degradeRole($utilisateur);
		} else {
			throw new Exception('Action non valide.');
		}

		$this->redirectTo('utilisateurs_gestion.php'); // Redirection après traitement
	}

	public function delete() {
		$netud = $this->getQueryParam('netud');
		if ($netud === null) {
			throw new Exception('Numero étudiant nécéssaire.');
		}
		$repository = new UtilisateurRepository();
		if (!$repository->deleteById($netud)) {
			throw new Exception('Erreur lors de la suppression d\'utilisateur.');
		}
		$this->redirectTo('index.php'); // Redirection après suppression
	}
    public function create() {
        $data = $this->getAllPostParams(); // Récupération des données soumises
        $errors = [];

        if (!empty($data)) {
            try {
                $errors = [];

                // Validation des données
				if (empty($data['numero_etudiant'])) {
					$errors[] = 'Le numéro étudiant est requis.';
				}
                if (empty($data['nom'])) {
                    $errors[] = 'Le nom est requis.';
				}
                if (empty($data['prenom'])) {
                    $errors[] = 'Le prénom est requis.';
                }
                if (empty($data['tel']) || strlen($data['tel']) < 10) {
                    $errors[] = 'Le numéro de téléphone valide est réquis.';
                }
                if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Un email valide est requis.';
                }
                if (empty($data['password']) || strlen($data['password']) < 6) {
                    $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                // Création de l'objet utilisateur
                $hashedPassword = $this->hash($data['password']);
                $utilisateur = new Utilisateur($data['numero_etudiant'], $data['nom'], $data['prenom'], $data['tel'], $data['email'], $hashedPassword, "Les deux", (new RoleRepository())->findByNom("membre"),false);

                // Sauvegarde dans la base de données
                $utilisateurRepo = new UtilisateurRepository();
                if (!$utilisateurRepo->create($utilisateur)) {
                    throw new Exception('Erreur lors de l\'enregistrement de l\'utilisateur.');
                }

				(new AuthService())->setUtilisateur($utilisateur); // Connexion de l'utilisateur après création

                $this->redirectTo('index.php'); // Redirection après création
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage()); // Récupération des erreurs
            }
        }

        // Affichage du formulaire
        $this->view('/utilisateur/register.html.twig',  [
            'data' => $data,
            'errors' => $errors,
        ]);
    }

    public function update()
    {
        $netud = $this->getQueryParam('netud');

        if ($netud === null) {
                throw new Exception('Numero étudiant nécéssaire.');
        }
        $repository = new UtilisateurRepository();
        $utilisateur = $repository->findById($netud);

        if ($utilisateur === null) {
            throw new Exception('Utilisateur non trouvé');
        }

        $data = array_merge([
			'numero_etudiant'=>$utilisateur->getNetud(),
            'prenom'=>$utilisateur->getPrenom(),
            'nom'=>$utilisateur->getNom(),
			'tel'=>$utilisateur->getTel(),
            'email'=>$utilisateur->getEmail(),
			'type_notification'=>$utilisateur->getTypeNotification(),
			'role'=>$utilisateur->getRole()->getNomRole(),
			'demande'=>$utilisateur->getDemande(),
        ],$this->getAllPostParams()); //Get submitted data
        $errors = [];

        if (!empty($this->getAllPostParams())) {
            try {
                $errors = [];

                // Data validation
                if (empty($data['numero_etudiant'])) {
					$errors[] = 'Le numéro étudiant est requis.';
				}
                if (empty($data['nom'])) {
                    $errors[] = 'Le nom est requis.';
				}
                if (empty($data['prenom'])) {
                    $errors[] = 'Le prénom est requis.';
                }
				if (empty($data['tel']) || strlen($data['tel']) < 10) {
					$errors[] = 'Le numéro de téléphone valide est réquis.';
				}
                if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Un email valide est requis.';
                }
                if (empty($data['password']) || strlen($data['password']) < 6) {
                    $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
                }
				if (empty($data['demande'])) {
					$errors[] = 'La demande est requise.';
				}
				if (empty($data['type_notification'])) {
					$errors[] = 'Le type de notification est requis.';
				}

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                // Mise à jour de l'objet utilisateur
                $utilisateur->setPrenom($data['prenom']);
                $utilisateur->setNom($data['nom']);
				$utilisateur->setTel($data['tel']);
                $utilisateur->setEmail($data['email']);
				$utilisateur->setTypeNotification($data['type_notification']);
				$utilisateur->setRole((new RoleRepository())->findByNom($data['role']));
				$utilisateur->setDemande((bool)$data['demande']);

                // Si le mot de passe est fourni, le hacher et le mettre à jour
                if (!empty($data['password'])) {
                    $hashedPassword = $this->hash($data['password']);
                    $utilisateur->setMdp($hashedPassword);
                }

                // Sauvegarde dans la base de données
                if (!$repository->update($utilisateur)) {
                    throw new Exception('Erreur lors de la mise à jour d\'utilisateur.');
                }

                $this->redirectTo('index.php'); // Redirect after update

            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage()); // Error retrieval
            }
        }

        // Display update form
        $this->view('/utilisateur/compte.html.twig',  ['data' => $data, 'errors' => $errors, 'id' => $netud]);
    }
}
