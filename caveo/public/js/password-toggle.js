document.addEventListener("DOMContentLoaded", () => {
    const toggles = document.querySelectorAll("[data-toggle-password]");
    console.log("password toggle loaded");

    toggles.forEach((toggle) => {
        toggle.addEventListener("click", () => {
            const targetId = toggle.dataset.target;
            const input = document.getElementById(targetId);
            const icon = toggle.querySelector("[data-eye-icon]");

            if (!input || !icon) return;

            const isHidden = input.type === "password";

            input.type = isHidden ? "text" : "password";

            icon.src = isHidden
                ? "/images/symbole/oeil-ouvert.svg"
                : "/images/symbole/oeil-ferme.svg";
        });
    });
});
