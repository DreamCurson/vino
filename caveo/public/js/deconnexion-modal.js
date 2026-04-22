document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.getElementById("openDeconnexionModal");
    const modal = document.getElementById("deconnexionModale");
    const cancelBtn = document.getElementById("cancelDeco");
    const confirmBtn = document.getElementById("confirmDecoBtn");

    if (!openBtn || !modal) return;

    // Ouvre
    openBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal.classList.remove("hidden");
    });

    // Ferme (annuler)
    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Ferme lors de clic hors de la modale
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });

    // Confirme la deconnexion
    confirmBtn.addEventListener("click", () => {
        window.location.href = "/deconnexion";
    });
});
