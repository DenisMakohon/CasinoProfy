<?php
// $input_file_args = [
//      'id' => 'csv_file',
//      'accept' => ".csv",
//      'name' => 'file_input_name', 
//      'action' => 'alternates_csv_upload'
// ];
?>
<label class="align-items-center d-flex drop-container flex-column js-inputFile">
    <input 
        type="file" 
        name="<?= $args['name'] ?>" 
        <?php if(isset($args['id'])) echo "id='".$args['id']."'";?> 
        accept="<?= $args['accept'] ?>"
    >
    <input 
        type="hidden" 
        name="action" 
        value="<?= $args['action'] ?>"
    > 
    <p class="drop-container-title text-center"><span class="drop-title">Перетягніть сюди CSV файл</span> <br> або </p>
    <span class="btn">Оберіть файл</span>
    <p class="drop-container-title text-center"> <br><br> Максимальний розмір <?=ini_get('upload_max_filesize');?></p>
    <span class="js-inputFileName drop-container-title-name"></span>
</label>