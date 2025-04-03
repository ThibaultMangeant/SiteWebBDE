const inputId = document.getElementById("inputId");
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

		const id = card.querySelector(".actualite-id").textContent;
		inputId.value = id;

		const titre = card.querySelector(".actualite-title").textContent;
		inputTitre.value = titre;

		const description = card.querySelector(".actualite-desc").textContent;
		inputDesc.value  = description;

		cardPrec = card;
	});
});
