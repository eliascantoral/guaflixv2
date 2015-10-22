<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $group = get_field('grupo',$post->ID);
?>
      <div  class="col-sm-12">
        <div class="col-xs-3"> <!-- required for floating -->
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tabs-left">
              <?php for($i=0;$i<sizeof($group);$i++){?>
              <li class="<?php if($i==0){echo 'active';}?>"><a href="#tab_<?php echo $i?>" data-toggle="tab"><?php echo $group[$i]['titulo'];?></a></li>
               <?php }?>
          </ul>
        </div>

        <div class="col-xs-9">
          <!-- Tab panes -->
          <div class="tab-content">
              <?php for($i=0;$i<sizeof($group);$i++){?>
                    <div class="tab-pane <?php if($i==0){echo 'active';}?>" id="tab_<?php echo $i?>">
                        <?php for($e=0;$e<sizeof($group[$i]['capitulo']);$e++){
                                $capitulo_id = $group[$i]['capitulo'][$e];
                                $url = get_template_directory_uri()."/images/";
                                switch(get_post_type( $capitulo_id )){
                                    case 'examen':{$url.='test.png';break;}
                                    default:{$url.='playcap.png';}
                                }
                               // $url = wp_get_attachment_url( get_post_thumbnail_id($capitulo_id) );?>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object" src="<?php echo $url;?>" alt="Capitulo <?php echo $e+1;?>" width="30px">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"> <?php echo get_the_title( $capitulo_id ); ?> </h4>
                                        <?php echo the_excerpt_max_charlength($capitulo_id, 50);?>
                                    </div>
                                </div>
                        <hr>
                            <?php }?>
                    </div>
               <?php }?>                          
          </div>
        </div>

        <div class="clearfix"></div>

      </div>
