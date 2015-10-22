<div class="clear"></div>
<?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) { ?>
<nav id="nav-below" class="navigation" role="navigation">
    <div class="row">
        <div class="col-md-6" align="center"><div class="nav-previous left-col"><?php next_posts_link(sprintf( __( '%s Anterior', 'blankslate' ), '<span class="meta-nav"><img src="'.get_template_directory_uri().'/images/back.png" width="40px"></span>' ) ) ?></div></div>
        <div class="col-md-6" align="center"><div class="nav-next right-col"><?php previous_posts_link(sprintf( __( 'Nuevo %s', 'blankslate' ), '<span class="meta-nav"><img src="'.get_template_directory_uri().'/images/next.png" width="40px"></span>' ) ) ?></div></div>
    </div>
</nav>
<?php } ?>