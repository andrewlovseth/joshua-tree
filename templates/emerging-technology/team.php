<?php

    $team = get_field('team');
    if( !$team ) return;

    $eyebrow = $team['eyebrow'];
    $headline = $team['headline'];
    $members = $team['members'];

?>

<section class="et-team grid">

    <?php if( $eyebrow || $headline ): ?>
        <div class="section-header">
            <?php if( $eyebrow ): ?>
                <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if( $headline ): ?>
                <h2 class="section-headline"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if( $members ): ?>
        <div class="et-team-grid four-col-grid">
            <?php foreach( $members as $member ):
                $person_id = $member['person'];
                if( !$person_id ) continue;

                $post_type = get_post_type($person_id);
                $photo_field = ($post_type === 'leadership') ? 'info_headshot' : 'info_photo';
                $photo = get_field($photo_field, $person_id);

                $name = get_the_title($person_id);
                $permalink = get_permalink($person_id);

                $role = !empty($member['role_override'])
                    ? $member['role_override']
                    : get_field('info_title', $person_id);
            ?>
                <article class="et-team-member">
                    <a class="et-team-photo" href="<?php echo esc_url($permalink); ?>">
                        <?php if( $photo ): ?>
                            <?php echo wp_get_attachment_image($photo['ID'], 'medium'); ?>
                        <?php endif; ?>
                    </a>
                    <h3 class="et-team-name">
                        <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($name); ?></a>
                    </h3>
                    <?php if( $role ): ?>
                        <p class="et-team-role"><?php echo esc_html($role); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>
