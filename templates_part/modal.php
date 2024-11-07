<!-- Modale de contact -->
<div id="contactModal" class="modal">
    <div class="modal-content">
<?php
        if (function_exists('do_shortcode')) {
    echo do_shortcode('[contact-form-7 id="83e624c" title="Contact Form"]');
} else {
    echo "Le formulaire ne peut pas être affiché.";
}
?>
    </div>
</div>