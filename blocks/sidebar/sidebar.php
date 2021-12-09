<?php

/*
 * Sidebar Block
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'sidebar-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'esa-sidebar';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

    <?php
        $sidebar_template = array(
            array('core/heading', array(
                'level' => 4,
                'content' => 'Headline Goes Here',
            )),
            array( 'core/paragraph', array(
                'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor, ex...',
            ) )
        );
    ?>

    <InnerBlocks template="<?php echo esc_attr( wp_json_encode( $sidebar_template ) ); ?>" />

</div>