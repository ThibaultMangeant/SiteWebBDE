document.addEventListener("DOMContentLoaded", function ()
{
	const eventContainer = document.querySelector(".event-container");

	// Ajout d'un effet d'animation lors du défilement
	eventContainer.addEventListener("scroll", () =>
		{
		const eventCards = document.querySelectorAll(".event-card");
		eventCards.forEach((card) =>
			{
			const rect = card.getBoundingClientRect();
			if (rect.top >= 0 && rect.bottom <= window.innerHeight)
				{
				card.classList.add("active");
			} else
			{
				card.classList.remove("active");
			}
		});
	});
});

document.addEventListener("scroll", function()
{
	let cards = document.querySelectorAll(".card");
	let centerScreen = window.innerHeight / 2;

	cards.forEach(card =>
		{
		let rect = card.getBoundingClientRect();
		let centerCard = rect.top + rect.height / 2;
		let distance = Math.abs(centerScreen - centerCard);

		if (distance < 100)
			{
			card.classList.add("active");
			card.classList.remove("inactive");
		} else
		{
			card.classList.add("inactive");
			card.classList.remove("active");
		}
	});
});
