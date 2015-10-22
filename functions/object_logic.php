<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of object_logic
 *
 * @author Augusto
 */



function get_object_box($object){
    $thepost = get_post($object);
    //var_dump($thepost);
    $url = wp_get_attachment_url( get_post_thumbnail_id($thepost->ID) );
    
    ?>
<div class="ih-item square effect6 from_top_and_bottom"><a href="<?php echo get_permalink($thepost->ID);?>">
        <div class="img"><img src="<?php echo $url; ?>" alt="img"></div>
        <div class="info">
          <h3><?php echo $thepost->post_title;?></h3>
          <p><?php echo the_excerpt_max_charlength($thepost->ID, 50);?></p>
        </div></a>
</div>        
        <?php 
}
function get_slider($slider){
    $thepost = get_post($slider['slider'][0]); 
    $options = get_field('opciones',$thepost->ID);
    $category = get_field('categoria',$thepost->ID); 
    //print_array($thepost);
    echo "<h3 class='slidertitle'>".$thepost->post_title."</h3>";  
    $objectlist = get_object_list($options, $category);
   
    ?>
<div class="owl-carousel-wrapper">       
        <div class="owl-carousel" id="owl-carousel_<?php echo $thepost->ID;?>">
          <?php 
            for($i=0;$i<sizeof($objectlist);$i++){
                echo '<div>';
                get_object_box($objectlist[$i]);
                echo '</div>';
            }
          ?>
        </div> 
    <?php if(sizeof($objectlist)>5){?>
        <div class="owl-carousel-control1 row">
            <div class="owl-carousel-control col-xs-2" align="center"><a href="#" class="owl-carousel-control-back" rel="owl-carousel_<?php echo $thepost->ID;?>"><img src="<?php echo get_template_directory_uri(); ?>/images/back.png"></a></div>
            <div class="col-xs-8"></div>
            <div class="owl-carousel-control col-xs-2" align="center"><a href="#" class="owl-carousel-control-next" rel="owl-carousel_<?php echo $thepost->ID;?>"><img src="<?php echo get_template_directory_uri(); ?>/images/next.png"></a></div>   
        </div>
    <?php }?>
</div>
    <?php
}

function get_object_list($option, $category){
    // WP_Query arguments
        $object_list = array();
            $args = array (
                    'post_type'              => array( 'objeto', 'serie' ),
                    'post_status'            => array( 'publish' ),  
            );   
    
        if($category){
            $thecat = "";
            for($i=0;$i<sizeof($category);$i++){
                $thecat.=$category[$i].",";
            }
            $args['cat'] =$thecat;
        }
        if(array_contain('new', $option)){
            $args['order'] = 'DESC';
            $args['orderby'] = 'date';
        }else{
            $args['order'] = 'ASC';
            $args['orderby'] = 'rand';            
        }
        
        if(array_contain('userfriendlike', $option)){
           // $args['order'] = 'DESC';
            
                   
        }        
        if(array_contain('userlike', $option)){
            //$args['order'] = 'DESC';                   
        }        
        
        
        
        
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        array_push($object_list, get_the_ID());
                }
        } else {
                // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();
        return $object_list;
}



function object_visibility($objectid){
    $visbility = get_field('view_method',$objectid);
    $userid = is_login();
    if($visbility=='free') return true;
        if($userid===FALSE) return false;

        $membresia = get_field('membresia',$objectid);
        $renta = get_field('renta',$objectid);
        $compra = get_field('compra',$objectid);
        if($renta=='' || $compra=='' || $renta==0 || $compra==0) return true;
        
        if(($membresia=='' || $membresia==0 )&& check_membership($userid)) return true;
        
        if(check_userbuy($userid, $objectid)) return true;
        
        return false; 
}

function get_objectpayoptions($objectid){
    $visbility = get_field('view_method',$objectid);
    if($visbility=='free') return array(array(1,"Gratis","0.00"));
        $membresia = get_field('membresia',$objectid);
        $renta = get_field('renta',$objectid);
        $compra = get_field('compra',$objectid);
        
        return array(array(2,"Membresia",$membresia),array(3,"Renta",$renta),array(4,"Compra",$compra));
}


function get_recomendedbyobject($objectid, $elements = 5){
    $tags = wp_get_post_terms($objectid,'category');
    if ($tags) {
        $first_tag = $tags[0]->term_id;       
        $args=array(
            'post_type'              => array( 'objeto','serie' ),
            'category__in' => array($first_tag),
            'post__not_in' => array($objectid),
            'posts_per_page'=>$elements,
            'caller_get_posts'=>1
        );
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
            while ($my_query->have_posts()) : $my_query->the_post(); 
                get_object_box(get_the_ID());                
            ?>
                    
            <?php
            endwhile;
        }
        wp_reset_query();
    }
}

function get_objectuser($object){
    include_once 'backend/backend.php';
    $backend = new backend();
    return $backend->get_objectuser($object);
}