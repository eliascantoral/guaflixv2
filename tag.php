<?php get_header(); ?>
<?php
    // WP_Query arguments
    $args = array (
            'post_type'              => array( 'objeto','serie' ),
            'post_status'            => array( 'publish' ),
            'tag'                    => $tag
    );
    $wp_query = new WP_Query( $args );
?>
<section class="container" id="content" role="main">
    <header class="header">
        <h1 class="entry-title"><?php _e( 'Etiqueta: ', 'blankslate' ); ?><?php single_tag_title(); ?></h1>
    </header>
    <?php 
    if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                    $wp_query->the_post();?>
                <?php get_template_part( 'entry' ); ?>
                <?php
            }
    }
    ?>
</section>
<?php get_footer(); ?>