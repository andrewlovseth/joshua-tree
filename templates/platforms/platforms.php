<?php if(have_rows('platforms')): ?>

    <section class="platforms grid">

        <div class="section-header">
            <h3 class="section-headline small">Our Platforms</h3>
        </div>    

        <?php while(have_rows('platforms')) : the_row(); ?>

            <?php if( get_row_layout() == 'platform' ): ?>
                <?php
                    $photo = get_sub_field('photo');
                    $name = get_sub_field('name');
                    $description = get_sub_field('description');
                    $link = get_sub_field('link');
                ?>

                <div class="platform">
                    <div class="photo">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo wp_get_attachment_image($photo['ID'], 'medium'); ?>
                        </a>
                    </div>

                    <div class="info">
                        <div class="info__wrapper">
                            <div class="headline">
                                <h3 class="title-headline x-small"><?php echo $name; ?></h3>
                            </div>

                            <div class="excerpt copy copy-3">
                                <p><?php echo $description; ?></p>
                            </div>

                            <?php 
                                if( $link ): 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>

                                <div class="cta">
                                    <a class="btn btn-teal" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>                    

                </div>

            <?php endif; ?>

        <?php endwhile; ?>

    </section>

<?php endif; ?>