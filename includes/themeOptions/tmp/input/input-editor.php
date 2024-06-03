<?php

// $input_editor_args = [
//     'label'   => 'Описание автора',
//     'value'   => stripcslashes($autor_value),
//     'name'    => "autors_site[list][$autor_num][$autor_field]",
//     'editor_id' => "autors_site_".$autor_num."_".$autor_field,
// ];

$settings =   array(
    'wpautop' => false,
    'media_buttons' => false,
    'textarea_name' => $args['name'], //You can use brackets here !
    'textarea_rows' => 8,
    'tabindex' => '323',
    'editor_css' => '',
    'editor_class' => '',
    'teeny' => false,
    'dfw' => false,
    'tinymce' => true,
    'quicktags' => true
);
?>
<div class="input-container <?= isset($args['css-class']) ? esc_attr($args['css-class']) :'col-12' ?>">
<?php

if(isset($args['label']) && !empty($args['label'])) : ?>
    <p class="option-title"><?= esc_html($args['label']) ?></p> 
<?php endif;

wp_editor($args['value'], $args['editor_id'], $settings);
?>
</div>