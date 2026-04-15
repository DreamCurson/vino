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

    document.querySelectorAll(".openAddToCellierModal").forEach((button) => {
        button.addEventListener("click", () => {
            const bouteilleId = button.dataset.bouteilleId;
            const bouteilleNom = button.dataset.bouteilleNom;

            bouteilleIdInput.value = bouteilleId;
            bouteilleNomText.textContent = bouteilleNom;
            form.action = `/celliers/${cellierSelect.value}/inventaires`;

            quantiteInput.value = 1;
            quantiteDisplay.textContent = 1;

            modal.classList.remove("hidden");
        });
    });

    function closeModal() {
        modal.classList.add("hidden");
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", closeModal);
    }

    if (overlay) {
        overlay.addEventListener("click", closeModal);
    }

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeModal();
        }
    });

    if (cellierSelect) {
        cellierSelect.addEventListener("change", () => {
            form.action = `/celliers/${cellierSelect.value}/inventaires`;
        });
    }

    function updateModalQty(delta) {
        let value = parseInt(quantiteInput.value, 10) || 1;
        value += delta;

        if (value < 1) value = 1;
        if (value > 999) value = 999;

        quantiteInput.value = value;
        quantiteDisplay.textContent = value;
    }

    if (minusBtn) {
        minusBtn.addEventListener("click", () => updateModalQty(-1));
    }

    if (plusBtn) {
        plusBtn.addEventListener("click", () => updateModalQty(1));
    }
    form.addEventListener("submit", function (e) {
        e.preventDefault(); // empêche la redirection

        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            },
            body: formData,
        })
            .then(response => {
                if (!response.ok) throw new Error("Erreur serveur");
                return response.text();
            })
            .then(() => {
                // fermer la modale
                modal.classList.add("hidden");

                // reset quantité
                quantiteInput.value = 1;
                quantiteDisplay.textContent = 1;

                // afficher le message flash
                const flashContainer = document.getElementById("ajax-flash-container");

                if (flashContainer) {
                    flashContainer.innerHTML = `
            <div class="message-flash-auto mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                La bouteille a bien été ajoutée au cellier.
            </div>
        `;

                    if (window.initAutoFlashMessages) {
                        window.initAutoFlashMessages();
                    }
                }
            })
    });
});