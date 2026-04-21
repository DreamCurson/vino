document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addToListeModal");
    const form = document.getElementById("addToListeForm");
    const bouteilleInput = document.getElementById("modal_bouteille_id");
    const listeSelect = document.getElementById("modal_liste_id");
    const closeBtn = document.getElementById("closeModal");

    const minusBtn = document.getElementById("minusQuantite");
    const plusBtn = document.getElementById("plusQuantite");
    const quantiteDisplay = document.getElementById("modalQuantiteDisplay");
    const quantiteInput = document.getElementById("listeQuantite");

    let quantite = 1;

    document.querySelectorAll(".openAddToListeModal").forEach((button) => {
        button.addEventListener("click", () => {
            const listeId = listeSelect.value;

            bouteilleInput.value = button.dataset.bouteilleId;

            quantite = 1;
            quantiteDisplay.textContent = quantite;
            quantiteInput.value = quantite;

            form.action = `/public/achat/${listeId}/bouteilles`;
            form.method = "POST";

            modal.classList.remove("hidden");
        });
    });

    listeSelect.addEventListener("change", () => {
        const listeId = listeSelect.value;
        form.action = `/public/achat/${listeId}/bouteilles`;
    });

    form.addEventListener("submit", (e) => {
        console.log("METHOD:", form.method);
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    modal.querySelector(".bg-black").addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    plusBtn.addEventListener("click", () => {
        quantite++;
        quantiteDisplay.textContent = quantite;
        quantiteInput.value = quantite;
    });

    minusBtn.addEventListener("click", () => {
        if (quantite > 1) {
            quantite--;
            quantiteDisplay.textContent = quantite;
            quantiteInput.value = quantite;
        }
    });
});