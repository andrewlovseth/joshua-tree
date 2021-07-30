<?php 

$experts = get_field('experts');

if($experts): ?>
    <section class="experts">
        <div class="section-header">
            <h3 class="section-headline small">Experts</h3>
        </div>

        <?php foreach($experts as $expert): ?>
            <div class="profile">
                <div class="photo">
                    <div class="content">
                        <a href="<?php echo get_permalink($expert->ID); ?>">
                            <?php $image = get_field('info_photo', $expert->ID); if( $image ): ?>
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                            <?php endif; ?>
                        </a>
                    </div>                    
                </div>

                <div class="info">
                    <div class="name">
                        <h3><?php echo get_the_title($expert->ID); ?></h3>
                    </div>
                    
                    <div class="meet vital">
                        <p>Meet <a href="<?php echo get_permalink($expert->ID); ?>"><?php the_field('info_first_name', $expert->ID); ?></a></p>
                    </div>

                    <?php if(get_field('info_office', $expert->ID)): ?>
                        <div class="office vital">
                            <p>Office: <a href="<?php $office = get_field('info_office', $expert->ID); echo get_permalink($office->ID); ?>"><?php echo get_the_title($office->ID); ?></a></p>
                        </div>
                    <?php endif; ?>

                    <div class="contact vital">
                        <?php if(get_field('contact_phone', $expert->ID)): ?>
                            <div class="phone">
                                <p><a href="tel:<?php the_field('contact_phone', $expert->ID); ?>"><?php the_field('contact_phone', $expert->ID); ?></a></p>
                            </div>
                        <?php endif; ?>

                        <?php if(get_field('contact_email', $expert->ID)): ?>
                            <div class="email">
                                <p><a href="mailto:<?php the_field('contact_email', $expert->ID); ?>">Email</a></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </section>
<?php endif; ?>