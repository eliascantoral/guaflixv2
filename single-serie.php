<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php get_header(); ?>


<div class="container">
    <section id="content" role="main">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'entry' ); ?>
            <?php endwhile; endif; ?>
        <footer class="footer">
        </footer>
    </section>  
    
</div>
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  
  $(".nav-tab-item").click(function(event){
     $(".nav-tab-item").removeClass('active');
     $(this).addClass('active');
  });
  </script>
<?php get_footer(); ?>
