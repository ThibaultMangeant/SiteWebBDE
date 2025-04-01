const groupOptions = document.getElementById("groupOptions");
const redirectionAjouterProduit = document.createElement("a");

redirectionAjouterProduit.href = "ajouter_produit.php";

const btnAjouterProduit = document.createElement("button");


// Gestion du style du bouton Ajouter produit
btnAjouterProduit.textContent = "Ajouter un produit";
btnAjouterProduit.classList.add("btn");
btnAjouterProduit.classList.add("btn-outline-secondary");


redirectionAjouterProduit.appendChild(btnAjouterProduit)
groupOptions.appendChild(redirectionAjouterProduit);