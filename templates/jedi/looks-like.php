<?php

    $headline = get_field('looks_like_headline');

?>

<section class="looks-like grid">
    <div class="section-header">
        <h3 class="title-headline small"><?php echo $headline; ?></h3>
    </div>

    <?php if(have_rows('looks_like_tabs')): ?>
        <div class="jedi-tabs">        
            <?php $i = 1; while(have_rows('looks_like_tabs')) : the_row(); ?>

                <?php if( get_row_layout() == 'tab' ): ?>
                    <?php 
                        $title = get_sub_field('title'); 
                        $slug = sanitize_title_with_dashes($title);
                    ?>

                    <div class="jedi-tabs__item">
                        <a class="jedi-tabs__link<?php if($i ==1): ?> active<?php endif; ?>" href="#<?php echo $slug; ?>"><?php echo $title; ?></a>                   
                    </div>
                <?php endif; ?>

            <?php $i++; endwhile; ?>
        </div>
    <?php endif; ?>

    <?php if(have_rows('looks_like_tabs')): ?>
        <div class="jedi-tab-sections">        
            <?php $i = 1; while(have_rows('looks_like_tabs')) : the_row(); ?>

                <?php if( get_row_layout() == 'tab' ): ?>
                    <?php 
                        $title = get_sub_field('title'); 
                        $slug = sanitize_title_with_dashes($title);
                        $copy = get_sub_field('copy'); 
                        $photo = get_sub_field('photo'); 

                        $classList = 'jedi-tab-sections__item';

                        if($photo) {
                            $classList .= ' has-photo';
                        }

                        if($i == 1) {
                            $classList .= ' active';
                        }
                    ?>

                    <div class="<?php echo $classList; ?>" id="<?php echo $slug; ?>">
                        <?php if($photo): ?>
                            <div class="photo">
                                <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="copy copy-2 extended">
                            <?php echo $copy; ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php $i++; endwhile; ?>
        </div>
    <?php endif; ?>

</section>