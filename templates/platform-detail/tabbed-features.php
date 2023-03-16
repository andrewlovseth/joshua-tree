<?php

    if( get_row_layout() == 'tabbed_features' ):

    $anchor = get_sub_field('anchor');
    $section_header = get_sub_field('section_header');
    $headline = $section_header['headline'];
    $copy = $section_header['copy'];
    $tabs = get_sub_field('tabs');
?>
    
    <section class="tabbed-features platform-section grid"<?php if($anchor): ?> id="<?php echo $anchor; ?>"<?php endif; ?>>

        <div class="section-header">
            <?php if($headline): ?>
                <div class="headline">
                    <h2 class="section-headline small"><?php echo $headline; ?></h2>
                </div>
            <?php endif; ?>

            <?php if($copy): ?>
                <div class="copy-2 extended">
                    <?php echo $copy; ?>
                </div>
            <?php endif; ?>  
        </div>

        <?php if($tabs): ?>
            <div class="tab-links">
                <?php $count = 1;  foreach($tabs as $tab): ?>
                    <?php
                        $label = $tab['tab_label'];
                    ?>
                    <div class="link">
                        <a href="#<?php echo sanitize_title_with_dashes($label); ?>"<?php if($count == 1):?> class="active"<?php endif; ?>><?php echo $label; ?></a>
                    </div>
                <?php $count++; endforeach; ?>
            </div>

            <div class="tab-content">
                <?php $count = 1; foreach($tabs as $tab): ?>
                    <?php
                        $label = $tab['tab_label'];
                        $copy = $tab['copy'];
                        $photo = $tab['image'];
                    ?>
                    <div class="tab<?php if($count == 1):?> active<?php endif; ?>" id="<?php echo sanitize_title_with_dashes($label); ?>">
                        <div class="tab-flex">
                            <div class="info">
                                <div class="copy-3 extended">
                                    <?php echo $copy; ?>
                                </div>
                            </div>
                            
                            <?php if( $photo ): ?>
                                <div class="photo">
                                    <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $count++; endforeach; ?>
            </div>

        <?php endif; ?>
    </section>

<?php endif; ?>