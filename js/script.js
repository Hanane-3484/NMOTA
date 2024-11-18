/*Modale*/
document.addEventListener("DOMContentLoaded", function () {
const modal = document.getElementById("contactModal");
const contactLink = document.querySelector('[title="contact"]');
if (contactLink) {
    contactLink.onclick = function(event) {
    event.preventDefault(); 
    modal.style.display = "block";
    }
}
window.onclick=function(event) {
if (event.target === modal) {
    modal.style.display = "none";
    }
}
});

/*MENU BURGER*/
function toggleMenu() {
    const menu = document.getElementById('menu-header');
    const closeIcon = document.getElementById('close-icon');
    const burgerIcon = document.getElementById('burger-icon');
    
    // Toggle the active class on the menu
    menu.classList.toggle('active');
    
    // Toggle the visibility of the burger and close icon
    if (menu.classList.contains('active')) {
        closeIcon.style.display = 'block';
        burgerIcon.style.display = 'none';
    } else {
        closeIcon.style.display = 'none';
        burgerIcon.style.display = 'block';
    }
}
/*BOUTON CONTACT ET REF PHOTO PRÉ REMPLI*/
document.addEventListener("DOMContentLoaded", function () {
    // Variables pour la modale et le bouton
    const modal = document.getElementById("contactModal");
    const contactButtons = document.querySelectorAll(".contact-button");

    // Ajoute l'événement au clic pour chaque bouton de contact
    contactButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            // Ouvre la modale
            modal.style.display = "block";

            // Récupère la référence de la photo depuis le bouton
            const photoRef = this.getAttribute("data-photo-ref");

            // Remplit automatiquement le champ de référence dans le formulaire
            const referenceField = document.querySelector("#photo-reference");
            if (referenceField) {
                referenceField.value = photoRef;
            }
        });
    });

    // Ferme la modale au clic en dehors de la fenêtre de la modale
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});