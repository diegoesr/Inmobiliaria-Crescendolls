// ============================================
// Favorites Module
// ============================================

let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

function updateFavoritesCount() {
    const countElement = document.getElementById('favoritesCount');
    if (countElement) {
        const count = favorites.length;
        countElement.textContent = count;
        // Agregar atributo data-count para estilos específicos si es necesario
        countElement.setAttribute('data-count', count);
        // Si el contador está vacío o es 0, ocultarlo visualmente
        if (count === 0) {
            countElement.style.display = 'none';
        } else {
            countElement.style.display = 'flex';
        }
    }
}

function updateFavoriteButtons() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        const id = parseInt(btn.dataset.id);
        const icon = btn.querySelector('i');
        if (favorites.some(f => f.id === id)) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            btn.classList.add('active');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            btn.classList.remove('active');
        }
    });
}

function toggleFavorite(event, id, name, image, price) {
    event.stopPropagation();

    const index = favorites.findIndex(f => f.id === id);
    const btn = event.currentTarget;
    const icon = btn.querySelector('i');

    if (index > -1) {
        // Remover de favoritos
        favorites.splice(index, 1);
        icon.classList.remove('fas');
        icon.classList.add('far');
        btn.classList.remove('active');
        if (typeof showToast === 'function') showToast('Eliminado de favoritos', 'info');
    } else {
        // Agregar a favoritos
        favorites.push({ id, name, image, price });
        icon.classList.remove('far');
        icon.classList.add('fas');
        btn.classList.add('active');

        // Animación del corazón
        btn.classList.add('pulse');
        setTimeout(() => btn.classList.remove('pulse'), 300);

        if (typeof showToast === 'function') showToast('Agregado a favoritos', 'success');
    }

    localStorage.setItem('favorites', JSON.stringify(favorites));
    updateFavoritesCount();
}

function renderFavorites() {
    const list = document.getElementById('favoritesList');
    const empty = document.getElementById('favoritesEmpty');

    if (!list || !empty) return;

    if (favorites.length === 0) {
        list.style.display = 'none';
        empty.style.display = 'flex';
        return;
    }

    list.style.display = 'flex';
    empty.style.display = 'none';

    list.innerHTML = favorites.map(fav => `
        <div class="favorite-item">
            <img src="${fav.image}" alt="${fav.name}">
            <div class="favorite-item-info">
                <h4>${fav.name}</h4>
                <p>${fav.price}</p>
            </div>
            <button class="remove-favorite" onclick="removeFavorite(${fav.id})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `).join('');
}

function removeFavorite(id) {
    favorites = favorites.filter(f => f.id !== id);
    localStorage.setItem('favorites', JSON.stringify(favorites));
    updateFavoritesCount();
    updateFavoriteButtons();
    renderFavorites();
    if (typeof showToast === 'function') showToast('Eliminado de favoritos', 'info');
}

function openFavoritesModal() {
    renderFavorites();
    const modal = document.getElementById('favoritesModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeFavoritesModal() {
    const modal = document.getElementById('favoritesModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Inicializar favoritos
(function () {
    'use strict';

    const favoritesToggle = document.getElementById('favoritesToggle');
    const favoritesModal = document.getElementById('favoritesModal');

    if (favoritesToggle) {
        favoritesToggle.addEventListener('click', openFavoritesModal);
    }

    if (favoritesModal) {
        favoritesModal.addEventListener('click', function (e) {
            if (e.target === this) closeFavoritesModal();
        });
    }

    // Cerrar con Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeFavoritesModal();
        }
    });

    // Inicializar contadores y botones
    updateFavoritesCount();
    updateFavoriteButtons();
})();

