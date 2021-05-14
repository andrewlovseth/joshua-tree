<?php 

$eos = get_field('employee_owner_spotlight');
$headline = $eos['headline'];
$owners = $eos['owners'];

if($owners): ?>

    <section class="eos grid">
        <div class="section-header">
            <h2><?php echo $headline; ?></h2>
        </div>

        <?php $count = 1; foreach( $owners as $owner ): ?>
            <div class="owner owner-<?php echo $count; ?>">
                <div class="photo">
                    <a href="<?php echo get_permalink($owner->ID); ?>">
                        <?php $image = get_field('info_photo', $owner->ID); if( $image ): ?>
                            <?php echo wp_get_attachment_image($image['ID'], 'large'); ?>
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

                    <div class="copy-2">
                        <?php the_field('biography_fun_facts', $owner->ID); ?>
                    </div>

                    <div class="cta">
                        <a href="<?php echo get_permalink($owner->ID); ?>" class="btn btn-white-green">More</a>
                    </div>
                
                </div>
            </div>
        <?php $count++; endforeach; ?>

    </section>
    
<?php endif; ?>