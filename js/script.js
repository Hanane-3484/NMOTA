/* MODALE */
// Écouteur d'événement qui se déclenche lorsque le DOM est complètement chargé
document.addEventListener("DOMContentLoaded", function () {
  // Variables pour accéder à la modale et aux éléments du bouton de contact
  const modal = document.getElementById("contactModal"); // Récupère l'élément de la modale
  const contactLink = document.querySelector('[title="contact-menu"]'); // Sélectionne le lien dans le menu qui ouvre la modale
  const contactButtons = document.querySelectorAll(".contact-button.single-photo"); // Sélectionne tous les boutons de contact dans la page de photo unique

  // Ouvre la modale pour le lien de contact dans le menu
  if (contactLink) { // Vérifie si le lien existe
    contactLink.onclick = function (event) { // Ajoute un gestionnaire d'événement au clic sur le lien
      event.preventDefault(); // Empêche le comportement par défaut du lien (ne recharge pas la page)
      modal.style.display = "block"; // Affiche la modale en modifiant son style (affichage de la modale)
    };
  }

  // Ajoute un événement de clic uniquement sur les boutons de contact de la page photo unique
  contactButtons.forEach((button) => { // Pour chaque bouton de contact
    button.addEventListener("click", function (event) { // Ajoute un gestionnaire d'événement au clic sur chaque bouton
      event.preventDefault(); // Empêche le comportement par défaut du bouton

      // Ouvre la modale
      modal.style.display = "block"; // Affiche la modale

      // Récupère la référence de la photo depuis l'attribut 'data-photo-ref' du bouton
      const photoRef = this.getAttribute("data-photo-ref"); // Récupère la valeur de l'attribut data-photo-ref

      // Remplit automatiquement le champ de référence dans le formulaire
      const referenceField = document.querySelector("#photo-reference"); // Sélectionne le champ de formulaire pour la référence
      if (referenceField) { // Si le champ de référence existe
        referenceField.value = photoRef; // Remplit le champ avec la référence de la photo
      }
    });
  });

  // Ferme la modale si on clique en dehors de la fenêtre de la modale
  window.onclick = function (event) { // Ajoute un gestionnaire d'événement au clic sur la fenêtre
    if (event.target === modal) { // Si l'utilisateur clique sur la modale elle-même
      modal.style.display = "none"; // Cache la modale
    }
  };
});