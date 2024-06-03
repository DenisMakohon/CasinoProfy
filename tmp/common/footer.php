<?php get_template_part( '/tmp/common/popupCookie', null ); ?>
<footer>
    <div class="container">
        <div class="row">
            <?php
            if (has_nav_menu('Footer_menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'Footer_menu',
                    'menu_class' => 'nav-footer d-flex justify-content-between',
                    'container_class' => 'nav-footer-list col-12',
                ));
            }
            ?>
        </div>
        <div class="row footerInfo-container flex-md-row flex-column-reverse">
            <div class="maskot d-flex align-items-md-end align-items-center justify-content-md-start justify-content-between">
                <img src="<?=IMG_URL?>footer/maskot-footer.svg" alt="maskot" width="217" height="288">
                <?php if ("https://onlinecasinoprofy.org" != $GLOBALS['domain_url']) { ?>
                    <div class="followUs mobile">
                        <p class="followUs-title">
                            <?= $GLOBALS['translations_page']['follow_us'] ?>
                        </p>
                        <ul class="followUs-list d-flex flex-wrap align-items-center justify-content-between">
                            <li>
                                <a class="d-flex" rel="nofollow" href="https://facebook.com/" target="_blank">
                                    <img src="<?= IMG_URL ?>footer/facebook.svg" alt="facebook icon" width="28"
                                         height="27">
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" rel="nofollow" href="https://twitter.com/" target="_blank">
                                    <img src="<?=IMG_URL?>footer/twitter.svg" alt="twitter icon" width="28" height="27">
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" rel="nofollow" href="https://pl.pinterest.com/onlinecasinoprofy/"
                                   target="_blank">
                                    <img src="<?=IMG_URL?>footer/pinterest.svg" alt="pinterest icon" width="28" height="27">
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" rel="nofollow" href="https://youtube.com/" target="_blank">
                                    <img src="<?=IMG_URL?>footer/youtube.svg" alt="youtube icon" width="28" height="27">
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="footerInfo">
                <ul class="d-flex justify-content-between logos <?= $GLOBALS['currentLang'] ?>">
                    <li>
                        <?php if ($GLOBALS['currentLang'] == "gr") { ?>
                            <span>
							    <img src="<?=IMG_URL?>footer/21plus.svg" alt="21+ logo" width="84" height="84">
						    </span>
                        <?php } else { ?>
                            <span>
							    <img src="<?=IMG_URL?>footer/18plus.png" alt="18+ logo" width="84" height="84">
						    </span>
                        <?php } ?>
                    </li>
                    <li>
						<span>
							<a href="https://www.gamcare.org.uk/" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/problem_gambling_support.png"
                                     alt="problem gambling support logo" width="182" height="78">
							</a>							
						</span>
                    </li>
                    <li>
						<span>
							<a href="https://www.gamblingcommission.gov.uk/" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/gambling_comission.png" alt="gambling comission logo"
                                     width="256" height="80">
							</a>
						</span>
                    </li>
                    <li>
						<span>
							<a href="https://www.begambleaware.org/" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/gambleaware_helpline.png" alt="gambleaware_helpline logo"
                                     width="292" height="64">
							</a>
						</span>
                    </li>
                    <?php if ("https://onlinecasinoprofy.org" != $GLOBALS['domain_url']) { ?>
                        <li>
						<span>
							<a href="https://certify.gpwa.org/verify/onlinecasinoprofy.com/"
                               onclick="return GPWAVerificationPopup(this)" id="GPWASeal">
								<img src="https://certify.gpwa.org/seal/onlinecasinoprofy.com/" class="clickable"
                                     onError="this.width=0; this.height=0;" border="0" alt="GPWA logo"/>
								<img src="<?=IMG_URL?>GPWA_logo.gif" alt="GPWA logo" class="showimg" width="183" height="69">
							</a>
						</span>
                        </li>
                    <?php } ?>
                    <li>
						<span>
							<a href="https://www.gamstop.co.uk/" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/gamstop.svg" alt="gambleaware_helpline logo" width="166"
                                     height="30">
							</a>
						</span>
                    </li>
                    <?php if ("https://onlinecasinoprofy.org" != $GLOBALS['domain_url']) { ?>
                        <li>
						<span>
							<a href="//www.dmca.com/Protection/Status.aspx?ID=6dd91db6-e9fd-4f3e-aacb-3190893a698b"
                               target="_blank" rel="nofollow" title="DMCA.com Protection Status"
                               class="dmca-badge"> <img
                                        src="https://images.dmca.com/Badges/_dmca_premi_badge_3.png?ID=6dd91db6-e9fd-4f3e-aacb-3190893a698b"
                                        width="89" height="44" alt="DMCA.com Protection Status"/></a>  <script defer async
                                    src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
						</span>
                        </li>
                    <?php } ?>
                </ul>
                <?php if ($GLOBALS['currentLang'] == "es") { ?>
                    <ul class="d-flex justify-content-between logos es-list-logo">
                        <li>
						<span>
							<a href="https://www.ordenacionjuego.es/es/rgiaj" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/logo_autoprohibicion.svg"
                                     alt="Autoprohibición" width="80" height="78">
							</a>
						</span>
                        </li>
                        <li>
						<span>
							<a href="https://www.juegoseguro.es/" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/juegoseguro_logo.svg" alt="Juego Seguro"
                                     width="146" height="80">
							</a>
						</span>
                        </li>
                        <li>
						<span>
							<a href="https://www.jugarbien.es/" target="_blank" rel="nofollow">
								<img src="<?=IMG_URL?>footer/logo_jugarbien.svg" alt="Jugarbien"
                                     width="152" height="64">
							</a>
						</span>
                        </li>
                        <li>
						<span>

								<img src="<?=IMG_URL?>footer/juega_con_responsabilidad.svg" alt="Juega con Responsabilidad"
                                     width="146"
                                     height="30">

						</span>
                        </li>
                    </ul>
                <?php } ?>
                <div class="footerInfo-bottom d-flex">
                    <?php if ("https://onlinecasinoprofy.org" != $GLOBALS['domain_url']) { ?>
                        <div class="followUs desktop">
                            <p class="followUs-title">
                                <?= $GLOBALS['translations_page']['follow_us'] ?>
                            </p>
                            <ul class="followUs-list d-flex flex-wrap align-items-center justify-content-between">
                                <li>
                                    <a class="d-flex" rel="nofollow" href="https://www.facebook.com/bill.profy/"
                                       target="_blank">
                                        <img src="<?=IMG_URL?>footer/facebook.svg" alt="facebook icon" width="28"
                                             height="27">
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex" rel="nofollow" href="https://twitter.com/casinoprofy"
                                       target="_blank">
                                        <img src="<?=IMG_URL?>footer/twitter.svg" alt="twitter icon" width="28" height="27">
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex" rel="nofollow" href="https://pl.pinterest.com/onlinecasinoprofy/"
                                       target="_blank">
                                        <img src="<?=IMG_URL?>footer/pinterest.svg" alt="pinterest icon" width="28"
                                             height="27">
                                    </a>
                                </li>
                                <li>
                                    <a class="d-flex" rel="nofollow"
                                       href="https://www.youtube.com/channel/UCDxqsOP1miLhTduAwpdq0zQ" target="_blank">
                                        <img src="<?=IMG_URL?>footer/youtube.svg" alt="youtube icon" width="28" height="27">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="text"><?= stripcslashes(get_option('footer_text')) ?></div>
                </div>
            </div>
        </div>
    </div>
</footer>