<?php

    $fun_traditions = get_field('fun_traditions');
    $headline = $fun_traditions['headline'];
    $deck = $fun_traditions['deck'];
    $traditions = $fun_traditions['traditions']

?>

<section class="fun-traditions grid">

    <?php if($headline): ?>
        <div class="section-header">
            <h2 class="title-headline"><?php echo $headline; ?></h2>

            <div class="copy-2 deck">
                <?php echo $deck; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="three-col-grid">

    <?php foreach($traditions as $tradition): ?>
        <?php
            $headline = $tradition['headline'];
            $deck = $tradition['deck'];
            $photo = $tradition['photo'];
        ?>

            <div class="item tradition">
                <?php if( $photo ): ?>
                    <div class="photo">
                        <div class="content">
                            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="info">
                    <div class="headline">
                        <h4><?php echo $headline; ?></h4>
                    </div>

                    <div class="copy-3">
                        <?php echo $deck; ?>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    </div>


    

    
</section>