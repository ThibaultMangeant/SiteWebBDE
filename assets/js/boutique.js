const divGestionBoutique = document.getElementById("gestionBoutique");

divGestionBoutique.innerHTML = `<a href="gestionBoutique.php" id="floatingGestionBoutiqueButton" class="text-decoration-none">
			<i class="fa-solid fa-store p-1"></i> Gérer la boutique
		</a>`;

const redirectionGererBoutique = document.createElement("a");
redirectionGererBoutique.href = "gestionBoutique.php";

redirectionGererBoutique.appendChild(btnGererBoutique);
divGestionBoutique.appendChild(redirectionGererBoutique);