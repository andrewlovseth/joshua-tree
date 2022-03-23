<section class="more-owners grid">
    <div class="section-header">
        <h2><?php the_field('more_owners_headline'); ?></h2>
    </div>

    <?php $owners = get_field('more_owners'); if( $owners ): ?>
        <div class="employee-grid">
            <?php foreach( $owners as $owner ): ?>
                <div class="owner">
                    <div class="photo">
                        <a href="<?php echo get_permalink($owner->ID); ?>" class="photo-link">

                            <?php
                                $type = $owner->post_type;

                                if($type === "leadership") {
                                    $photo = get_field('info_headshot', $author->ID);
                                } else {
                                    $photo = get_field('info_photo', $author->ID);
                                }
                            ?>

                            <?php if( $photo ): ?>
                                <?php echo wp_get_attachment_image($photo['ID'], 'large'); ?>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="info">
                        <div class="headline name">
                            <h3><a href="<?php echo get_permalink($owner->ID); ?>"><?php echo get_the_title($owner->ID); ?></a></h3>
                        </div>

                        <div class="sub-title position">
                            <h4><?php the_field('info_position', $owner->ID); ?></h4>
                        </div>

                        <?php if(get_field('biography_fun_facts', $owner->ID)): ?>
                            <div class="copy-2">
                                <?php the_field('biography_fun_facts', $owner->ID); ?>
                            </div>
                        <?php endif; ?>

                        <div class="cta">
                            <a href="<?php echo get_permalink($owner->ID); ?>" class="btn btn-white-green">More</a>
                        </div>
                    
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
</section>