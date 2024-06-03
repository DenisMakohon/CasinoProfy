<div class="input-container <?= isset($args['css-class']) ? esc_attr($args['css-class']) :'col-12' ?>">
    <label>
        <?php if(isset($args['label']) && !empty($args['label'])) : ?><p class="option-title"><?= esc_html($args['label']) ?></p> <?php endif; ?>
        <textarea rows="10" cols="15" name="<?= esc_attr($args['name']) ?>"><?= esc_textarea(wp_unslash($args['value'])) ?></textarea>
    </label>
</div>