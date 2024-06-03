<?php 
// Шорткод вывода FAQ в табах казино
function faq_tab(){
    if(!is_admin()):
        wp_reset_postdata();

        $faq_list = get_field('faq');
        if (!empty($faq_list)):
            if (empty($GLOBALS["content"]) || ($GLOBALS["content"] && isset($GLOBALS['hide_content']['shortcodes']) && in_array('faq', $GLOBALS['hide_content']['shortcodes']))):
        ob_start();
?>
       <div class="container faq">
            <h2 class="title-line" id="<?=$GLOBALS['translations_page']['faq']?>-❓" data-anchor="<?=$GLOBALS['translations_page']['faq']?> ❓"><?=$GLOBALS['translations_page']['faq']?></h2>
            <div class="row flex-md-row flex-column-reverse">
                <div class="col-md-9" itemscope itemtype="https://schema.org/FAQPage">
                    <?php foreach($faq_list as $faq): ?>
                        <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="faq-item">
                            <h3 itemprop="name" class="js-openAnswer">
                                <?=$faq['question']?>
                            </h3>
                            <div class="js-answer faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div itemprop="text" class="text"><?=$faq['answer']?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-3 text-center">
                    <img src="<?= IMG_URL ?>/masckot_faq.svg" class="faq-masckot" alt="masckot faq image" width="204" height="509">
                </div>
            </div>
        </div>
<?php
    $content = ob_get_clean();
    return $content;
    endif;
    endif;
    endif;
}

add_shortcode( 'faq', 'faq_tab' );                              // Шорткод вывода FAQ в табах казино