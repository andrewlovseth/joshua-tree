<?php

    $case_studies = get_field('case_studies');
    if( !$case_studies ) return;

    $eyebrow = $case_studies['eyebrow'];
    $headline = $case_studies['headline'];
    $copy = $case_studies['copy'];
    $studies = $case_studies['studies'];

    if( !$studies ) return;

    $single = count($studies) === 1;
    $first_title = $studies[0]['title'] ?? '';

?>

<section class="et-case-studies grid">

    <?php if( $eyebrow || $headline || $copy ): ?>
        <div class="section-header">
            <?php if( $eyebrow ): ?>
                <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if( $headline ): ?>
                <h2 class="section-headline"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>
            <?php if( $copy ): ?>
                <div class="section-copy copy-2 extended">
                    <?php echo $copy; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="et-case-studies-header<?php echo $single ? ' single-slide' : ''; ?>">
        <div class="et-case-studies-header-inner">
            <div class="et-case-studies-header-title">
                <h3 class="et-case-studies-slide-title"><?php echo $first_title; ?></h3>
            </div>
            <div class="et-case-studies-header-meta">                
                <div class="et-case-studies-header-counter">
                    <span class="counter-eyebrow">Case</br>Study</span>
                    <span class="counter-number">1</span>
                </div>

                <div class="et-case-studies-header-nav"></div>
            </div>
        </div>
    </div>

    <div class="case-study-slider<?php echo $single ? ' single-slide' : ''; ?>">
        <?php foreach( $studies as $study ):
            $title = $study['title'] ?? '';
            $problem = $study['problem'] ?? '';
            $outcome = $study['outcome'] ?? '';
            $gallery = $study['gallery'] ?? [];
            $kpis = $study['kpis'] ?? [];
            $bg_id = $study['background_image'] ?? 0;
            $slide_bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';
        ?>
            <div class="case-study-slide" data-title="<?php echo esc_attr($title); ?>">
                <div class="case-study-slide-outer">

                    <?php if( $slide_bg_url ): ?>
                        <div class="case-study-slide-bg">
                            <img class="case-study-slide-bg__image" src="<?php echo esc_url($slide_bg_url); ?>" alt="" aria-hidden="true" loading="lazy">
                            <div class="case-study-slide-bg__spacer"></div>
                        </div>
                    <?php endif; ?>

                    <div class="case-study-slide-inner">

                        <div class="case-study-card">
                            <?php if( $problem ): ?>
                                <div class="case-study-block">
                                    <p class="eyebrow">The Problem</p>
                                    <div class="case-study-copy"><?php echo $problem; ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if( $outcome ): ?>
                                <div class="case-study-block">
                                    <p class="eyebrow">Outcome</p>
                                    <div class="case-study-copy"><?php echo $outcome; ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if( $kpis ): ?>
                                <div class="case-study-kpis">
                                    <?php foreach( $kpis as $kpi ):
                                        $stat = $kpi['stat'] ?? '';
                                        $stat_len = mb_strlen( trim( $stat ) );
                                        $stat_size = $stat_len >= 15 ? 'sm' : ( $stat_len >= 9 ? 'md' : 'lg' );
                                    ?>
                                        <div class="kpi">
                                            <span class="kpi-stat kpi-stat--<?php echo $stat_size; ?>"><?php echo esc_html($stat); ?></span>
                                            <span class="kpi-label"><?php echo esc_html($kpi['label']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if( !empty($gallery) ): ?>
                            <div class="case-study-gallery">
                                <?php foreach( array_slice($gallery, 0, 2) as $img ): ?>
                                    <figure class="case-study-gallery-image">
                                        <?php echo wp_get_attachment_image($img['ID'], 'large'); ?>
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>
