document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("contactModal");
    const contactLink = document.querySelector('[title="contact"]');

 
    if (contactLink) {
        contactLink.onclick = function(event) {
            event.preventDefault(); 
            modal.style.display = "block";
        }
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});