<div class="row">
    <ul class="col-12 breadcrumbs text d-flex flex-wrap" itemscope itemtype="https://schema.org/BreadcrumbList">
        <?php
        $breadcrumb = !empty($pageSettings['breadcrumb']) ? $pageSettings['breadcrumb'] : get_the_title();
        
        $home_url = $GLOBALS['translations_page']['main_page'];
        $home_title = get_blog_details()->path == '/en/' ? "Online Casino Reviews UK" : 'CasinoProfy';
        $position = 0;

        // Главная страница
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a href="'.$home_url.'" itemprop="item" itemid="'.$home_url.'">';
        echo '<span itemprop="name">'.$home_title.'</span>';
        echo '<meta itemprop="position" content="'.$position.'">';
        echo '</a></li>';

        // Остальные страница
        if (!is_home() && !is_front_page()) {
            $position++;

            // Родительская стрпница
            $post_ancestors = get_post_ancestors(get_the_ID());
            foreach (array_reverse($post_ancestors) as $ancestor_id) {
                $ancestor = get_post($ancestor_id);
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . get_permalink($ancestor->ID) . '" itemprop="item" itemid="' . get_permalink($ancestor->ID) . '">';
                echo '<span itemprop="name">' . get_the_title($ancestor->ID) . '</span>';
                echo '<meta itemprop="position" content="' . $position . '">';
                echo '</a></li>';
                $position++;
            }

            // Текущая страница
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . $breadcrumb . '</span>';
            echo '<meta itemprop="position" content="' . $position . '">';
            echo '</li>';
        }
        ?>
    </ul>
</div>
