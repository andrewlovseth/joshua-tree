<?php
/**
 * Landing Sidebar Block
 *
 * Displays contacts, date, and share links — mirroring the
 * news single post sidebar layout for landing pages.
 */

$contacts = get_field('contacts');
?>

<div class="landing-sidebar">

    <?php if ( $contacts ) : ?>
        <div class="contacts module">
            <h4><?php echo count($contacts) > 1 ? 'Authors' : 'Author'; ?></h4>

            <?php foreach ( $contacts as $contact ) :
                $type     = $contact->post_type;
                $link     = get_permalink( $contact->ID );
                $name     = get_the_title( $contact->ID );
                $info     = get_field( 'info', $contact->ID );
                $position = $info['position'] ?? '';

                if ( $type === 'leadership' ) {
                    $photo = get_field( 'info_headshot', $contact->ID );
                } else {
                    $photo = get_field( 'info_photo', $contact->ID );
                }
            ?>
                <div class="contact">
                    <div class="photo">
                        <a href="<?php echo esc_url( $link ); ?>">
                            <?php if ( $photo ) : ?>
                                <?php echo wp_get_attachment_image( $photo['ID'], 'small' ); ?>
                            <?php else : ?>
                                <div class="placeholder"></div>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="info">
                        <p class="name"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $name ); ?></a></p>
                        <?php if ( $position ) : ?>
                            <p class="position"><?php echo esc_html( $position ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="date module">
        <h4>Date</h4>
        <p><?php echo get_the_date( 'F j, Y' ); ?></p>
    </div>

    <div class="social-share module">
        <h4>Share</h4>

        <div class="links">
            <div class="link linkedin">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink() ); ?>&title=<?php echo urlencode( get_the_title() ); ?>" rel="external" target="_blank">
                    <?php echo esa_svg( get_bloginfo('template_directory') . '/images/share-linkedin.svg' ); ?>
                </a>
            </div>
            
            <div class="link facebook">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" rel="external" target="_blank">
                    <?php echo esa_svg( get_bloginfo('template_directory') . '/images/share-facebook.svg' ); ?>
                </a>
            </div>
        </div>
    </div>

</div>
