<?php
// $input_checkbox_args = [
//     'css-class' => '',
//     'label'=>'Checkbox', 
//     'type'=>'radio', 
//     'name' => 'checkbox_name', 
//     'value' => [],
//     'options' => [ 
//         [
//             'label' => 'Checkbox 1 label',
//             'value' => 'Checkbox 1 value'
//         ],
//         [
//             'label' => 'Checkbox 2 label',
//             'value' => 'Checkbox 2 value'
//         ],
//         [
//             'label' => 'Checkbox 3 label',
//             'value' => 'Checkbox 3 value'
//         ],
//         ]
// ];

if(gettype($args['value']) == 'string' ) $args['value'] = [$args['value']];
?>
<div class="input-container input-switch <?= isset($args['css-class']) ? esc_attr($args['css-class']) :'col-12' ?>">
    <?php if(isset($args['label']) && !empty($args['label'])) : ?><p class="option-title"><?= esc_html($args['label']) ?></p> <?php endif; ?>
    <?php 
        foreach($args['options'] as $field => $value){
    ?>
        <label class="d-flex">
            <?php if(isset($value['label']) && !empty($value['label'])) : ?><p class="option-title"><?= esc_html($value['label']) ?></p> <?php endif; ?>
            <?php if($args['type'] == 'checkbox' && count($args['options']) == 1){ ?>
                <input 
                type="hidden" 
                name="<?= $args['name'] ?>" value="">
            <?php } ?>            
            <input 
            <?php if(in_array($value['value'], $args['value'])) echo 'checked'; ?> 
            type="<?= $args['type'] ?>" 
            name="<?= $args['name'] ?>" value="<?= $value['value'] ?>">
            <div class="switch"></div>
        </label>
    <?php } ?>    
</div>