<?php

$reviews = get_option('reviews_clients');

if (!empty($reviews) && $reviews != 'popup_casinos_new' && isset($reviews['list']) && isset($reviews['title'])) :

    ?>

    <section class="container reviewsClients">
        <div class="reviewsClients__top-wrap">
            <h2 class="title-block">
                <?= $reviews['title'] ?>
            </h2>
            <div class="reviewsClients-controls js-reviewsClientsControls"></div>
        </div>

        <div class="js-reviewsClients">
            <?php

            foreach ($reviews['list'] as $reviews_val) {
                $reviews_photo = wp_get_attachment_image_src($reviews_val['photo']);
                ?>
                <div class="col-12 d-flex">
                    <div class="reviewsClients-item">
                        <p class="reviewsClients__img">
                            <img width="80" height="80" src="<?= $reviews_photo[0] ?>" alt="review-photo">
                        </p>
                        <p class="reviewsClients__name reviewsClients__info"><?= $reviews_val['name']; ?></p>
                        <p class="reviewsClients__url-company reviewsClients__info"><a target="_blank" href="<?= $reviews_val['url_company']; ?>"><?= $reviews_val['name_company']; ?></a></p>
                        <p class="reviewsClients__job-title reviewsClients__info"><?= $reviews_val['job_title']; ?></p>
                        <div class="reviewsClients__review">
                            <?= $reviews_val['review']; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

<?php endif; ?>