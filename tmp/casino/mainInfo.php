<section class="container mainInfo-container">
    <?php get_template_part('tmp/common/breadcrumbs', null ); ?>
    <div class="row">
        <h1 class="col-12 text-center"><?= the_title() ?></h1>
        <?php

        $parrent_page_id = '';
        
        if (isset($args['parrent_page_id']) && $args['parrent_page_id']) {
            global $post;
        
            $parrent_page_id = $args['parrent_page_id'];
            $post = get_post($args['parrent_page_id']);
        
        }
        
        // Если это дочерняя страница казино, то "переключаемся" на нее
        $pageSettings = get_fields($parrent_page_id);

        $extra_class = $post->post_name == "22bet-casino" ? "22bet-button" : "";
        $bonuses = get_field('bonus_block', $post->ID);

        if (!$bonuses) {
            $bonuses = [
                array(
                    "bonus_type" => array(
                        "value" => "",
                        "label" => "―"
                    ),
                    "text" => "―",
                    "short_text" => "-",
                    "t_c" => "",
                    "bonus_ref" => ""
                )
            ];
        }

        /*
        * Bonus On Top functionality
        */
        $valueWelcome = "Welcome Bonus";
        $valueDeposit = "No Deposit Bonus";
        $valueSpins = "Free Spins";
        $valueRoller = "High Roller Bonus";
        $valueCashBack = "Cashback Bonus";
        $valueReload = "Reload Bonus";
        $valueSpecial = "Special Offer";
        $valueVIP = "VIP Bonus";
        $getBonusOnTopVal = get_field('bonus_on_top', $post->ID);

        //default value
        $callbackFunc = "welcomeBonus";
        //check selected Bonus On Top
        if (isset($getBonusOnTopVal['label'])) {
            switch ($getBonusOnTopVal['label']) {
                case $valueDeposit:
                    $callbackFunc = "noDepositBonus";
                    break;

                case $valueWelcome:
                    $callbackFunc = "welcomeBonus";
                    break;

                case $valueSpins:
                    $callbackFunc = "freeSpins";
                    break;

                case $valueRoller:
                    $callbackFunc = "highRollerBonus";
                    break;

                case $valueCashBack:
                    $callbackFunc = "cashBackBonus";
                    break;

                case $valueReload:
                    $callbackFunc = "reloadBonus";
                    break;

                case $valueSpecial:
                    $callbackFunc = "SpecialOffer";
                    break;

                case $valueVIP:
                    $callbackFunc = "VIPBonus";
                    break;
            }
        }

        $bonusOnTopText = empty(array_values(array_filter($bonuses, $callbackFunc))) ? reset($bonuses) : array_values(array_filter($bonuses, $callbackFunc));

        $cols = array(
            'info' => "col-xl-9",
            'bonus' => "col-xl-3 offset-lg-3 offset-xl-0"
        );
        $lang_settings = get_option('lang');
        if (strpos($lang_settings['html'], 'en') !== false && $bonusOnTopText[0]['t_c']) {
            $cols = array(
                'info' => "col-xl-12",
                'bonus' => "col-md-6"
            );
        }

        $plashka_casino = get_option('plashka');

        $block_casino_info = block_casino($pageSettings);
        $ref_link = $block_casino_info['ref_link'];
        $casino_block = $block_casino_info['casino_block'];

        get_template_part('popup-casinos', '', $ref_link);
        ?>

        <div class="<?= $cols['info'] ?> mainInfo-container d-flex">
            <div class="mainInfo d-flex flex-md-row flex-wrap">
                <div class="mainInfo-logo d-flex flex-column">
                    <?php if (get_the_post_thumbnail_url($post, 'thumbnail')): ?>
                        <div class="mainInfo-logo-img d-flex align-items-center justify-content-center">
                            <a
                            href="<?= $ref_link ?>"
                            <?php if ($casino_block) echo 'data-popup="get_popup"'; ?>
                            rel="nofollow"
                            target="_blank"
                            class="<?= $extra_class ?>">
                                <img src="<?= get_the_post_thumbnail_url($post, 'thumbnail') ?>" width="150"
                                     height="150" alt="<?= the_title() ?> logo" class="imageShadow js-imageShadow">
                                <?php
                                $plashka_meta = get_post_meta($post->ID, 'plashka_new');
                                if (($plashka_casino != "plashka" || $plashka_casino != false) && isset($plashka_meta[0]) && $plashka_meta[0] != '' && isset($plashka_casino[$plashka_meta[0]])) {
                                    echo "<span class='mainInfo-logo-img-plashka' style='background: " . $plashka_casino[$plashka_meta[0]]['color'] . ";' >" . $plashka_casino[$plashka_meta[0]]['name'] . "</span>";
                                } ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex flex-wrap justify-content-center">
                        <?php get_template_part('tmp/common/rating', null); ?>
                    </div>
                    <?php if ($ref_link): ?>
                        <a rel="nofollow"
                           href="<?= $ref_link ?>"
                           <?php if ($ref_link != $casino_block) echo 'target="_blank"'; ?>
                           <?php if ($casino_block) echo 'data-popup="get_popup"'; ?>
                           class="btn btn-js <?= $extra_class ?>"><?= $GLOBALS['translations_page']['get_bonus_logo'] ?></a>
                    <?php endif; ?>
                </div>
                <?php if (isset($pageSettings['pluses']) && !empty($pageSettings['pluses'])): ?>
                    <ul class="mainInfo-plus">
                        <?php foreach ($pageSettings['pluses'] as $plus): ?>
                            <li><?= $plus['text'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="mainInfo-additionalInfo">
                    <p class="autor">
                        <?= $GLOBALS['translations_page']['author'] ?>: <strong>Bill Profy</strong>
                    </p>
                    <p class="modifyDate">
                        <?= $GLOBALS['translations_page']['updated'] ?>:
                        <strong class="d-inline-flex">
                            <?= get_the_modified_date('d') ?>
                            <?= $GLOBALS['translations_page']['month_'.get_the_modified_date('m')] ?>
                            <?= get_the_modified_date('Y') ?>
                        </strong>
                    </p>
                    <?php if ($pageSettings['number_of_games']): ?>
                        <div class="numberOfGames-container">
                            <p class="numberOfGames text"><?= $GLOBALS['translations_page']['number_of_games'] ?></p>
                            <div class="grayBgBlock">
                                <?= $pageSettings['number_of_games'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (isset($pageSettings['alert']) && $pageSettings['alert']): ?>
            <div class="<?= $cols['bonus'] ?> mainInfo-bonus-container alert d-flex align-items-center">
                <div class="grayBgBlock d-flex flex-column">
                    <p class="text-center">
                        <img src="<?= IMG_URL ?>casino/alert.svg" alt="alert icon" width="26" height="26">
                        <span>!!<?= $GLOBALS['translations_page']['alert_title'] ?>!!</span>
                        <img src="<?= IMG_URL ?>casino/alert.svg" alt="alert icon" width="26" height="26">
                    </p>
                    <p class="text"><?= $GLOBALS['translations_page']['alert_text'] ?></p>
                </div>
            </div>
        <?php
        elseif ($pageSettings['bonus_block']):
            if (isset($bonusOnTopText[0]['bonus_ref']) && $bonusOnTopText[0]['bonus_ref']) $ref_link = $bonusOnTopText[0]['bonus_ref'];
            ?>
            <div class="<?= $cols['bonus'] ?> mainInfo-bonus-container ">
                <div class="mainInfo-bonus">
                    <p class="mainInfo-bonus-title"><?= $GLOBALS['translations_page'][$pageSettings['bonus_on_top']['value']] ?></p>
                    <div class="mainInfo-bonus-text text">
                        <?= $bonusOnTopText[0]['text'] ?>
                    </div>
                    <?php if ($ref_link): ?>
                        <a
                            href="<?= $ref_link ?>"
                            rel="nofollow"
                            <?php if ($casino_block) echo 'data-popup="get_popup"'; ?>
                            <?php if ($ref_link != $casino_block) echo 'target="_blank"'; ?>
                            class="btn-white btn-js <?= $extra_class ?>">
                            <?= $GLOBALS['translations_page']['get_bonus_red'] ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($bonusOnTopText[0]['t_c']): ?>
            <div class="col-md-6 d-flex">
                <div class="mainInfo-bonus-description">
                    <?= $bonusOnTopText[0]['t_c'] ?>
                </div>
            </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>