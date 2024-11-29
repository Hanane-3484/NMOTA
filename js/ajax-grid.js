/*AJAX-GRID*/
jQuery(document).ready(function ($) {
    var offset = 0;
    var postsPerPage = 8;
    var category = ''; // Valeur par défaut (toutes catégories)
    var format = '';   // Valeur par défaut (tous formats)
    var order = 'DESC'; // Tri par défaut (plus récentes)

    // Charger les photos initialement
    load_more_photos();

    // Gestion des filtres (catégories, formats et tri)
    $('.custom-dropdown .dropdown-options li').off('click').on('click', function () {
        const parentId = $(this).closest('.custom-dropdown').attr('id');
        const value = $(this).data('value');

        if (parentId === 'custom-category') {
            category = value; // Mise à jour de la catégorie
        } else if (parentId === 'custom-format') {
            format = value; // Mise à jour du format
        } else if (parentId === 'custom-sort') {
            order = value === 'date_asc' ? 'ASC' : 'DESC'; // Mise à jour de l'ordre
        }

        // Réinitialiser la grille et charger les photos triées/filtrées
        offset = 0;
        $('.photo-grid').html('');
        load_more_photos();

        // Mettre à jour le texte affiché dans le dropdown
        $(this).closest('.custom-dropdown').find('.dropdown-trigger').html($(this).text().toUpperCase() + '<span class="dropdown-arrow"></span>');
    });

    // Charger plus de photos au clic sur "Charger plus"
    $('#load-more').on('click', function (e) {
        e.preventDefault();
        load_more_photos();
    });

    // Fonction AJAX pour charger les photos
    function load_more_photos() {
        $.ajax({
            url: ajaxData.url, // URL définie dans votre script localisé
            type: 'POST',
            data: {
                action: 'load_photo_grid', // Action associée à WordPress
                nonce: ajaxData.nonce,    // Vérification de sécurité
                posts_per_page: postsPerPage,
                offset: offset,
                category: category, // Catégorie sélectionnée
                format: format,     // Format sélectionné
                order: order,       // Tri sélectionné
            },
            beforeSend: function () {
                $('#load-more').text('Chargement...');
            },
            success: function (response) {
                if (response) {
                    $('.photo-grid').append(response); // Ajoute les nouvelles photos
                    offset += postsPerPage;
                    $('#load-more').text('Charger plus');
    
                    // Appeler updateImages après avoir ajouté les photos
                    updateImages(); // Assurez-vous que cette fonction est définie
                } else {
                    $('#load-more').hide();
                }
            },
            error: function () {
                alert('Erreur lors du chargement des photos.');
            },
        });
    }

    // Définition de la fonction updateImages
    function updateImages() {
        var images = [];
        var currentIndex = 0;

        // Collecter toutes les images dans la grille
        $('.photo-item .fullscreen').each(function () {
            var imageData = {
                url: $(this).data('image'),
                title: $(this).data('title'),
                categories: $(this).data('categories')
            };
        
            // Assurez-vous que toutes les données sont présentes avant d'ajouter
            if (imageData.url && imageData.title && imageData.categories) {
                images.push(imageData);
            } else {
                console.warn("Données manquantes pour une image:", imageData);
            }
        });
    }
});