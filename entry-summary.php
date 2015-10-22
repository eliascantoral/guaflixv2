<?php $postid = get_the_ID();?>
<?php if(get_post_type($postid) == 'objeto' || get_post_type($postid) == 'serie' || get_post_type($postid) == 'participante'){?>
    <section class="entry-summary"> 
        <div class="object-container">
            <?php get_object_box($postid);?>
        </div>    

    <?php if( is_search() ) { ?><div class="entry-links"><?php wp_link_pages(); ?></div><?php }?>
    </section>
<?php }?>