<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header>

<?php if ( !is_search() ) get_template_part( 'entry', 'meta' ); ?>
</header>
<?php get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
<?php if ( !is_search() ) get_template_part( 'entry-footer' ); ?>
</article>