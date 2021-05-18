<?php

    $benefits = get_field('benefits');
    $headline = $benefits['headline'];
    $tabs = $benefits['tabs'];


?>

<section class="benefits grid">

    <?php if($headline): ?>
        <div class="headline">
            <h2 class="section-headline"><?php echo $headline; ?></h2>
        </div>
    <?php endif; ?>

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
                    $headline = $tab['headline'];
                    $copy = $tab['copy'];
                    $photo = $tab['photo'];
                ?>
                <div class="tab<?php if($count == 1):?> active<?php endif; ?>" id="<?php echo sanitize_title_with_dashes($label); ?>">
                    <div class="tab-flex">
                        <div class="info">
                            <div class="headline">
                                <h4><?php echo $headline; ?></h4>
                            </div>

                            <div class="copy-2 extended">
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