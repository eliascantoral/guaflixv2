<?php 
    $visible = object_visibility($post->ID);
    $ptype = get_post_type($post->ID);
?>            
<section class="entry-content">
    <div class="row">
        <div class="col-md-3">
            <div class="<?php echo $visible==true?'singleobject-image':'';?>" align="center">
            <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
                <?php echo $visible?'<a href="#" class="objectplay">':'';?><img src="<?php echo $url; ?>" width="200px"/><?php echo $visible?'</a>':'';?>
            </div>
            <?php if($ptype!="participante"){?>
                <hr>
                <div id="control-access">                    
                        <?php if($visible){?>
                        <input type="button" class="btn btn btn-warning btn-lg btn-block objectplay" id="play" value="Ver">
                        <?php }else{                    
                           $payoptions = get_objectpayoptions($post->ID);
                           for($i=0;$i<sizeof($payoptions);$i++){?>
                                <input type="button" class="btn btn btn-warning btn-lg btn-block" id="pay_<?php echo $payoptions[$i][0]?>" value="<?php echo $payoptions[$i][1]?> (<?php echo get_moneyformat($payoptions[$i][2]);?>)">
                           <?php }
                        }?>                        
                    
                </div>
            <?php }?>
        </div>
        <div class="col-md-9">
            <?php if ( is_singular() ) { echo '<h1 class="entry-title slidertitle">'; } else { echo '<h2 class="entry-title">'; } ?><?php the_title(); ?><?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?><?php the_content(); ?>
                 <?php $participant = get_field('participant',$post->ID);?>
                 <?php if($participant){?>
                    <hr>
                    <h4 class="slidertitle">Participantes</h4>
                    <ul class="list-group_">

                        <?php
                            for($i=0;$i<sizeof($participant);$i++){                        
                                $participant_info = get_participantdata($participant[$i]);
                                ?>
                        <li class="list-group-item_">
                                        <a href="<?php echo $participant_info[4];?>"><?php echo $participant_info[1];?></a> </li>
                                <?php
                            }
                        ?>                                
                    </ul>                        
                 <?php }?>                    
             <?php if($ptype!="participante"){?>               
                <hr>
                <div class="singe-object-category" align="right">
                    <span class="cat-links"><?php echo "Categorias: "; ?><?php the_category( ', ' ); ?></span>
                    <span class="tag-links"><?php the_tags(); ?></span>                     
                </div>    
             <?php }?>
        </div>
        
    </div>
    <?php if($ptype=="participante"){?>
       <hr>
                                    <?php 
						$args = array(
							'numberposts' => -1,
							'post_type' => 'objeto',
							'meta_query' => array(
								array(
									'key' => 'participant',
									'value' => $post->ID,									
									'compare' => 'LIKE'
								)
							)
						);

						// get results
						$the_query = new WP_Query( $args );

						// The Loop
						?>
						<?php if( $the_query->have_posts() ): ?>

                                                                      <div class="object-container">
										<?php
										while($the_query->have_posts()) : 
											$the_query->the_post();?>							
												<div class="slider_search_element">
													<?php get_object_box(get_the_ID());?>
												</div>
											<?php
										endwhile;
										?>	
                                                                      </div>
						<?php endif; ?>

						<?php wp_reset_query();  // Restore global post data stomped by the_post().		
                                    ?>       
    <?php }?>
    
    <br>
    <?php if($ptype!="participante"){?>
        <div id="tabs">
          <ul  class="nav nav-tabs">
            <?php if($ptype=='serie'){?><li role="presentation" class="nav-tab-item active" ><a href="#tabs-1">Temporada</a></li><?php }?>
            <li role="presentation" class="nav-tab-item <?php if($ptype!='serie'){?>active<?php }?>" ><a href="#tabs-3">Recomendaciones</a></li>
            <?php if ( is_user_logged_in() ) {?><li role="presentation" class="nav-tab-item" ><a href="#tabs-2">Administraci&oacute;n</a></li><?php  } ?> 

          </ul>
            <?php if($ptype=='serie'){?>
                <div  class="tab-content" id="tabs-1">
                    <?php include_once 'blocks/serieobjectlist.php';?>
                    <div class="clear"></div>
                </div>       
            <?php }?>    
            <?php if ( is_user_logged_in() ) {?>
                <div  class="tab-content" id="tabs-2">
                    <?php include_once 'blocks/objectadmin.php';?>
                    <div class="clear"></div>
                </div>  
            <?php  } ?>   
          <div  class="tab-content" id="tabs-3">
              <div class="object-container">
                  <?php get_recomendedbyobject($post->ID);?>
              </div>    
              <div class="clear"></div>
          </div>
        </div> 
<?php }?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
</section>

<?php 
    if($visible) include_once 'blocks/objectlogic.php';
?>