document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('focusout', (event) => {
        if (event.target && event.target.classList.contains('js-translation-input')) {
            const element = event.target;
            const value = element.value;
            const name = element.name;

            const formContainer = element.closest('.js-save-translations');

            if (!formContainer) {
                console.error('Could not find .js-save-translations for field', element);
                return;
            }

            const saveUrl = formContainer.dataset.url;
            const formData = new URLSearchParams();
            formData.append(name, value);

            fetch(saveUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
                .then(response => {
                    if (!response.ok) {
                        console.error('Translation save error:', response.statusText);
                        element.classList.add('is-invalid');
                    } else {
                        element.classList.remove('is-invalid');
                        element.classList.add('is-valid');
                        setTimeout(() => element.classList.remove('is-valid'), 2000);
                    }
                })
                .catch(error => {
                    console.error('Error network:', error);
                });
        }
    });
});
