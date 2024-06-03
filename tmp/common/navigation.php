<nav class="js-nav">
    <div class="custom-container">
        <div class="row align-items-center nav-container">
            <a class="logo d-flex" href="<?php echo $GLOBALS['domain_url']; if ($GLOBALS['currentLang'] == 'en_US') {
                echo "";
            } else {
                echo $GLOBALS['translations_page']['main_page'];
            } ?>">
                <img src='<?=IMG_URL?>navigation/casinoprofy-logo.svg' alt="CasinoProfy logo" width="130" height="46">
            </a>

            <div class="d-flex justify-content-start nav-tableOfContents">

                <div class="top-toc-wrap">
                    <div class="top-toc-col"></div>
                    <img src='<?=IMG_URL?>navigation/casinoprofy-logo.svg' alt="CasinoProfy logo" width="130" height="46">
                    <div class="top-toc-close-btn" id="top-toc-close-btn">
                        <img src='<?=IMG_URL?>navigation/close-icon.svg' alt="close-btn" width="48" height="48">
                    </div>
                </div>

                <div class="menu-toc-wrap">
                    <?php

                    $pattern = '/data-anchor="([^"]+)"/';
                    preg_match_all($pattern, get_the_content(), $h2_anchors);

                    if(!empty($h2_anchors[1]) && !(isset($GLOBALS['hide_content']['content']['shortcodes']) && in_array('contains', $GLOBALS['hide_content']['content']['shortcodes']))): ?>
                        <div class="tableOfContents-title"><?= $GLOBALS['translations_page']['tabel_of_content'] ?></div>
                        <?php

                        $out = "
                            <div id='tableOfContents' class='flex-wrap'>
                            <ul>
                        ";

                        foreach ($h2_anchors[1] as $anchor) {
                            $spaces_id = preg_replace('/\s/', '-', $anchor);
                            $out .= '<li><a href="#' . $spaces_id . '">' . mb_substr($anchor, 0, -2) . '</a></li>';
                        }

                        $out .= "</ul>              
                            </div>";
                        echo $out;
                    endif;

                    ?>
                </div>
            </div>
            <?php 

            $langSwitcher = strtoupper(trim(get_blog_details()->path, "/"));
            $langSwitcher_list = langSwitch();
            if( empty($langSwitcher) ) $langSwitcher = substr(get_option('lang')['html'], -2);

            ?>
            <div class="d-flex justify-content-start nav">
                <div class="top-nav-wrap">
                <?php if (!get_option('hreflang_lgsw')) : ?>
                    <div class="language">
                        <span class="d-flex align-items-center js-openLanguage language-open">
                            <div class="language-icon-border">
                                <img class="language-icon" src="<?=IMG_URL?>langSwitcher/<?=strtoupper($langSwitcher)?>.svg"
                                width="32" height="32" alt="language icon">
                            </div>
                            <?php if($langSwitcher_list): ?>
                                <img class="arrow" src="<?=IMG_URL?>white-arrow-down.svg" alt="arrow icon" width="12" height="8">
                            <?php endif; ?>
                        </span>
                        <?=$langSwitcher_list?>
                    </div>
                    <?php endif; ?>
                    <a class="d-flex" href="<?php echo $GLOBALS['domain_url']; if ($GLOBALS['currentLang'] == 'en_US') {
                        echo "";
                    } else {
                        echo $GLOBALS['translations_page']['main_page'];
                    } ?>">
                        <img src='<?=IMG_URL?>navigation/casinoprofy-logo.svg' alt="CasinoProfy logo" width="130" height="46">
                    </a>
                    
                    <div class="top-nav-close-btn" id="top-nav-close-btn">
                        <img src='<?=IMG_URL?>navigation/close-icon.svg' alt="close-btn" width="48" height="48">
                    </div>
                </div>

                <!-- NAVIGATION OUTPUT -->

                <?php
                if (has_nav_menu('Main_menu')) {

                    wp_nav_menu(array(
                        'theme_location' => 'Main_menu',
                        'menu_class' => 'align-items-center d-flex flex-xl-row menu-main-menu nav-container',
                        'container_class' => 'nav-list ',
                        'walker' => new Menu_With_Arrows
                    ));
                }
                ?>

                <div class="nav-search-wrap">
                    <div class='nav-search'>
                        <div class='nav-search-form'>
                            <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                                <div class="search-input">
                                    <input
                                        maxlength="255"
                                        type="search"
                                        class="search-field"
                                        autocomplete="off"
                                        placeholder="<?php echo esc_attr_x($GLOBALS['translations_page']['search'], 'placeholder') ?>"
                                        value="<?php echo get_search_query() ?>"
                                        name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>"
                                    />
                                    <div class="search-submit">
                                        <input type="submit" class="js-ajax-search"
                                               value="<?php echo esc_attr_x('Search', 'submit button') ?>"/>
                                    </div>
                                    <div class="close tablet js-searchClose">
                                        <img src="<?=IMG_URL?>navigation/close-icon.svg" alt="search icon" width="32"
                                             height="32">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class='nav-search-results js-searchResults'></div>
                </div>

                <!-- END NAVIGATION OUTPUT -->

            </div>

            <div class="magnifier-ln-container d-flex align-items-center">

                <!-- SEARCH -->

                <div class="close-search js-searchContainer">
                    <div class="magnifier tablet js-magnifier d-flex">
                        <img src="<?=IMG_URL?>navigation/search.svg" alt="search icon" width="32" height="32">
                    </div>
                    <div class="close tablet js-searchClose">
                        <img src="<?=IMG_URL?>navigation/search-close.svg" alt="search icon" width="32" height="32">
                    </div>
                    <div class="nav-search-container">
                        <div class='nav-search'>
                            <div class='nav-search-form'>
                                <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                                    <div class="search-input">
                                        <input
                                            maxlength="255"
                                            type="search"
                                            class="search-field"
                                            autocomplete="off"
                                            placeholder="<?php echo esc_attr_x($GLOBALS['translations_page']['search'], 'placeholder') ?>"
                                            value="<?php echo get_search_query() ?>"
                                            name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>"
                                        />
                                        <div class="search-submit">
                                            <input type="submit" class="js-ajax-search"
                                                   value="<?php echo esc_attr_x('Search', 'submit button') ?>"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class='nav-search-results js-searchResults'></div>
                    </div>
                </div>

                <!-- END SEARCH -->
                <?php if (!get_option('hreflang_lgsw')) : ?>
                <div class="language">
					<span class="d-flex align-items-center js-openLanguage language-open">
                        <div class="language-icon-border">
                            <img class="language-icon" src="<?=IMG_URL?>langSwitcher/<?=strtoupper($langSwitcher)?>.svg"
                            width="32" height="32" alt="language icon">
                        </div>						
                        <?php if($langSwitcher_list): ?>
                            <img class="arrow" src="<?=IMG_URL?>white-arrow-down.svg" alt="arrow icon" width="12" height="8">
                        <?php endif; ?>
						
					</span>

                <?php echo $langSwitcher_list;
                endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="nav-mobile">
    <ul class="nav-mobile-list d-flex align-items-center justify-content-around">
        <li class="nav-mobile-item">
            <?php
            if(!empty($h2_anchors[1]) && !(isset($GLOBALS['hide_content']['content']['shortcodes']) && in_array('contains', $GLOBALS['hide_content']['content']['shortcodes']))):
            ?>
            <div class="nav-mobile-link d-flex flex-column align-items-center js-openTableOfContents">
                <img src="<?=IMG_URL?>navigation/table-of-content-icon.svg" alt="Casinos icon" width="32" height="32">
                <span><?= $GLOBALS['translations_page']['tabel_of_content'] ?></span>
            </div>
            <?php endif; ?>
        </li>
        <a class="logo d-flex" href="<?php echo $GLOBALS['domain_url']; if ($GLOBALS['currentLang'] == 'en_US') {
            echo "";
        } else {
            echo $GLOBALS['translations_page']['main_page'];
        } ?>">
            <img src='<?=IMG_URL?>navigation/casinoprofy-logo.svg' alt="CasinoProfy logo" width="130" height="46">
        </a>
        <li class="nav-mobile-item">
            <div class="nav-mobile-link d-flex flex-column align-items-center js-openMenuMobile">
                <div class="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span><?= $GLOBALS['translations_page']['menu'] ?></span>
            </div>
        </li>
    </ul>
</div>