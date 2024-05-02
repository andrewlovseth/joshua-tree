<?php

    $links = get_field('sub_nav');
    if( $links ):

?>

    <div class="market-sub-nav grid">

        <ul>
            <?php foreach( $links as $l ): ?>
                <li>
                    <a href="<?php echo get_permalink( $l->ID ); ?>"><?php echo get_the_title( $l->ID ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

<?php endif; ?>