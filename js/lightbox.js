/*LIGHTBOX*/
jQuery(document).ready(function ($) {
    var images = []; // Tableau pour stocker les informations des images
    var currentIndex = 0; // Index de l'image actuellement affichée dans la lightbox

    // Fonction pour mettre à jour le tableau des images
    function updateImages() {
        images = []; // Réinitialise le tableau des images à chaque mise à jour
        jQuery('.photo-item .fullscreen').each(function () { // Pour chaque élément photo avec la classe .fullscreen
            var imageData = {
                url: jQuery(this).data('image'), // Récupère l'URL de l'image
                title: jQuery(this).data('title'), // Récupère le titre de l'image
                categories: jQuery(this).data('categories') // Récupère les catégories de l'image
            };

            // Vérifie que toutes les données nécessaires sont présentes avant d'ajouter l'image au tableau
            if (imageData.url && imageData.title && imageData.categories) {
                images.push(imageData); // Ajoute l'image au tableau si toutes les données sont valides
            } else {
                console.warn("Données manquantes pour une image:", imageData); // Avertit si des données sont manquantes pour une image
            }
        });
    }

    // Collecte les images au chargement initial
    updateImages(); // Appelle la fonction pour initialiser le tableau des images au chargement de la page

    // Affiche la lightbox au clic sur une image
    jQuery(document).on('click', '.fullscreen', function () {
        currentIndex = jQuery(this).index('.fullscreen'); // Récupère l'index de l'image cliquée parmi les éléments .fullscreen
        loadLightboxImage(images[currentIndex]); // Charge l'image correspondante dans la lightbox
        jQuery('#lightbox').addClass('lightbox'); // Affiche la lightbox en ajoutant la classe .lightbox
    });

    // Charge les données dans la lightbox
    function loadLightboxImage(imageData) {
        if (imageData && imageData.url) {
            jQuery('#lightbox-image').attr('src', imageData.url); // Affiche l'image dans la lightbox
            jQuery('#lightbox-title').text(imageData.title); // Affiche le titre de l'image
            jQuery('#lightbox-category').text(imageData.categories); // Affiche les catégories de l'image
        } else {
            console.error('Données de l\'image invalides:', imageData); // Affiche une erreur si les données de l'image sont invalides
        }
    }

    // Navigation vers l'image suivante
    jQuery(document).on('click', '.next-arrow', function () {
        currentIndex = (currentIndex + 1) % images.length; // Passe à l'image suivante (si c'est la dernière, revient à la première)
        loadLightboxImage(images[currentIndex]); // Charge la prochaine image dans la lightbox
    });

    // Navigation vers l'image précédente
    jQuery(document).on('click', '.prev-arrow', function () {
        currentIndex = (currentIndex - 1 + images.length) % images.length; // Passe à l'image précédente (si c'est la première, revient à la dernière)
        loadLightboxImage(images[currentIndex]); // Charge l'image précédente dans la lightbox
    });

    // Fermer la lightbox
    jQuery(document).on('click', '.close-lightbox', function () {
        jQuery('#lightbox').removeClass('lightbox'); // Cache la lightbox en retirant la classe .lightbox
    });

    // Fermer la lightbox en cliquant en dehors
    jQuery(document).on('click', function (event) {
        if (jQuery(event.target).is('#lightbox')) { // Si le clic est sur le fond de la lightbox
            jQuery('#lightbox').removeClass('lightbox'); // Cache la lightbox
        }
    });

    // Met à jour les images après un chargement AJAX
    jQuery(document).ajaxComplete(function () {
        updateImages(); // Met à jour le tableau des images lorsqu'un nouveau contenu est chargé via AJAX
    });
});