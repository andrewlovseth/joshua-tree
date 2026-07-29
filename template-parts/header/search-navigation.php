<?php
/*
    Inline search form — rendered by 404.php only. The header search overlay
    this part used to power is retired; site-wide search is the omnibox
    (template-parts/header/omnibox.php). Styles: scss/header/_search-nav.scss
    plus the 404 overrides in scss/templates/_404.scss.
*/
?>
<nav class="search-nav grid">
    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
        <label>
            <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
            <input type="search" class="search-field"
                placeholder="<?php echo esc_attr_x( 'Search our site', 'placeholder' ) ?>"
                value="<?php echo get_search_query() ?>" name="s"
                title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
        </label>
        <input type="submit" class="search-submit"
            value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
    </form>
</nav>