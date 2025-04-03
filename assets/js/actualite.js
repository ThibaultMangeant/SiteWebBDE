const inputId = document.getElementById("inputId");
const inputTitre = document.getElementById("inputTitre");
const inputDesc  = document.getElementById("inputDesc");

const actualiteCard = document.querySelectorAll(".actualite-card");

function deleteActualite() {
	const selectedCard = document.querySelector('.actualite-card.selected');
	if (selectedCard) {
		const id = selectedCard.querySelector('.actualite-id').textContent;
		window.location.href = `actualite_delete.php?idActu=${id}`;
	} else {
		alert('Veuillez sélectionner une actualité à supprimer.');
	}
}

document.getElementById("btnSuppr").addEventListener("click", deleteActualite);

let cardPrec = null;
actualiteCard.forEach(card =>
{
	card.addEventListener("click", (event) =>
	{
		if (cardPrec !== null)
			cardPrec.classList.remove("selected");

		card.classList.add("selected");

		const id = card.querySelector(".actualite-id").textContent;
		inputId.value = id;

		const titre = card.querySelector(".actualite-title").textContent;
		inputTitre.value = titre;

		const description = card.querySelector(".actualite-desc").textContent;
		inputDesc.value  = description;

		cardPrec = card;
	});
});
