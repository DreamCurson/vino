document.querySelectorAll(".toggle-liste").forEach((el) => {
    const targetId = el.dataset.target;
    const target = document.getElementById(targetId);

    // Retrouve si c'était ouvert ou fermer lors de la dernière visualisation de la page
    const isOpen = sessionStorage.getItem(targetId) === "open";
    if (isOpen) {
        target.classList.remove("hidden");
    }

    el.addEventListener("click", (e) => {
        if (e.target.closest("a, button, form")) return;


        const isHidden = target.classList.toggle("hidden");
        target.ariaExpanded = !isHidden; //pour les lecteurs d'écran

        //pour gérer le triangle "ouvert/fermer"
        e.currentTarget.querySelector("h2 span.open").classList.toggle("hidden", !isHidden);
        e.currentTarget.querySelector("h2 span.close").classList.toggle("hidden", isHidden);

        // Sauvegarde temporairement si ouvert ou fermer
        if (target.classList.contains("hidden")) {
            sessionStorage.setItem(targetId, "closed");
        } else {
            sessionStorage.setItem(targetId, "open");
        }
    });
});
