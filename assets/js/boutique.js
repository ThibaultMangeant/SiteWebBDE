const groupOptions = document.getElementById("groupOptions");
const btnAjouterProduit = document.createElement("button");


// Gestion du style du bouton Ajouter produit
btnAjouterProduit.textContent = "Ajouter un produit";
btnAjouterProduit.classList.add("btn");
btnAjouterProduit.classList.add("btn-outline-secondary");


groupOptions.appendChild(btnAjouterProduit);