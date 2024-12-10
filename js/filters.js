/* BOUTON FILTRES DÉROULANTS */
// Sélectionne tous les éléments de dropdown avec la classe "custom-dropdown"
const dropdowns = document.querySelectorAll(".custom-dropdown");

// Parcourt chaque élément dropdown trouvé
dropdowns.forEach((dropdown) => {
  // Sélectionne le bouton qui déclenche le menu (le "trigger")
  const trigger = dropdown.querySelector(".dropdown-trigger");
  // Sélectionne la liste des options associée au dropdown
  const options = dropdown.querySelector(".dropdown-options");
  // Sélectionne la flèche associée pour indiquer l'état du menu
  const arrow = trigger.querySelector(".dropdown-arrow");

  // Ajoute un gestionnaire d'événement pour ouvrir/fermer le menu lors d'un clic sur le trigger
  trigger.addEventListener("click", function (event) {
    // Empêche la propagation du clic pour éviter les effets indésirables
    event.stopPropagation();

    // Ferme tous les autres menus déroulants
    dropdowns.forEach((d) => {
      if (d !== dropdown) { // Ne ferme pas le menu actuellement cliqué
        // Supprime la classe "active" des autres menus pour les cacher
        d.querySelector(".dropdown-options").classList.remove("active");
        d.querySelector(".dropdown-trigger").classList.remove("active");
        d.querySelector(".dropdown-arrow").classList.remove("rotated");
      }
    });

    // Bascule l'état du menu actuel (ouverture/fermeture)
    options.classList.toggle("active"); // Affiche ou masque les options
    trigger.classList.toggle("active"); // Met en surbrillance le trigger actif
    arrow.classList.toggle("rotated"); // Fait pivoter la flèche pour indiquer l'état
  });
});

// Ajoute un gestionnaire d'événement global pour fermer les menus déroulants lors d'un clic en dehors
document.addEventListener("click", (event) => {
  // Parcourt chaque dropdown
  dropdowns.forEach((dropdown) => {
    // Sélectionne les parties du dropdown
    const options = dropdown.querySelector(".dropdown-options");
    const trigger = dropdown.querySelector(".dropdown-trigger");
    const arrow = dropdown.querySelector(".dropdown-arrow");

    // Si l'élément cliqué n'est pas contenu dans le dropdown actuel
    if (!dropdown.contains(event.target)) {
      // Ferme le menu en supprimant les classes actives
      options.classList.remove("active");
      trigger.classList.remove("active");
      arrow.classList.remove("rotated");
    }
  });
});