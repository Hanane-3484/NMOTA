/* MENU BURGER */
// Fonction pour basculer l'état du menu burger
function toggleMenu() {
  // Sélectionne l'élément du menu principal à l'aide de son ID
  const menu = document.getElementById("menu-header");
  // Sélectionne l'icône de fermeture à l'aide de son ID
  const closeIcon = document.getElementById("close-icon");
  // Sélectionne l'icône du burger à l'aide de son ID
  const burgerIcon = document.getElementById("burger-icon");

  // Ajoute ou supprime la classe "active" sur le menu
  // Cela permet de contrôler l'affichage du menu (visible ou caché)
  menu.classList.toggle("active");

  // Vérifie si le menu contient la classe "active"
  if (menu.classList.contains("active")) {
      // Si le menu est actif, affiche l'icône de fermeture
      closeIcon.style.display = "block";
      // Masque l'icône du burger
      burgerIcon.style.display = "none";
  } else {
      // Si le menu n'est pas actif, masque l'icône de fermeture
      closeIcon.style.display = "none";
      // Affiche l'icône du burger
      burgerIcon.style.display = "block";
  }
}