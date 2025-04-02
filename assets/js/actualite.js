const inputTitre = document.getElementById("inputTitre");
const inputDesc  = document.getElementById("inputDesc");

const actualiteCard = document.querySelectorAll(".actualite-card");


let cardPrec = null;
actualiteCard.forEach(card =>
{
	card.addEventListener("click", (event) =>
	{
		if (cardPrec !== null)
			cardPrec.classList.remove("selected");

		card.classList.add("selected");
		const titre = card.querySelector(".actualite-title").textContent;

		const description = card.querySelector(".actualite-desc").textContent;

		inputTitre.value = titre;
		inputDesc.value  = description;

		cardPrec = card;
	});
});
