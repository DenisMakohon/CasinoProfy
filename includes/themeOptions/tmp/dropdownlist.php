<?php 

    // $input_dropdownlist_args = [
    //     'options' => {cur_ids_array},
    //     'all'     => {all_posts},
    //     'name'    => 'best_choice_casinos[ids]',
    //     'css-class' => 'col-md-10'
    // ];
    
    $currentOptions = $args['options'] ? $args['options'] : ['-1'];
    $allItems = $args['all'];
    $inputName = $args['name'];
    
?>
<div class="input-container <?= isset($args['css-class']) ? esc_attr($args['css-class']) :'col-12' ?>">
<p class="option-title">Вивести казино:</p> 
<div class='input-dropdown-container js-inputDropdownContainer' data-oplion='<?=$inputName?>'>
    <div class='dropdown-item-container js-itemContainer d-flex flex-wrap align-item-start'>
    <input type='hidden' data-curcasino='-1' value='-1' name='<?=$inputName."[-1]"?>' class='js-dropdownItemId'/>

    <!-- Вывод текущих опций -->
<?php foreach($allItems as $item_num => $item){ 
        $cur_num = array_search($item->ID, $currentOptions);

        if (in_array($item->ID, $currentOptions)) {
?>
        <div class='dropdown-item js-dropdownItem'>
            <span><?=$item->post_title?></span>
            <span class='js-dropdownItemRemove dropdown-item-remove'></span>
            <input type='hidden' data-curcasino='<?=$cur_num?>' value='<?=$item->ID?>' name='<?=$inputName."[".$cur_num."]"?>' class='js-dropdownItemId'/>
        </div>
<?php }} ?>
    </div>
    <p class='sameItem js-sameItem'>Це казино вже є у списку</p>
    <input type='text' value='' class='js-filterSelect'/> 
    <!-- Вывод общего списка -->
    <ul class='input-dropdown js-inputDropdown'>
<?php foreach($allItems as $item){ ?>
        <li class='show' data-id='<?=$item->ID?>'><?=$item->post_title?></li>
<?php } ?>
    </ul>
</div>
</div>
