/** Fait disparaître le message flash */
document.addEventListener('DOMContentLoaded', function() {
    const messageFlash = document.getElementById('flash-alert');

    if (messageFlash) {
        setTimeout(function() {
            messageFlash.classList.add('opacity-0');

            setTimeout(function() {
                messageFlash.remove();
            }, 500);
        }, 3000);
    }
});