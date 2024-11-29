/*MODALE*/
document.addEventListener("DOMContentLoaded", function () {
  // Variables pour la modale et les éléments du bouton
  const modal = document.getElementById("contactModal");
  const contactLink = document.querySelector('[title="contact-menu"]');
  const contactButtons = document.querySelectorAll(".contact-button.single-photo"); // Sélectionner uniquement les boutons de contact pour la page photo unique

  // Ouvrir la modale pour le lien de contact du menu (si vous souhaitez toujours ouvrir la modale depuis le menu)
  if (contactLink) {
    contactLink.onclick = function (event) {
      event.preventDefault();
      modal.style.display = "block";
    };
  }

  // Ajouter l'événement de clic uniquement sur les boutons de contact de la page photo unique
  contactButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      // Ouvre la modale
      modal.style.display = "block";

      // Récupère la référence de la photo depuis l'attribut data-photo-ref du bouton
      const photoRef = this.getAttribute("data-photo-ref");

      // Remplit automatiquement le champ de référence dans le formulaire
      const referenceField = document.querySelector("#photo-reference");
      if (referenceField) {
        referenceField.value = photoRef;
      }
    });
  });

  // Fermer la modale si on clique en dehors de la fenêtre de la modale
  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
});