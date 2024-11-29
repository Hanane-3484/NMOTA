/*LIGHTBOX*/
jQuery(document).ready(function ($) {
    var images = [];
    var currentIndex = 0;

    // Fonction pour mettre à jour le tableau des images
    function updateImages() {
        images = [];
        jQuery('.photo-item .fullscreen').each(function () { // Utiliser jQuery au lieu de $
            var imageData = {
                url: jQuery(this).data('image'),
                title: jQuery(this).data('title'),
                categories: jQuery(this).data('categories')
            };

            // Assurez-vous que toutes les données sont présentes avant d'ajouter
            if (imageData.url && imageData.title && imageData.categories) {
                images.push(imageData);
            } else {
                console.warn("Données manquantes pour une image:", imageData);
            }
        });
    }

    // Collecter les images au chargement initial
    updateImages();

    // Afficher la lightbox au clic sur une image
    jQuery(document).on('click', '.fullscreen', function () {
        currentIndex = jQuery(this).index('.fullscreen');
        loadLightboxImage(images[currentIndex]);
        jQuery('#lightbox').addClass('lightbox');
    });

    // Charger les données dans la lightbox
    function loadLightboxImage(imageData) {
        if (imageData && imageData.url) {
            jQuery('#lightbox-image').attr('src', imageData.url);
            jQuery('#lightbox-title').text(imageData.title);
            jQuery('#lightbox-category').text(imageData.categories);
        } else {
            console.error('Données de l\'image invalides:', imageData);
        }
    }

    // Navigation vers l'image suivante
    jQuery(document).on('click', '.next-arrow', function () {
        currentIndex = (currentIndex + 1) % images.length;
        loadLightboxImage(images[currentIndex]);
    });

    // Navigation vers l'image précédente
    jQuery(document).on('click', '.prev-arrow', function () {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        loadLightboxImage(images[currentIndex]);
    });

    // Fermer la lightbox
    jQuery(document).on('click', '.close-lightbox', function () {
        jQuery('#lightbox').removeClass('lightbox');
    });

    // Fermer la lightbox en cliquant en dehors
    jQuery(document).on('click', function (event) {
        if (jQuery(event.target).is('#lightbox')) {
            jQuery('#lightbox').removeClass('lightbox');
        }
    });

    // Mettre à jour les images après un chargement AJAX
    jQuery(document).ajaxComplete(function () {
        updateImages(); // Mettre à jour les images quand un nouveau contenu est ajouté
    });
});