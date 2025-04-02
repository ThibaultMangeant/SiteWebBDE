const divGestionBoutique = document.getElementById("gestionBoutique");

const redirectionGererBoutique = document.createElement("a");
redirectionGererBoutique.href = "gestionBoutique.php";


const btnGererBoutique = document.createElement("button");

// Gestion du style du bouton
btnGererBoutique.textContent = "Gerer la boutique";
btnGererBoutique.classList.add("btn");
btnGererBoutique.classList.add("btn-outline-secondary");


redirectionGererBoutique.appendChild(btnGererBoutique);
divGestionBoutique.appendChild(redirectionGererBoutique);