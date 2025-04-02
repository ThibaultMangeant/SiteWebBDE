document.addEventListener("DOMContentLoaded", function () {
    const quantityButtons = document.querySelectorAll(".quantity-btn");
    const deleteButtons = document.querySelectorAll(".delete-btn");
    const cartTotal = document.querySelector(".cart-total");

    // Mise à jour de la quantité
    quantityButtons.forEach(button => {
        button.addEventListener("click", function () {
            const action = this.dataset.action;
            const itemId = this.dataset.id;
            const quantityElement = this.parentElement.querySelector(".quantity");
            let quantity = parseInt(quantityElement.textContent);

            if (action === "increase") {
                quantity++;
            } else if (action === "decrease" && quantity > 1) {
                quantity--;
            }

            quantityElement.textContent = quantity;

            // Mettre à jour le total
            updateCartTotal();
        });
    });

    // Suppression d'un article
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            const itemId = this.dataset.id;
            this.parentElement.remove();

            // Mettre à jour le total
            updateCartTotal();
        });
    });

    // Fonction pour mettre à jour le total
    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll(".cart-item").forEach(item => {
            const price = parseFloat(item.querySelector(".cart-item-price").textContent.replace(" €", "").replace(",", "."));
            const quantity = parseInt(item.querySelector(".quantity").textContent);
            total += price * quantity;
        });
        cartTotal.textContent = total.toFixed(2).replace(".", ",") + " €";
    }
});