const groupOptions = document.getElementById("groupOptions");
const cardFooters  = document.getElementsByClassName("card-body");


const redirectionAjouterProduit = document.createElement("a");
redirectionAjouterProduit.href = "ajouter_produit.php";

const redirectionModifierProduit = document.createElement("a");
redirectionModifierProduit.href = "ajouter_produit.php";

const btnAjouterProduit   = document.createElement("button");
const btnModifierProduit  = document.createElement("button");
const btnSupprimerProduit = document.createElement("button");


// Gestion du style du bouton Ajouter produit
btnAjouterProduit.textContent = "Ajouter un produit";
btnAjouterProduit.classList.add("btn");
btnAjouterProduit.classList.add("btn-outline-secondary");


// Gestion du style du bouton Modifier produit
btnModifierProduit.textContent = "Modifier le produit";
btnModifierProduit.classList.add("btn");
btnModifierProduit.classList.add("btn-outline-secondary");


// Gestion du style du bouton Supprimer produit
btnSupprimerProduit.textContent = "Supprimer le produit"
btnSupprimerProduit.classList.add("btn");
btnSupprimerProduit.classList.add("btn-outline-secondary");


redirectionAjouterProduit.appendChild(btnAjouterProduit);
redirectionModifierProduit.appendChild(btnModifierProduit);
groupOptions.appendChild(redirectionAjouterProduit);


for (let cardFooter of cardFooters)
{
	const optionsModification = document.createElement("div");
	optionsModification.appendChild(redirectionModifierProduit.cloneNode(true));
	optionsModification.appendChild(btnSupprimerProduit.cloneNode(true));

	cardFooter.appendChild(optionsModification);
}