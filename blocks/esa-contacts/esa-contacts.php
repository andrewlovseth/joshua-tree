<?php

/*
 * ESA Contacts
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'esa-contacts-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'esa-contacts';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

$header = get_field('header');
if(have_rows('contacts')): ?>

    <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

        <h4 class="esa-contacts__header"><?php echo $header; ?></h4>

        <div class="esa-contacts__grid">
            <?php while(have_rows('contacts')) : the_row(); ?>

                <?php if( get_row_layout() == 'existing' ): ?>

                    <?php
                        $contact = get_sub_field('contact');
                        $permalink = get_permalink($contact->ID);
                        $name = get_the_title($contact->ID);

                        if('leadership' == get_post_type($contact->ID)) {
                            $image = get_field('info_headshot', $contact->ID);
                        } elseif('employee' == get_post_type($contact->ID)) {
                            $image = get_field('info_photo', $contact->ID);
                        }

                        $regions = get_the_terms($contact->ID, 'region');
                        if($regions) {
                            $region = '';
                            foreach($regions as $term) {
                                $region .= $term->name . ', ';
                            }
                            $region = rtrim($region, ', ');
                        }
                        

                        $contact_group = get_field('contact', $contact->ID);
                        $email = $contact_group['email'];

                        $social = get_field('social', $contact->ID);
                        $linkedin = $social['linkedin'];
                    ?>

                    <div class="esa-contacts__card profile">
                        <div class="photo">
                            <a href="<?php echo $permalink; ?>">
                                <?php if( $image ): ?>
                                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="info">
                            <div class="name">
                                <h3 class="esa-contacts__card-header">
                                    <a href="<?php echo $permalink; ?>"><?php echo $name; ?></a>

                                    <?php if($linkedin): ?>               
                                        <div class="link linkedin">
                                            <a href="<?php echo $linkedin; ?>" rel="external"><img src="<?php bloginfo('template_directory'); ?>/images/icon-linkedin.svg" alt="LinkedIn" /></a>
                                        </div>
                                    <?php endif; ?>
                                </h3>
                            </div>

                            <div class="esa-contacts__card-meta">
                                <?php if($regions): ?>
                                    <div class="region"><?php echo $region; ?></div>
                                <?php endif; ?>
                                
                                <?php if($email): ?>               
                                    <div class="link email">
                                        <a href="mailto:<?php echo $email; ?>">Email</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>               

                    </div>

                <?php endif; ?>

                <?php if( get_row_layout() == 'ad_hoc' ): ?>

                    <?php
                        $image = get_sub_field('photo');
                        $name = get_sub_field('name');
                        $region = get_sub_field('region');
                        $linkedin = get_sub_field('linkedin');
                        $email = get_sub_field('email');
                    ?>

                    <div class="esa-contacts__card profile">
                        <div class="photo">
                            <?php if( $image ): ?>
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                            <?php endif; ?>
                        </div>

                        <div class="info">
                            <div class="name">
                                <h3 class="esa-contacts__card-header">
                                    <?php echo $name; ?>

                                    <?php if($linkedin): ?>               
                                        <div class="link linkedin">
                                            <a href="<?php echo $linkedin; ?>" rel="external"><img src="<?php bloginfo('template_directory'); ?>/images/icon-linkedin.svg" alt="LinkedIn" /></a>
                                        </div>
                                    <?php endif; ?>
                                </h3>
                            </div>

                            <div class="esa-contacts__card-meta">
                                <?php if($region): ?>
                                    <div class="region"><?php echo $region; ?></div>
                                <?php endif; ?>
                                
                                <?php if($email): ?>               
                                    <div class="link email">
                                        <a href="mailto:<?php echo $email; ?>">Email</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>               

                    </div>

                <?php endif; ?>


            <?php endwhile; ?>
        </div>
    </div>

<?php endif; ?>
