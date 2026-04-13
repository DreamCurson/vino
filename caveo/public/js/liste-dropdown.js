document.querySelectorAll(".toggle-liste").forEach((el) => {
    el.addEventListener("click", (e) => {
        if (e.target.closest("a, button, form")) return;

        const target = document.getElementById(el.dataset.target);
        target.classList.toggle("hidden");
    });
});
