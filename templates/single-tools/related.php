<?php

    /**
     * "Appears on these service pages" — reverse cross-links.
     * Reads the tool's related_services relationship. Reuses the .more-projects
     * shell + .section-header + .section-headline.small, with a vital-link list.
     */

    $related = get_field('related_services');
    if( ! $related ) {
        return;
    }

?>

<section class="more-projects related-services grid">
    <div class="section-header">
        <h3 class="section-headline small">Appears on these service pages</h3>
    </div>

    <div class="related-services__list copy copy-2">
        <ul>
            <?php foreach( $related as $service ): ?>
                <li><a href="<?php echo get_permalink($service->ID); ?>"><?php echo get_the_title($service->ID); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
