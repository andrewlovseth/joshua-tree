<?php

    $authors = get_field('authors');
    if($authors) {
        if(count($authors) > 1) {
            $author_header = "Authors";
        } else {
            $author_header = "Author";
        }
    }


    if($authors):

?>

    <div class="authors module">
        <h4><?php echo $author_header; ?></h4>

        <?php foreach($authors as $author): ?>
            <?php 
                $link = get_permalink($author->ID);
                $name = get_the_title($author->ID);
                $photo = get_field('info_photo', $author->ID);
            ?>
            
            <div class="author">
                    <div class="photo">
                        <div class="content">
                            <a href="<?php echo $link; ?>">
                                <?php if($photo): ?>
                                    <?php echo wp_get_attachment_image($photo['ID'], 'small'); ?>
                                <?php else: ?>
                                    <div class="placeholder"></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>

                <div class="info">
                    <p><a href="<?php echo $link; ?>"><?php echo $name; ?></a></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>