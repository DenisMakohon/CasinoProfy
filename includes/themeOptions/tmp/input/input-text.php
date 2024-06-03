<?php 
// $input_text_args = [
//     'css-class' => '',
//     'label'=>'Text', 
//     'type'=>'number', 
//     'name' => 'text_name',
//     'value' => 'val',
// ];
?>

<div class="input-container <?= isset($args['css-class']) ? esc_attr($args['css-class']) :'col-12' ?>">
    <label>
        <?php if(isset($args['label']) && !empty($args['label'])) : ?><p class="option-title"><?= esc_html($args['label']) ?></p> <?php endif; ?>
        <input 
            <?= isset($args['required']) ? "required" : ""?>
            <?= isset($args['css-input']) ? 'class="'.$args['css-input'].'"' : ""?>
            type="<?= esc_attr($args['type']) ?>"             
            name="<?= esc_attr($args['name']) ?>" 
            value="<?= esc_attr(wp_unslash($args['value'])) ?>">
    </label>
</div>