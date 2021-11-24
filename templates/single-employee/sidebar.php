<?php

    $info = get_field('info');
    $position = $info['position'];
    $terms = get_the_terms($post->ID, 'region');

    if($terms) {
        $region = '';
        foreach($terms as $term) {
            $region .= $term->name . ', ';
        }
        $region = rtrim($region, ', ');
    }

    $date_string = $info['start_date'];
    $date = DateTime::createFromFormat('Ymd', $date_string);

    $contact = get_field('contact');
    $email = $contact['email'];
    $phone = $contact['phone'];

    $social = get_field('social');
    $linkedin = $social['linkedin'];

    if(have_rows('info')): while(have_rows('info')): the_row(); ?>

    <div class="sidebar copy-2">
        <?php if($position): ?>
            <div class="vital position">
                <h4>Current Role</h4>
                <p>
                    <span class="title"><?php echo $position; ?></span>
                    <?php if($region): ?><span class="region"><?php echo $region; ?></span><?php endif; ?>
                </p>
            </div>
        <?php endif; ?>        

        <?php if(have_rows('education')): ?>
            <div class="vital education">
                <h4>Education</h4>
                <?php while(have_rows('education')): the_row(); ?>
                    <?php
                        $degree = get_sub_field('degree');
                        $field = get_sub_field('study_field');
                        $institution = get_sub_field('institution');
                    ?>

                    <div class="education-item">
                        <p>
                            <?php if($degree): ?>
                                <span class="degree"><?php echo $degree; ?></span>
                            <?php endif; ?>

                            <?php if($field): ?>
                                <span class="field"><?php echo $field; ?></span>
                            <?php endif; ?>

                            <?php if($institution): ?>
                                <span class="institution"><?php echo $institution; ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                <?php endwhile; ?>                
            </div>
        <?php endif; ?>

        <?php if($date_string): ?>
            <div class="vital tenure">
                <h4>Employee-Owner Since</h4>
                <p><?php echo $date->format('Y'); ?></p>
            </div>
        <?php endif; ?>

        <?php if($linkedin): ?>
            <div class="vital social">
                <div class="social-links">
                    <div class="link linkedin">
                        <a href="<?php echo $linkedin; ?>" rel="external"><img src="<?php bloginfo('template_directory'); ?>/images/icon-linkedin.svg" alt="LinkedIn" /></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php endwhile; endif; ?>