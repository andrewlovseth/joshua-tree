<?php

    $testimonial = get_field('testimonial');
    $quote = $testimonial['quote'];
    $name = $testimonial['name'];
    $position = $testimonial['position'];
    $group = $testimonial['group'];

    if($quote):

?>

    <section class="testimonial grid">
        <div class="icon">
            <img src="<?php bloginfo('template_directory'); ?>/images/icon-testimonial.svg" alt="Testimonials icon" />
        </div>

        <div class="info">
            <blockquote class="copy copy-2">
                <p><?php echo $quote; ?></p>
            </blockquote>

            <div class="meta copy copy-2">
                <div class="person">
                    <h4><?php if( $name ) { echo $name;  } ?><?php if( $position ) { echo ', ' . $position;  } ?></h4>
                </div>

                <?php if( $group ): ?>
                    <div class="group">
                        <p><?php echo $group; ?></p>
                    </div>
                <?php endif; ?>  
            </div>
        </div>
    </section>

<?php endif; ?>  