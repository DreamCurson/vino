document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addToCellierModal");
    const overlay = document.getElementById("cellierOverlay");
    const closeBtn = document.getElementById("closeCellierModal");

    const bouteilleIdInput = document.getElementById("modalBouteilleId");
    const bouteilleNomText = document.getElementById("modalBouteilleNom");
    const cellierSelect = document.getElementById("modalCellierSelect");
    const form = document.getElementById("addToCellierForm");

    const quantiteInput = document.getElementById("cellierQuantite");
    const quantiteDisplay = document.getElementById("cellierQuantiteDisplay");
    const minusBtn = document.getElementById("cellierMinusBtn");
    const plusBtn = document.getElementById("cellierPlusBtn");

    let quantite = 1;

    function updateFormAction() {
        const cellierId = cellierSelect.value;
        form.action = `/public/celliers/${cellierId}/inventaires`;
        form.method = "POST";
    }

    function resetQuantite() {
        quantite = 1;
        quantiteInput.value = 1;
        quantiteDisplay.textContent = 1;
    }

    document.querySelectorAll(".openAddToCellierModal").forEach((button) => {
        button.addEventListener("click", () => {
            bouteilleIdInput.value = button.dataset.bouteilleId;
            bouteilleNomText.textContent = button.dataset.bouteilleNom;

            resetQuantite();
            updateFormAction();

            modal.classList.remove("hidden");
            if (overlay) overlay.classList.remove("hidden");
        });
    });

    function closeModal() {
        modal.classList.add("hidden");
        if (overlay) overlay.classList.add("hidden");
    }

    if (closeBtn) closeBtn.addEventListener("click", closeModal);
    if (overlay) overlay.addEventListener("click", closeModal);

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeModal();
    });

    cellierSelect.addEventListener("change", updateFormAction);

    form.addEventListener("submit", () => {
        updateFormAction();
        form.method = "POST";
    });

    function updateModalQty(delta) {
        quantite = parseInt(quantiteInput.value, 10) || 1;
        quantite += delta;

        if (quantite < 1) quantite = 1;
        if (quantite > 999) quantite = 999;

        quantiteInput.value = quantite;
        quantiteDisplay.textContent = quantite;
    }

    if (minusBtn) minusBtn.addEventListener("click", () => updateModalQty(-1));
    if (plusBtn) plusBtn.addEventListener("click", () => updateModalQty(1));
});