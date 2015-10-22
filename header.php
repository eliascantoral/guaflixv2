<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?php wp_title( ' | ', true, 'right' ); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
        <?php wp_head(); ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.vertical-tabs.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style/ihover.css">

        <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/jqueryui/jquery-ui.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/owlcarousel/assets/owl.carousel.css">
        <script src="<?php echo get_template_directory_uri(); ?>/js/owlcarousel/owl.carousel.min.js"></script>
        

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/images/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/images/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/images/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/images/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        
        
    </head>
    <body <?php body_class(); ?>>
        <div id="headerbg" class="container-fluid">
            <div class="container">
                <header id="header" role="banner">
                        <nav class="navbar navbar-inverse">
                            <div class="container-fluid">
                                  <!-- Brand and toggle get grouped for better mobile display -->
                                  <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                          <span class="sr-only">Toggle navigation</span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="<?php echo get_home_url(); ?>">
                                        <?php $thelogo = get_option( 'logo' );
                                            if($thelogo){
                                                echo '<img alt="Brand" src="'.$thelogo.'" height="100%">';
                                            }else{
                                                echo '<img alt="Brand" src="'.get_template_directory_uri().'/images/logomin.png" height="100%">';
                                            }
                                        ?>
                                        </a>
                                  </div>

                                  
                                 
                                  <!-- Collect the nav links, forms, and other content for toggling -->
                                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <?php 

                        $args = array(
                        'type'                     => 'post',
                        'child_of'                 => 0,
                        'parent'                   => '0',
                        'orderby'                  => 'name',
                        'order'                    => 'ASC',
                        'hide_empty'               => 0,
                        'hierarchical'             => 1,
                        'exclude'                  => '',
                        'include'                  => '',
                        'number'                   => '',
                        'taxonomy'                 => 'category',
                        'pad_counts'               => false 
                        );
                        $category = get_categories( $args );                     
                    ?>








 <ul class="nav navbar-nav">
    <li class="dropdown">
            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html"> Categorias <span class="caret"></span></a>
    		<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
<?php 
                        for($i=0;$i<sizeof($category);$i++){
                            $args_sub = array(
                            'type'                     => 'post',
                            'child_of'                 => 0,
                            'parent'                   => $category[$i]->term_id ,
                            'orderby'                  => 'name',
                            'order'                    => 'ASC',
                            'hide_empty'               => 0,
                            'hierarchical'             => 1,
                            'exclude'                  => '',
                            'include'                  => '',
                            'number'                   => '',
                            'taxonomy'                 => 'category',
                            'pad_counts'               => false 
                            );
                            $category_sub = get_categories( $args_sub );
                                echo '<li ';
                                echo sizeof($category_sub)>0?'class="dropdown-submenu"':'';
                                echo '>';
                                echo '<a href="';
                                echo get_category_link( $category[$i]->term_id );
                                echo '">';
                                echo $category[$i]->name.'</a>';
                                if(sizeof($category_sub)>0){
                                    echo '<ul class="dropdown-menu">';
                                    for($e=0;$e<sizeof($category_sub);$e++){
                                        echo '<li>';
                                        echo '<a href="';
                                        echo get_category_link( $category_sub[$e]->term_id );
                                        echo '">';
                                        echo $category_sub[$e]->name.'</a>';
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                                echo '</li>';

                            }
?>
            </ul>
    </li>
 </ul>                                      
                                      
                                      <?php get_search_box(false, $s);?>
                                    <ul class="nav navbar-nav navbar-right">	
                                          <?php if(!false){?>
                                                          <li><a href="<?php echo get_variable("login");?>">Ingresar</a></li>
                                                          <li class="dropdown"> <a href="<?php echo get_variable("register");?>">Registrarme</a></li>			
                                          <?php }else{?>
                                                          <li><a href="<?php echo get_variable("profile");?>">Mi Perfil</a></li>						
                                                          <li class="dropdown"> <a href="#" id="logout_link">Salir</a></li>							
                                          <?php }?>
                                    </ul>
                                  </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                        </nav>  
                </header>                  
            </div>       
        </div>
        <div id="container">
