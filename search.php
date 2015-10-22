<?php get_header(); ?>
<section class="container" id="content" role="main">
<?php if ( have_posts() ) : ?>
<header class="header">
<h1 class="entry-title"><?php printf( __( 'Resultados de la busqueda: %s', 'blankslate' ), get_search_query() ); ?></h1>
</header>
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php endwhile; ?>
<?php get_template_part( 'nav', 'below' ); ?>
<?php else : ?>
<article id="post-0" class="post no-results not-found">
<header class="header">
<h2 class="entry-title"><?php _e( 'Ningún resultado', 'blankslate' ); ?></h2>
</header>
<section class="entry-content">
<p><?php _e( 'Lo sentimos, no se encontró nada con esta busqueda. Por favor intente de nuevo.', 'blankslate' ); ?></p>
<?php  get_search_box(true, $s);?>
</section>
</article>
<?php endif; ?>
</section>
<?php get_footer(); ?>