/*AJAX-GRID*/
// Exécute le code lorsque le DOM est complètement chargé
jQuery(document).ready(function ($) {
    var offset = 0; // Position de départ pour récupérer les photos (pagination)
    var postsPerPage = 8; // Nombre de photos à charger par requête
    var category = ''; // Catégorie par défaut (vide = toutes les catégories)
    var format = '';   // Format par défaut (vide = tous les formats)
    var order = 'DESC'; // Tri par défaut (photos les plus récentes en premier)

    // Charger les photos initialement (au chargement de la page)
    load_more_photos();

    // Gestion des filtres : catégories, formats et tri
    $('.custom-dropdown .dropdown-options li')
        .off('click') // Supprime tout ancien gestionnaire d'événement sur les éléments de liste
        .on('click', function () { // Ajoute un gestionnaire d'événement pour chaque élément de la liste
            // Récupère l'ID du menu déroulant parent
            const parentId = $(this).closest('.custom-dropdown').attr('id');
            // Récupère la valeur associée à l'élément cliqué
            const value = $(this).data('value');

            // Vérifie quel menu déroulant a été utilisé et met à jour les variables correspondantes
            if (parentId === 'custom-category') {
                category = value; // Met à jour la catégorie sélectionnée
            } else if (parentId === 'custom-format') {
                format = value; // Met à jour le format sélectionné
            } else if (parentId === 'custom-sort') {
                order = value === 'date_asc' ? 'ASC' : 'DESC'; // Met à jour l'ordre de tri
            }

            // Réinitialise la position de départ et efface la grille de photos
            offset = 0;
            $('.photo-grid').html(''); // Supprime toutes les photos actuellement affichées

            // Recharge les photos avec les nouveaux filtres ou tri
            load_more_photos();

            // Met à jour le texte du menu déroulant pour refléter la sélection
            $(this)
                .closest('.custom-dropdown') // Sélectionne le menu déroulant parent
                .find('.dropdown-trigger') // Sélectionne le déclencheur du menu déroulant
                .html(
                    $(this).text().toUpperCase() + '<span class="dropdown-arrow"></span>'
                ); // Met à jour le texte du déclencheur avec la nouvelle sélection
        });

    // Écouteur d'événement sur le bouton "Charger plus" pour charger des photos supplémentaires
    $('#load-more').on('click', function (e) {
        e.preventDefault(); // Empêche le comportement par défaut du clic (comme un rechargement de page)
        load_more_photos(); // Appelle la fonction qui envoie la requête AJAX
    });

// Fonction qui gère la requête AJAX pour charger des photos
    function load_more_photos() {
        $.ajax({
            url: ajaxData.url, // URL où la requête AJAX sera envoyée (définie via wp_localize_script côté WordPress)
            type: 'POST', // Méthode HTTP utilisée pour envoyer la requête
            data: {
                action: 'load_photo_grid', // Action qui déclenche une fonction spécifique dans WordPress
                nonce: ajaxData.nonce,     // Jeton de sécurité pour protéger la requête contre les abus
                posts_per_page: postsPerPage, // Nombre de photos à récupérer par page
                offset: offset, // Position de départ pour récupérer les photos (utile pour la pagination)
                category: category,  // Catégorie sélectionnée pour filtrer les photos
                format: format,     // Format sélectionné pour filtrer les photos
                order: order,       // Ordre de tri (ASC ou DESC)
            },
            beforeSend: function () {
                $('#load-more').text('Chargement...'); // Modifie le texte du bouton pour indiquer qu'un chargement est en cours
            },
            success: function (response) {
                 // Cette fonction est appelée lorsque la requête réussit
                if (response) {
                    $('.photo-grid').append(response); // Ajoute les nouvelles photos retournées par le serveur à la grille existante
                    offset += postsPerPage; // Incrémente l'offset pour la prochaine requête
                    $('#load-more').text('Charger plus'); // Remet le texte par défaut sur le bouton
    
                      // Appelle une fonction pour mettre à jour des données ou effectuer d'autres actions après ajout des photos
                    updateImages(); 
                } else {   // Si aucune donnée n'est retournée (toutes les photos ont été chargées), on cache le bouton "Charger plus" et on affiche "aucune photo trouvée"
                    $('#load-more').hide();
                    $('.photo-grid').append('<p>Aucune photo trouvée.</p>');
                }
            },
             // Cette fonction est appelée en cas d'échec de la requête AJAX
            error: function () {
                alert('Erreur lors du chargement des photos.'); // Affiche un message d'erreur
            },
        });
    }

   // Fonction pour mettre à jour les données des images ajoutées dans la grille
    function updateImages() {
        var images = []; // Tableau pour stocker les données des images
        var currentIndex = 0; // Variable d'index pour suivre les images (peut être utilisée dans une autre logique)

       // Parcourt tous les éléments d'image ayant la classe ".fullscreen" dans les éléments ".photo-item"
        $('.photo-item .fullscreen').each(function () {
            var imageData = {
                url: $(this).data('image'), // Récupère l'URL de l'image depuis l'attribut "data-image"
                title: $(this).data('title'), // Récupère le titre de l'image depuis l'attribut "data-title"
                categories: $(this).data('categories') // Récupère les catégories depuis l'attribut "data-categories"
            };
        
            // Vérifie que toutes les données nécessaires sont présentes
            if (imageData.url && imageData.title && imageData.categories) {
                images.push(imageData); // Ajoute les données de l'image au tableau
            } else {
                console.warn("Données manquantes pour une image:", imageData); // Avertit si certaines données sont manquantes
            }
        });
            }
             // À ce stade, le tableau `images` contient toutes les informations des images ajoutées 
        });
