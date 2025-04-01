const groupOptions = document.getElementById("groupOptions");

const redirectionGererBoutique = document.createElement("a");
redirectionGererBoutique.href = "produit/produits.php";

const btnGererBoutique = document.createElement("button");
btnGererBoutique.textContent = "Gerer la boutique";
btnGererBoutique.classList.add("btn");
btnGererBoutique.classList.add("btn-outline-secondary");

redirectionGererBoutique.appendChild(btnGererBoutique);
groupOptions.appendChild(redirectionGererBoutique);