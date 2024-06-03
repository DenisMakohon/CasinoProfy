<?php

    // $input_image_args = [
    //     'css-class' => "col-md-2",
    //     'label' => "Иконка",
    //     'name' => 'best_choice_casinos[img]',
    //     'value' => $best_choice_casino['img']        
    // ];

    if(!isset($args['w']) || empty($args['w'])) $args['w'] = 115;
    if(!isset($args['h']) || empty($args['h'])) $args['h'] = 90;
    
    $default = get_stylesheet_directory_uri() .'/includes/themeOptions/static/images/no-image-icon.png';
    if( $args['value'] ) {
        $image_attributes = wp_get_attachment_image_src( $args['value'] );
        $args['src'] = $image_attributes[0];
    } else {
        $args['src'] = $default;
    }
?>
<div class="input-container <?= isset($args['css-class']) ? esc_attr($args['css-class']) :'col-12' ?>">
    <label>
        <?php if(isset($args['label']) && !empty($args['label'])) : ?><p class="option-title"><?= esc_html($args['label']) ?></p> <?php endif; ?>
        <div>
            <img data-src="<?= $default ?>" src="<?= $args['src'] ?>" width="<?= $args['w'] ?>px" height="<?= $args['h'] ?>px" />
            <div>
                <input type="hidden" required name="<?= $args['name'] ?>" id="<?= $args['name'] ?>" value="<?= $args['value'] ?>" />
                <button type="submit" class="upload_image_button button">Завантажити</button>
                <button type="submit" class="remove_image_button button">&times;</button>
            </div>
        </div>
    </label>
</div>