<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup()
{
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
);
}
add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts()
{
wp_enqueue_script( 'jquery' );
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script()
{
if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return '&rarr;';
} else {
return $title;
}
}
add_filter( 'wp_title', 'blankslate_filter_wp_title' );
function blankslate_filter_wp_title( $title )
{
return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init()
{
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
function blankslate_custom_pings( $comment )
{
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php 
}
add_filter( 'get_comments_number', 'blankslate_comments_number' );
function blankslate_comments_number( $count )
{
if ( !is_admin() ) {
global $id;
$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}

/***************************************************************************************************/
function theme_settings_page(){
 ?>
        <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
            ?>          
        </form>
        </div>
    <?php
}
 
function add_theme_menu_item()
{
    add_menu_page("@emcode", "@emcode", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}
 
add_action("admin_menu", "add_theme_menu_item");

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'banner',
    array(
      'labels' => array(
        'name' => __( 'Banner' ),
        'singular_name' => __( 'Banner' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('thumbnail','title'),
    )
  );
}


/****************************************************************************************************/
function display_twitter_element()
{
    ?>
        <input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
    <?php
}
 
function display_facebook_element()
{
    ?>
        <input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
    <?php
}
function display_youtube_element()
{
    ?>
        <input type="text" name="youtube_url" id="youtube_url" value="<?php echo get_option('youtube_url'); ?>" />
    <?php
}

function logo_display()
{
    if(get_option('logo')){
            echo '<img src="'.get_option('logo').'" width="200px">';
        }  
    ?>
        <br>
        <input type="file" id="logo" name="logo" value="<?php echo get_option('logo'); ?>"/> 
        <?php  
}
 
function handle_logo_upload()
{   
    if(!empty($_FILES["logo"]["tmp_name"]))
    {
        $urls = wp_handle_upload($_FILES["logo"], array('test_form' => FALSE));
        $temp = $urls["url"];
        return $temp;   
    }      
    return get_option('logo');

}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");
     
    add_settings_field("twitter_url", "Twitter", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook", "display_facebook_element", "theme-options", "section");
    add_settings_field("youtube_url", "Youtube", "display_youtube_element", "theme-options", "section");
    add_settings_field("logo", "Logo", "logo_display", "theme-options", "section"); 
    
    
    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
    register_setting("section", "youtube_url");
    register_setting("section", "logo", "handle_logo_upload");    
}
 
add_action("admin_init", "display_theme_panel_fields");

/***************************************************************************************************************/


add_action( 'init', 'enable_category_taxonomy_for_pages', 500 );

function enable_category_taxonomy_for_pages() {
    register_taxonomy_for_object_type('category','page');
}

function get_search_box($btn = false, $s=""){
    ?>
        <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                  <input type="text" id="search_text" class="form-control" name="s" placeholder="Buscar" value="<?php echo $s?>">
                  <?php if($btn){?><input type="submit" class="btn btn-default" value="Buscar"><?php }?> 
              </div>
              
        </form>        
        <?php
    
}



/************************************************************************************************************************/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_home-options',
		'title' => 'Home options',
		'fields' => array (
			array (
				'key' => 'field_54f368fcdfad5',
				'label' => 'Header slider',
				'name' => 'header_slider',
				'type' => 'relationship',
				'return_format' => 'object',
				'post_type' => array (
					0 => 'slider',
				),
				'taxonomy' => array (
					0 => 'sliders:2',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'post_type',
					1 => 'post_title',
				),
				'max' => 1,
			),
			array (
				'key' => 'field_54f36a1220907',
				'label' => 'Body Slider',
				'name' => 'body_slider',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_54f36a2820908',
						'label' => 'Slider',
						'name' => 'slider',
						'type' => 'relationship',
						'column_width' => '',
						'return_format' => 'id',
						'post_type' => array (
							0 => 'slider',
						),
						'taxonomy' => array (
							0 => 'sliders:3',
						),
						'filters' => array (
							0 => 'search',
						),
						'result_elements' => array (
							0 => 'post_type',
							1 => 'post_title',
						),
						'max' => '',
					),
					array (
						'key' => 'field_54f36a6c20909',
						'label' => 'Ancho',
						'name' => 'ancho',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'home.php',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_objeto-fields',
		'title' => 'Objeto-fields',
		'fields' => array (
			array (
				'key' => 'field_54f770a9c4c06',
				'label' => 'Video',
				'name' => 'video',
				'type' => 'file',
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_54f36878a75bf',
				'label' => 'Participante(s)',
				'name' => 'participant',
				'type' => 'relationship',
				'return_format' => 'id',
				'post_type' => array (
					0 => 'participante',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'post_type',
					1 => 'post_title',
				),
				'max' => '',
			),
			array (
				'key' => 'field_54f368aea75c0',
				'label' => 'Tiempo',
				'name' => 'tiempo',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => 'minutos',
				'prepend' => '',
				'append' => '',
				'min' => 0,
				'max' => 999,
				'step' => '',
			),
			array (
				'key' => 'field_54f37bc8d77a2',
				'label' => 'Método de acceso',
				'name' => 'view_method',
				'type' => 'radio',
				'choices' => array (
					'free' => 'Acceso libre',
					'pay' => 'No tiene acceso libre',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_54f37c3ed77a3',
				'label' => 'Con membresía',
				'name' => 'membresia',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54f37bc8d77a2',
							'operator' => '==',
							'value' => 'pay',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_54f3a7d80e955',
				'label' => 'Renta diaria',
				'name' => 'renta',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54f37bc8d77a2',
							'operator' => '==',
							'value' => 'pay',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_54f3a81c0e956',
				'label' => 'Compra',
				'name' => 'compra',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_54f37bc8d77a2',
							'operator' => '==',
							'value' => 'pay',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'objeto',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'serie',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_opciones-de-examen',
		'title' => 'Opciones de Examen',
		'fields' => array (
			array (
				'key' => 'field_55a45cd2ff778',
				'label' => 'Preguntas',
				'name' => 'preguntas',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55a45cdfff779',
						'label' => 'Pregunta',
						'name' => 'pregunta',
						'type' => 'wysiwyg',
						'column_width' => '',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'yes',
					),
					array (
						'key' => 'field_55a45cf3ff77a',
						'label' => 'Respuestas',
						'name' => 'respuestas',
						'type' => 'repeater',
						'column_width' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_55a45cfdff77b',
								'label' => 'Respuesta',
								'name' => 'respuesta',
								'type' => 'wysiwyg',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
							array (
								'key' => 'field_55a45d0dff77c',
								'label' => 'Correcta',
								'name' => 'correcta',
								'type' => 'true_false',
								'column_width' => '',
								'message' => '',
								'default_value' => 0,
							),
						),
						'row_min' => '',
						'row_limit' => '',
						'layout' => 'table',
						'button_label' => 'Agregar respuesta',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Agregar pregunta',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'examen',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_opciones-de-serie',
		'title' => 'Opciones de Serie',
		'fields' => array (
			array (
				'key' => 'field_55a45e09a4b62',
				'label' => 'Grupo',
				'name' => 'grupo',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55a45e9d3f84f',
						'label' => 'Titulo',
						'name' => 'titulo',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_55a45e1ba4b63',
						'label' => 'Capitulo',
						'name' => 'capitulo',
						'type' => 'relationship',
						'column_width' => '',
						'return_format' => 'id',
						'post_type' => array (
							0 => 'objeto',
							1 => 'examen',
						),
						'taxonomy' => array (
							0 => 'all',
						),
						'filters' => array (
							0 => 'search',
						),
						'result_elements' => array (
							0 => 'post_type',
							1 => 'post_title',
						),
						'max' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Agregar Grupo',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'serie',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_options-site',
		'title' => 'Options: Site',
		'fields' => array (
			array (
				'key' => 'field_54f36c86bfdaf',
				'label' => 'Acceso',
				'name' => 'acceso',
				'type' => 'radio',
				'instructions' => 'Al seleccionar una opción automáticamente da acceso a las opciones anteriores. ',
				'choices' => array (
					'secret' => 'No permitir acceso sin login',
					'home' => 'Home',
					'object' => 'Info Objetos',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_54f7708b03df6',
				'label' => 'Servidor Wowza',
				'name' => 'servidor_wowza',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_550bd24d3c480',
				'label' => 'Moneda',
				'name' => 'moneda',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_550bd26122f70',
				'label' => 'Moneda Abreviado',
				'name' => 'moneda_abreviado',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_slider-img',
		'title' => 'Slider-img',
		'fields' => array (
			array (
				'key' => 'field_54f367ab9a078',
				'label' => 'Imagenes',
				'name' => 'imagenes',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_54f367b79a079',
						'label' => 'Imagen',
						'name' => 'imagen',
						'type' => 'image',
						'column_width' => '',
						'save_format' => 'url',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array (
						'key' => 'field_54f367ea9a07a',
						'label' => 'Descripcion',
						'name' => 'descripcion',
						'type' => 'textarea',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'formatting' => 'br',
					),
					array (
						'key' => 'field_54f3681c9a07b',
						'label' => 'URL',
						'name' => 'url',
						'type' => 'relationship',
						'column_width' => '',
						'return_format' => 'id',
						'post_type' => array (
							0 => 'objeto',
						),
						'taxonomy' => array (
							0 => 'all',
						),
						'filters' => array (
							0 => 'search',
						),
						'result_elements' => array (
							0 => 'post_type',
							1 => 'post_title',
						),
						'max' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Agregar imagen',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slider',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '2',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_slider-objeto',
		'title' => 'Slider-Objeto',
		'fields' => array (
			array (
				'key' => 'field_54f3671fa4d7c',
				'label' => 'Opciones',
				'name' => 'opciones',
				'type' => 'checkbox',
				'choices' => array (
					'new' => 'Nuevo',
					'userlike' => 'Basado en gusto de usuario',
					'userfriendlike' => 'Basado en gusto otros usuarios',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_54f3673ca4d7d',
				'label' => 'Categoría',
				'name' => 'categoria',
				'type' => 'taxonomy',
				'taxonomy' => 'category',
				'field_type' => 'checkbox',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slider',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '3',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


/************************************************************************************************************************/



include_once 'functions/logic.php';