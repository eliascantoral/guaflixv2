<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
Template Name: Home page
*/
?>

<?php get_header(); ?>
    <?php 
    $header_slider = get_field('header_slider');
    if( $header_slider ): ?>	
        <div id="carousel-example-generic" class="carousel slide hidden-xs" data-ride="carousel">
                <div class="carousel-inner" role="listbox" align="center">
                    <?php foreach( $header_slider as $post): ?>
                            <?php setup_postdata($post); $i=0;?>													
                            <?php while(the_repeater_field('imagenes',get_the_ID())): ?>											
                                    <?php $url = get_sub_field('url');?>
                                     <div class="item <?php echo $i==0?'active':'';?>">
                                            <?php if($url[0]!=""){?><a href="<?php echo get_permalink($url[0]); ?>"><?php }?>
                                                <img src="<?php the_sub_field('imagen'); ?>" alt="banner imagen"/>
                                            <?php if($url[0]!=""){?></a><?php }?>													
                                     </div>											
                            <?php $i++; endwhile; ?>											
                    <?php endforeach; ?>									
                    <?php wp_reset_postdata();?>

                </div>
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
        </div>
    <?php endif; ?>
<div class="container">
    <?php 
        $header_slider = get_field('body_slider');
	for($i=0;$i<sizeof($header_slider);$i++){
		get_slider($header_slider[$i]);
	}        
    ?>    
</div>


<?php get_footer(); ?>