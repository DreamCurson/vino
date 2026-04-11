document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchForm = document.getElementById("search-form");

    // Écouter les changements dans le champ de recherche
    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();
        const url = new URL(window.location.href);

        // Mettre à jour le paramètre 'recherche' dans l'URL avec la valeur actuelle du champ de recherche
        if (query) {
            url.searchParams.set("recherche", query);
        } else {
            url.searchParams.delete("recherche");
        }

        // Mettre à jour l'URL du navigateur pour refléter le nouveau terme de recherche sans recharger la page
        window.history.pushState({}, "", url);

        // Soumettre automatiquement le formulaire pour appliquer la recherche
        searchForm.submit();
    });
});
