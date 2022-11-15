<?php

/**
 * Template Name: Contact page
 * Template Post Type: page
 * 
 * @package testdevvn
 */

get_header();
?>

<div class="row justify-content-center">
    <div class="col-8">
        <form action="" method="post" id="contact-form" name="contact-form" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col">
                    <label for="last-name" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="last-name" id="last-name" required>
                </div>
                <div class="form-group col">
                    <label for="first-name" class="form-label">Prénom</label>
                    <input type="text" class="form-control" name="first-name"id="first-name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="object" class="form-label">Objet</label>
                <input type="text" class="form-control" name="object" id="object" required>
            </div>
            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" name="message" id="message" rows="7" required></textarea>
            </div>
            <div class="form-group d-flex justify-content-end">
                <?php wp_nonce_field('ajax_contact_nonce', 'security'); ?>
                <button type="submit" class="form-btn">ENVOYER</button>
            </div>
        </form>
    </div>
</div>

<?php 
get_footer();
?>