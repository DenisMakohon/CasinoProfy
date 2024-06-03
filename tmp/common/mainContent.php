<?php if(get_the_content()): ?>
    <section class="container mainContent" data-show_more="<?= !empty($GLOBALS["translations_page"]["show_more"]) ? $GLOBALS["translations_page"]["show_more"] : 'Show more'?>">
        <?php the_content(); ?>
    </section>
<?php endif; ?>