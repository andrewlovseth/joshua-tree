<?php

    global $post;
    $id = $post->ID;


    $leadership = get_page_by_path('about/leadership');
    $sub_nav = get_field('sub_nav', $leadership);

    if( $sub_nav ): 
?>

<nav class="leadership-sub-nav grid">
    <ul>
        <?php foreach( $sub_nav as $p ): ?>
            <?php 
                $link = get_permalink( $p->ID );
                $title =  get_field('leaders_header', $p->ID );
            ?>

            <li>
                <a <?php if($id == $p->ID): ?>class="active"<?php endif; ?> href="<?php echo $link  ?>"><?php echo $title; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php endif; ?>