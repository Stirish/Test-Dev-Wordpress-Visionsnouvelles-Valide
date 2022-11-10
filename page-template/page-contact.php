<?php

/**
 * Template Name: Contact page
 * Template Post Type: page
 * 
 * @package testdevvn
 */

get_header() ?>

<div class="row justify-content-center">
    <div class="col-8">
        <form>
            <div class="form-row">
                <div class="form-group col">
                    <label for="last-name">Nom</label>
                    <input type="text" class="form-control" id="last-name">
                </div>
                <div class="form-group col">
                    <label for="first-name">Prénom</label>
                    <input type="text" class="form-control" id="first-name">
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="object">Objet</label>
                <input type="text" class="form-control" id="object">
            </div>
            <div class="form-group">
                <label for="textarea">Message</label>
                <textarea class="form-control" id="textarea" rows="7"></textarea>
            </div>
            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="form-btn">ENVOYER</button>
            </div>
        </form>
    </div>
</div>

<?php get_footer() ?>