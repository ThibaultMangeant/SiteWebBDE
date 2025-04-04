document.addEventListener('DOMContentLoaded', function() {
    const actualiteCards = document.querySelectorAll('.actualite-card');
    
    actualiteCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Ignore si on clique sur le bouton supprimer
            if (e.target.closest('.btn-delete')) {
                return;
            }
            
            // Enlève la sélection des autres cartes
            actualiteCards.forEach(c => c.classList.remove('selected'));
            
            // Ajoute la sélection à la carte cliquée
            this.classList.add('selected');
            
            // Met à jour le formulaire
            const idActu = this.querySelector('.actualite-id').textContent;
            const titre = this.querySelector('.actualite-title').textContent;
            const desc = this.querySelector('.actualite-desc').textContent;
            
            document.getElementById('inputId').value = idActu;
            document.getElementById('inputTitre').value = titre;
            document.getElementById('inputDesc').value = desc;
        });
    });
});

function deleteActualite(idActu) {
    if (confirm('Voulez-vous vraiment supprimer cette actualité ?')) {
        window.location.href = 'actualite_delete.php?idActu=' + idActu;
    }
}

document.getElementById("btnSuppr").addEventListener("click", () => {
    const selectedCard = document.querySelector('.actualite-card.selected');
    if (selectedCard) {
        const id = selectedCard.querySelector('.actualite-id').textContent;
        deleteActualite(id);
    } else {
        alert('Veuillez sélectionner une actualité à supprimer.');
    }
});
