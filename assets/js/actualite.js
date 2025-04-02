const inputTitre = document.getElementById("inputTitre");
const inputDesc  = document.getElementById("inputDesc");

const actualiteCard = document.querySelectorAll(".actualite-card");

actualiteCard.forEach(card =>
{
	card.addEventListener("click", (event) =>
	{
		const titre = card.querySelector(".actualite-title").textContent;

		const description = card.querySelector(".actualite-desc").textContent;

		console.log("Titre : " + titre);
		console.log("Description : " + description);

		inputTitre.value = titre;
		inputDesc.value  = description;
	});
});
