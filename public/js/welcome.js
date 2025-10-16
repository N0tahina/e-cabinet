document.addEventListener('DOMContentLoaded', function() {
    const isAuthenticated = window.isAuthenticated || false; // valeur définie dans le Blade
    const cards = document.querySelectorAll('.clickable-card');
    const modal = document.getElementById('loginModal');
    const closeBtn = document.querySelector('.modal .close');

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const targetUrl = card.dataset.href;

            if (isAuthenticated) {
                // Redirection vers la page cible si connecté
                window.location.href = targetUrl;
            } else {
                // Afficher le modal uniquement si non connecté
                modal.style.display = 'block';
            }
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });
});