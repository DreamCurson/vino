const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('imagePreview');

if (imageInput && imagePreview) {
    imageInput.addEventListener('input', () => {
        const url = imageInput.value.trim();

        if (url) {
            imagePreview.src = url;
            imagePreview.classList.remove('hidden');
        } else {
            imagePreview.classList.add('hidden');
            imagePreview.removeAttribute('src');
        }
    });

    imagePreview.addEventListener('error', () => {
        imagePreview.classList.add('hidden');
    });
}
