<section class="article-body grid">
    <div class="copy copy-2 extended">
        <?php the_content(); ?>
    </div>
    
    <div class="sidebar">
        <div class="date module">
            <h4>Date</h4>
            <p><?php the_time('F j, Y'); ?></p>

        </div>

        <div class="author module">
            <h4>Author</h4>
            <p><?php the_author(); ?></p>

        </div>

        <div class="social-share module">
            <h4>Share</h4>

            <div class="links">
                <div class="link facebook">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" rel="external">
                        <?php
                            $fb_icon = get_bloginfo('template_directory') . '/images/share-facebook.svg';
                            echo esa_svg($fb_icon);
                        ?>
                    </a>
                </div>

                <div class="link twitter">
                    <a href="https://twitter.com/intent/tweet/?text=<?php echo get_the_title(); ?>+<?php echo get_permalink(); ?>" rel="external">
                        <?php
                            $tw_icon = get_bloginfo('template_directory') . '/images/share-twitter.svg';
                            echo esa_svg($tw_icon);
                        ?>
                    </a>
                </div>

                <div class="link linkedin">
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=<?php echo get_the_title(); ?>" rel="external">
                        <?php
                            $li_icon = get_bloginfo('template_directory') . '/images/share-linkedin.svg';
                            echo esa_svg($li_icon);
                        ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>