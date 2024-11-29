 /*BOUTON FILTRES DEROULANTS*/
 const dropdowns = document.querySelectorAll(".custom-dropdown");

 dropdowns.forEach((dropdown) => {
   const trigger = dropdown.querySelector(".dropdown-trigger");
   const options = dropdown.querySelector(".dropdown-options");
   const arrow = trigger.querySelector(".dropdown-arrow");

   // Ouvrir / fermer le menu au clic sur le trigger
   trigger.addEventListener("click", function (event) {
     event.stopPropagation(); // Empêche la propagation du clic pour éviter la fermeture immédiate

     // Fermer les autres menus
     dropdowns.forEach((d) => {
       if (d !== dropdown) {
         d.querySelector(".dropdown-options").classList.remove("active");
         d.querySelector(".dropdown-trigger").classList.remove("active");
         d.querySelector(".dropdown-arrow").classList.remove("rotated");
       }
     });

     // Basculer l'état du menu actuel
     options.classList.toggle("active");
     trigger.classList.toggle("active");
     arrow.classList.toggle("rotated");
   });
 });

 // Fermer les menus déroulants au clic en dehors
 document.addEventListener("click", (event) => {
   dropdowns.forEach((dropdown) => {
     const options = dropdown.querySelector(".dropdown-options");
     const trigger = dropdown.querySelector(".dropdown-trigger");
     const arrow = dropdown.querySelector(".dropdown-arrow");

     if (!dropdown.contains(event.target)) {
       // Si le clic est en dehors du dropdown
       options.classList.remove("active");
       trigger.classList.remove("active");
       arrow.classList.remove("rotated");
     }
   })
});
