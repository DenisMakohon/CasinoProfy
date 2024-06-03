<?php 
    $rating = get_field('rating_schema');
    
    if(!empty($rating) && (!empty($rating['rating']) || !empty($rating['rating_avg'])) ):
    $cur_reting = $rating['rating_type'] == "our" ? $rating['rating'] : $rating['rating_avg'];
    $round_cur_reting = round($cur_reting, 0, PHP_ROUND_HALF_UP);
    $cur_reting = round($cur_reting, 1);
    if($cur_reting > 5) $cur_reting = 5;
    if(!isset($rating['number_of_votes']) || !$rating['number_of_votes']) $rating['number_of_votes'] = 1;
?>
    <div class="container-fluid d-inline-flex justify-content-center user-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <div itemprop="itemReviewed" class="d-none" itemscope itemtype="http://schema.org/EntertainmentBusiness">
            <span itemprop="name" class="d-none"><?= the_title() ?></span>
        </div>
        <span itemprop="ratingValue" class="d-none"><?=$cur_reting?></span>
        <span itemprop="ratingCount" class="d-none"><?=$rating['number_of_votes']?></span>
        <?php for($i = 1; $i < 6; $i++): ?>
            <div class="user-rating-item <?php if($round_cur_reting >= $i ) echo "red"; ?>">
                <img src="<?=IMG_URL?>star.svg" alt="star" data-rating="<?=$i?>" width="21" height="21" class="user-rating-item-red">
                <img src="<?=IMG_URL?>star_gray.svg" alt="star gray" width="21" height="21" class="user-rating-item-gray">
            </div>
        <?php endfor; ?>
    </div>  
    <p class="text-center container-fluid"> (<?=$rating['number_of_votes']?>)</p>
<?php endif; ?>