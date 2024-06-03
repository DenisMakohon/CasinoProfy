<?php 

/* Template Name: Choice language */ 

get_header('lang');

?>
<div class="choiceLanguage d-flex flex-column">
    <div class="choiceLanguage-container">
        <div class="choiceLanguage-wrap">
            <img class="choiceLanguage-logo" src="<?=IMG_URL?>navigation/casinoprofy-logo-black.svg" width="157" height="59" alt="casinoprofy-logo">
            <h2 class="text-center choiceLanguage-title">Choose Your Language</h2>
            <?php
            wp_nav_menu(array(
                'menu' => 'Choose Your Language',
                'menu_class' => 'langList d-flex justify-content-center',
                'walker' => new Menu_With_Description
            ));
            ?>
        </div>
    </div>
    <div class="align-items-end d-flex justify-content-center maskot text-center">
        <img src="<?=IMG_URL?>choice-language/maskot-languages.svg" width="526" height="382" alt="maskot languages">
    </div>
</div>

<?php get_footer('lang'); ?>