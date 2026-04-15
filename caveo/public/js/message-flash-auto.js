/**
 * Fait disparaître automatiquement un message flash.
 *
 * @param {HTMLElement} message
 */
function autoHideFlashMessage(message) {
    setTimeout(function () {
        message.classList.add('opacity-0', 'transition-opacity', 'duration-500');

        setTimeout(function () {
            message.remove();
        }, 500);
    }, 3000);
}

/**
 * Applique la disparition automatique à tous les messages flash présents.
 */
function initAutoFlashMessages() {
    const messages = document.querySelectorAll('.message-flash-auto');

    messages.forEach(function (message) {
        if (!message.dataset.autoHideInitialized) {
            message.dataset.autoHideInitialized = 'true';
            autoHideFlashMessage(message);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initAutoFlashMessages();
});

/**
 * Rend la fonction accessible globalement
 * pour les messages ajoutés dynamiquement par AJAX.
 */
window.initAutoFlashMessages = initAutoFlashMessages;