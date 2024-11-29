/*MENU BURGER*/
  function toggleMenu() {
    const menu = document.getElementById("menu-header");
    const closeIcon = document.getElementById("close-icon");
    const burgerIcon = document.getElementById("burger-icon");

    // Toggle the active class on the menu
    menu.classList.toggle("active");

    // Toggle the visibility of the burger and close icon
    if (menu.classList.contains("active")) {
      closeIcon.style.display = "block";
      burgerIcon.style.display = "none";
    } else {
      closeIcon.style.display = "none";
      burgerIcon.style.display = "block";
    }
  }