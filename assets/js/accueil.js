document.addEventListener("DOMContentLoaded", function ()
{
	const containers = document.querySelectorAll(".event-container-left, .event-container-right");

	// Fonction pour activer les cartes visibles dans un conteneur
	function activateVisibleCards(container)
	{
		const cards = container.querySelectorAll(".event-card");
		const containerRect = container.getBoundingClientRect();

		cards.forEach((card) =>
		{
			const rect = card.getBoundingClientRect();
			// Vérifie si la carte est visible dans le conteneur
			if (rect.top >= containerRect.top && rect.bottom <= containerRect.bottom) {
				card.classList.add("active");
				card.classList.remove("inactive");
			} else {
				card.classList.add("inactive");
				card.classList.remove("active");
			}
		});
	}

	// Activer les cartes visibles au chargement pour chaque conteneur
	containers.forEach((container) =>
	{
		activateVisibleCards(container);

		// Activer les cartes visibles lors du défilement
		container.addEventListener("scroll", () =>
		{
			activateVisibleCards(container);
		});
	});

	const divGestionActualites = document.getElementById("gestionActualite");

	const redirectionGererActualites = document.createElement("a");
	redirectionGererActualites.href = "actualites.php";


	const btnGererActualite = document.createElement("button");

	// Gestion du style du bouton
	btnGererActualite.textContent = "Gerer les actualités";
	btnGererActualite.classList.add("btn");
	btnGererActualite.classList.add("btn-danger");


	redirectionGererActualites.appendChild(btnGererActualite);
	divGestionActualites.appendChild(redirectionGererActualites);
});
