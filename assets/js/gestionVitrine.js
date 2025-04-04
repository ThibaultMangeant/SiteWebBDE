function deleteImage(section, image) {
	if (confirm("Êtes-vous sûr de vouloir supprimer cette image ?")) {
		// Créer une requête POST pour supprimer l'image
		fetch('vitrine_deleteImage.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: new URLSearchParams({
				section: section,
				image: image
			})
		})
		.then(response => {
			if (response.ok) {
				// Supprimer l'image de l'interface utilisateur
				location.reload(); // Recharger la page pour refléter les changements
			} else {
				alert("Une erreur s'est produite lors de la suppression de l'image.");
			}
		})
		.catch(error => {
			console.error("Erreur :", error);
			alert("Une erreur s'est produite lors de la suppression de l'image.");
		});
	}
}
