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
                $type = $author->post_type;
                $link = get_permalink($author->ID);
                $name = get_the_title($author->ID);
                $info = get_field('info', $author->ID);
                $position = $info['position'] ?? '';

                if($type === "leadership") {
                    $photo = get_field('info_headshot', $author->ID);
                } else {
                    $photo = get_field('info_photo', $author->ID);
                }

            ?>
            
            <div class="author">
                    <div class="photo">
                        <a href="<?php echo $link; ?>">
                            <?php if($photo): ?>
                                <?php echo wp_get_attachment_image($photo['ID'], 'small'); ?>
                            <?php else: ?>
                                <div class="placeholder"></div>
                            <?php endif; ?>
                        </a>
                    </div>

                <div class="info">
                    <p class="name"><a href="<?php echo $link; ?>"><?php echo $name; ?></a></p>
                    <?php if($position): ?>
                        <p class="position"><?php echo $position; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>