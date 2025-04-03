<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';
require_once './app/services/AuthService.php';

class VitrineController extends Controller
{
	use FormTrait;
	use AuthTrait;

	private $vitrineTextPath = './assets/vitrine/';

	public function index()
	{
		// Lire les fichiers de texte
		$sections = $this->readVitrineTexts();

		// Afficher la vue de la vitrine
		$this->view('vitrine/vitrine.html.twig', [
			'sections' => $sections,
			'isAdmin' => (new AuthService())->isAdmin()
		]);
	}

	public function gestion()
	{
		$service = new AuthService();
		$isAdmin = $service->isAdmin();

		if (!$isAdmin) {
			$this->redirectTo('vitrine.php');
			return;
		}

		// Lire les fichiers de texte
		$sections = $this->readVitrineTexts();

		// Afficher la vue de gestion de la vitrine
		$this->view('vitrine/gestionVitrine.html.twig', [
			'sections' => $sections,
			'isAdmin' => $isAdmin
		]);
	}

	public function update()
	{
		$service = new AuthService();

		// Vérifier si l'utilisateur est admin
		if (!$service->isAdmin()) {
			$this->redirectTo('vitrine.php');
			return;
		}

		// Récupérer les données POST
		$postData = $this->getAllPostParams();

		// Gérer les fichiers envoyés
		$index = 1; // Initialiser le préfixe numérique
		foreach ($postData as $section => $content)
		{
			 // Nettoyer le nom de la section pour éviter les caractères invalides
			$cleanSectionName = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $section); // Supprimer les caractères spéciaux
			$cleanSectionName = trim($cleanSectionName); // Supprimer les espaces inutiles
			$fileName = $index . '_' . $cleanSectionName . '.txt'; // Conserver les espaces dans le nom
			$filePath = $this->vitrineTextPath . $fileName;

			 // Lire les images existantes pour ne pas les supprimer
			$existingContent = file_exists($filePath) ? file_get_contents($filePath) : '';
			$existingLines = explode("\n", $existingContent);
			$existingImages = [];

			foreach ($existingLines as $line) {
				if (strpos($line, 'image:') === 0) {
					$existingImages[] = $line; // Conserver les images existantes
				}
			}

			// Ajouter des références aux nouvelles images si elles sont uploadées
			$newImageLines = [];
			if (!empty($_FILES['image_' . $section]['name'][0])) {
				foreach ($_FILES['image_' . $section]['name'] as $key => $imageName) {
					$imageName = basename($imageName);
					$targetPath = './assets/images/vitrine/' . $imageName;

					if (move_uploaded_file($_FILES['image_' . $section]['tmp_name'][$key], $targetPath)) {
						$newImageLines[] = "image:$imageName";
					}
				}
			}

			// Combiner les images existantes et les nouvelles images
			$allImageLines = array_merge($existingImages, $newImageLines);

			// Ajouter les images au contenu
			$content = implode("\n", $allImageLines) . "\n" . trim($content); // Supprimer les espaces inutiles autour du contenu
			$content = trim($content); // Pas de ligne vide si aucune image

			// Mettre à jour le fichier texte
			file_put_contents($filePath, $content);

			$index++; // Incrémenter le préfixe numérique pour le fichier suivant
		}

		// Rediriger vers la page de gestion
		$this->redirectTo('gestionVitrine.php');
	}

	private function readVitrineTexts()
	{
		$sections = [];
		if (is_dir($this->vitrineTextPath)) {
			// Lire tous les fichiers du dossier
			$files = scandir($this->vitrineTextPath);

			// Trier les fichiers par ordre numérique (en fonction du préfixe)
			usort($files, function ($a, $b) {
				$aNum = intval(explode('_', $a)[0]);
				$bNum = intval(explode('_', $b)[0]);
				return $aNum <=> $bNum;
			});

			// Lire le contenu des fichiers
			foreach ($files as $file) {
				if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
					$sectionName = preg_replace('/^\d+_/', '', pathinfo($file, PATHINFO_FILENAME)); // Supprimer le préfixe numérique
					$content = file_get_contents($this->vitrineTextPath . $file);

					// Détecter les images associées
					$lines = explode("\n", $content);
					$images = [];
					$textLines = [];

					foreach ($lines as $line) {
						if (strpos($line, 'image:') === 0) {
							$images[] = trim(str_replace('image:', '', $line)); // Extraire le chemin de l'image
						} else {
							$textLines[] = rtrim($line); // Supprimer les espaces inutiles à la fin des lignes
						}
					}

					$sections[$sectionName] = [
						'content' => implode("\n", $textLines), // Conserver les sauts de ligne bruts
						'images' => $images // Liste des images associées
					];
				}
			}
		}
		return $sections;
	}
}
