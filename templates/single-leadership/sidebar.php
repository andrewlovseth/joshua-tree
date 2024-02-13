<?php
    $info = get_field('info');
    $position = $info['position'];
    $education = $info['education'];
    $date_string = $info['start_date'];
    $date = DateTime::createFromFormat('Ymd', $date_string);

    $terms = get_the_terms($post->ID, 'region');


    $contact = get_field('contact');
    $email = $contact['email'];
    $phone = $contact['phone'];

    $social = get_field('social');
    $linkedin = $social['linkedin'];
?>

<div class="sidebar copy-2">
    <?php if($position): ?>
        <div class="vital position">
            <h4>Current Role</h4>
            <p><?php echo $position; ?></p>
        </div>
    <?php endif; ?>

    <?php if($terms): ?>
        <?php
            if($terms) {
                $region = '';
                foreach($terms as $term) {
                    $region .= $term->name . ', ';
                }
                $region = rtrim($region, ', ');
            }
        ?>

        <div class="vital region">
            <h4>Region</h4>
            <p><?php echo $region; ?></p>
        </div>
    <?php endif; ?>      

    <?php if($education): ?>
        <div class="vital education">
            <h4>Education</h4>
            <p><?php echo $education; ?></p>
        </div>
    <?php endif; ?>

    <?php if($date_string): ?>
        <div class="vital tenure">
            <h4>Employee-Owner Since</h4>
            <p><?php echo $date->format('Y'); ?></p>
        </div>
    <?php endif; ?>

    <?php if($email || $linkedin): ?>
        <div class="vital contact">
            <h4>Contact</h4>

            <div class="links">
                <?php if($email): ?>               
                    <div class="link email">
                        <a class="small-btn" href="mailto:<?php echo $email; ?>">Email</a>
                    </div>
                <?php endif; ?>


                <?php if($linkedin): ?>               
                    <div class="link linkedin">
                        <a href="<?php echo $linkedin; ?>" rel="external"><img src="<?php bloginfo('template_directory'); ?>/images/icon-linkedin.svg" alt="LinkedIn" /></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>