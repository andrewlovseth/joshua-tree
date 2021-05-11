<?php 

    $news = get_field('news');
    $headline = $news['headline'];
    $posts = $news['posts'];

    if ($posts):
?>

    <section class="news grid">
        <div class="section-header">
            <h2><?php echo $headline; ?></h2>
        </div>

        <div class="posts">
            <?php foreach( $posts as $p ): ?>

                <article class="post-teaser">
                    <div class="photo">
                        <a href="<?php echo get_permalink($p->ID); ?>">
                            <div class="content">
                                <?php echo get_the_post_thumbnail($p->ID, 'large'); ?>
                            </div>
                        </a>
                    </div>

                    <div class="info">
                        <div class="headline">
                            <h3 class="title-headline"><a href="<?php the_permalink();?>"><?php echo get_the_title($p->ID); ?></a></h3>
                        </div>

                        <div class="dek copy p1">
                            <?php echo get_the_excerpt($p->ID); ?>
                        </div>

                        <div class="cta">
                            <a href="<?php echo get_permalink($p->ID); ?>" class="btn btn-green">Read More</a>
                        </div>
                    </div>
                </article>

            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>