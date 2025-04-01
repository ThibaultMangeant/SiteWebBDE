document.addEventListener("DOMContentLoaded", function () {
    const eventContainer = document.querySelector(".event-container");
    const eventCards = document.querySelectorAll(".event-card");

    // Fonction pour activer une carte visible
    function activateVisibleCard() {
        eventCards.forEach((card) => {
            const rect = card.getBoundingClientRect();
            // Vérifie si la carte est visible dans le conteneur
            if (rect.top >= eventContainer.getBoundingClientRect().top &&
                rect.bottom <= eventContainer.getBoundingClientRect().bottom) {
                card.classList.add("active");
                card.classList.remove("inactive");
            } else {
                card.classList.add("inactive");
                card.classList.remove("active");
            }
        });
    }

    // Activer la carte visible au chargement
    activateVisibleCard();

    // Activer la carte visible lors du défilement
    eventContainer.addEventListener("scroll", () => {
        activateVisibleCard();
    });
});
