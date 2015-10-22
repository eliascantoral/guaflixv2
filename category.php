<?php get_header(); ?>
<?php
    // WP_Query arguments
    $args = array (
            'post_type'              => array( 'objeto','serie' ),
            'post_status'            => array( 'publish' ),
            'cat'                    => $cat
    );
    $wp_query = new WP_Query( $args );
?>

<section class="container" id="content" role="main">
<header class="header">
<h1 class="entry-title"><?php _e( 'Categoría: ', 'blankslate' ); ?><?php single_cat_title(); ?></h1>
<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
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
<?php wp_reset_postdata();?>
<?php get_footer(); ?>