<section class="testimonial">
    <div class="testimonial__slider">

        <?php if(have_rows('testimonials')): while(have_rows('testimonials')) : the_row(); ?>

            <?php if( get_row_layout() == 'testimonial' ): ?>

                <?php
                    $photo = get_sub_field('photo');
                    $quote = get_sub_field('quote');;
                    $source = get_sub_field('source');;
                ?>

                <div class="testimonial__slide">
                    <div class="testimonial__slide-wrapper">
                        <?php if($photo): ?>
                            <div class="testimonial__photo">
                                <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="testimonial__quote">
                            <div class="testimonial__quote-wrapper">
                                <div class="testimonial__text">
                                    <?php echo $quote; ?>
                                </div>

                                <div class="testimonial__source">
                                    <span><?php echo $source; ?></span>
                                </div>       
                            </div>     
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        <?php endwhile; endif; ?>    


    </div>
</section>