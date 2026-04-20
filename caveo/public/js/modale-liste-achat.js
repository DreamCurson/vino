document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addToListeModal");
    const form = document.getElementById("addToListeForm");
    const bouteilleInput = document.getElementById("modal_bouteille_id");
    const listeSelect = document.getElementById("modal_liste_id");
    const closeBtn = document.getElementById("closeModal");

    // Quantité
    const minusBtn = document.getElementById("minusQuantite");
    const plusBtn = document.getElementById("plusQuantite");
    const quantiteDisplay = document.getElementById("modalQuantiteDisplay");
    const quantiteInput = document.getElementById("listeQuantite");

    let quantite = 1;

    // Ouvrir modal
    document.querySelectorAll(".openAddToListeModal").forEach((button) => {
        button.addEventListener("click", () => {
            const bouteilleId = button.dataset.bouteilleId;

            bouteilleInput.value = bouteilleId;

            // reset quantité à chaque ouverture
            quantite = 1;
            quantiteDisplay.textContent = quantite;
            quantiteInput.value = quantite;

            modal.classList.remove("hidden");

            updateFormAction();
        });
    });

    // Fermer modal
    closeBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // (optionnel) fermer en cliquant sur le fond noir
    modal.querySelector(".bg-black").addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Update action selon la liste choisie
    function updateFormAction() {
        const listeId = listeSelect.value;
        form.action = `/achat/${listeId}/bouteilles`;
    }

    listeSelect.addEventListener("change", updateFormAction);

    // Bouton +
    plusBtn.addEventListener("click", () => {
        quantite++;
        quantiteDisplay.textContent = quantite;
        quantiteInput.value = quantite;
    });

    // Bouton -
    minusBtn.addEventListener("click", () => {
        if (quantite > 1) {
            quantite--;
            quantiteDisplay.textContent = quantite;
            quantiteInput.value = quantite;
        }
    });
});
