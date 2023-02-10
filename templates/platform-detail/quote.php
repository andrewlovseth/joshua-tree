<?php

    if( get_row_layout() == 'quote' ):

    $text = get_sub_field('quote_text');
    $source = get_sub_field('source');
?>
    
    <section class="quote platform-section grid">
        <div class="quote__icon">
            <div class="quote__icon-wrapper">
                <?php get_template_part('svg/quote-bubble'); ?>
            </div>
        </div>

        <div class="quote__info">
            <?php if($text): ?>
                <blockquote class="quote__text">
                    <?php echo $text; ?>
                </blockquote>
            <?php endif; ?>

            <?php if($source): ?>
                <div class="copy-2 quote__source">
                    <p><?php echo $source; ?></p>
                </div>
            <?php endif; ?>   
        </div>
    </section>

<?php endif; ?>