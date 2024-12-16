<?php

    $news_id = get_option('page_for_posts'); 
    $cat_nav_featured = get_field('category_nav_featured', $news_id);
    $cat_nav_additional = get_field('category_nav_additional', $news_id);

if( $cat_nav_featured || $cat_nav_additional ): ?>

    <nav class="cat-nav">   
        <ul class="cat-nav__featured<?php if(!$cat_nav_featured): ?> inactive<?php endif; ?>">
            <?php if($cat_nav_featured): ?>            
                <?php foreach( $cat_nav_featured as $cat ): ?>
                    <li class="cat-nav__item">
                        <a class="cat-nav__link" href="<?php echo get_term_link($cat); ?>">
                            <?php echo get_term( $cat )->name; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if($cat_nav_additional): ?>
                <li class="cat-nav__more">
                    <a class="cat-nav__dropdown-target" href="#">
                        <span class="cat-nav__dropdown-target-label">Browse by Topic</span>
                        <span class="cat-nav__dropdown-target-icon"><?php include(get_template_directory() . '/svg/down-caret.php'); ?></span>
                    </a>

                    <ul class="cat-nav__dropdown">
                        <?php foreach( $cat_nav_additional as $cat ): ?>
                            <li class="cat-nav__dropdown-item">
                                <a class="cat-nav__dropdown-link" href="<?php echo get_term_link($cat); ?>">
                                    <?php echo get_term( $cat )->name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

<?php endif; ?>