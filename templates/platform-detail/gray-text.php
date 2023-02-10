<?php

    if( get_row_layout() == 'gray_text' ):

    $headline = get_sub_field('headline');
    $copy = get_sub_field('copy');

?>
    
    <section class="gray-text platform-section grid">
        <?php if($headline): ?>
            <div class="section-header">
                <h2 class="section-headline small"><?php echo $headline; ?></h2>
            </div>
        <?php endif; ?>

        <?php if($copy): ?>
            <div class="copy-2 extended">
                <?php echo $copy; ?>
            </div>
        <?php endif; ?>       
    </section>

<?php endif; ?>