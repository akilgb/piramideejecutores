<?php
// Register Block Category
function accron_block_categories( $categories ) {
    return array_merge( array( array(
        'slug'  => 'clever-fox',
        'title' => __( 'Info Box', 'clever-fox' ),
    ) ), $categories );
}
if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
    add_filter( 'block_categories', 'accron_block_categories', 10, 2 );
} else {
    add_filter( 'block_categories_all', 'accron_block_categories', 10, 2 );
}

// Register Blocks
function accron_wp_register_script( $block, $options = array() ) {
    register_block_type( 'info-box/' . $block,
        array_merge( array(
            'editor_script' => 'accron_editor_script',
            'editor_style'  => 'accron_editor_style',
            'script'        => 'accron_script',
            'style'         => 'accron_style',
        ), $options )
    );
}

// Enqueue assets
function accron_enqueue_block_assets() {
    wp_enqueue_script( 'font-awesome-kit', CLEVERFOX_PLUGIN_URL . '/inc/accron/block/assets/js/font-awesome-kit.js', array(), '1.0', true );
}
add_action( 'enqueue_block_assets', 'accron_enqueue_block_assets' );

function accron_register() {
    // Resister script in editor
	 wp_register_script( 'accron_editor_script', CLEVERFOX_PLUGIN_URL . '/inc/accron/block/dist/editor.js', array( 'wp-blob', 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-html-entities', 'wp-i18n', 'wp-rich-text', 'font-awesome-kit' ), '1.0', false ); 
    wp_register_style( 'accron_editor_style', CLEVERFOX_PLUGIN_URL . '/inc/accron/block/dist/editor.css', array( 'wp-edit-blocks'), null );

    // Register Blocks
    accron_wp_register_script( 'infos', array( 'render_callback' => 'render_accron_infos' ) );
    accron_wp_register_script( 'info', array( 'render_callback' => 'render_accron_info' ) );
}
add_action( 'init', 'accron_register' );

// Generate Styles
class AccronInfoStyleGenerator {
    public static $styles = [];
    public static function addStyle($selector, $styles){
        if(array_key_exists($selector, self::$styles)){
           self::$styles[$selector] = wp_parse_args(self::$styles[$selector], $styles);
        }else {
            self::$styles[$selector] = $styles;
        }
    }
    public static function renderStyle(){
        $output = '';
        foreach(self::$styles as $selector => $style){
            $new = '';
            foreach($style as $property => $value){
                if($value == ''){ $new .= $property; }else { $new .= " $property: $value;"; }
            }
            $output .= "$selector { $new }";
        }
        return $output;
    }
}

// Render Infos
function render_accron_infos($attributes, $content){
    extract( $attributes );

    $cId = $cId ?? '';

    // Generate Styles
    $infosStyle = new AccronInfoStyleGenerator();

    ob_start(); // Echo the content
    echo "<div class='av-columns-area info-section info-section-one wow fadeInUp'>". $infosStyle::renderStyle() ."</style>". $content ."</div>";
	//echo  $content;

    $infosStyle::$styles = array(); // Empty before blocks styles in after blocks
    return ob_get_clean();
}

// Render Info
function render_accron_info( $attributes ) {
    extract( $attributes );

    $cId = $cId ?? '';
	$columns = $columns ?? array( 'desktop' => 2, 'tablet'  => 2, 'mobile'  => 1 );
    $isIcon = $isIcon ?? true;
    $icon = $icon ?? array('class' => 'fa fa-wordpress', 'fontSize' => 70);
    $isTitle = $isTitle ?? true;
    $title = $title ?? 'Info title';
    $isDesc = $isDesc ?? true;
    $desc = $desc ?? 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, fuga.';
	$isLink = $isLink ?? true;
    $link = $link ?? '#';
	$isInfoType = $isInfoType ?? true;
    $infoType = $infoType ?? 'Style 1';
	if($infoType =='Style 2'){
		$infoTypes='info-wrapper2';
	}elseif($infoType =='Style 3'){
		$infoTypes='info-wrapper2 info-wrapper3';
	}else{
		$infoTypes='info-wrapper';
	}

    // Generate Styles
    $infoStyle = new AccronInfoStyleGenerator();
    $infoStyle::addStyle("#accronInfo-$cId .accronInfo .icon", array(
        $icon['styles'] ?? 'font-size: 70px;' => ''
    ));

    // Components
	$linkEl = $isLink ? "$link" : '';
    $iconEl = $isIcon && $icon['class'] ? "<div class='contact-icon'><i class='".$icon['class']."'></i></div>" : '';
	
	if($infoType =='Style 2' || $infoType =='Style 3'){
		$titleEl = $isTitle ? "<a href='". $linkEl ."' class='contact-info'><span class='text'>$title</span>" : '';
		$descEl = $isDesc ? "<span class='description title'>$desc</span></a>" : '';
	}else{
		$titleEl = $isTitle ? "<a href='". $linkEl ."' class='contact-info'><span class='title'>$title</span></a>" : '';
		$descEl = $isDesc ? "<span class='description text'>$desc</span>" : '';
	}	

    ob_start(); // Echo the content
    // echo "<div class='av-column-".$columns['desktop']." ".$infoTypes."' id='accronInfo-$cId'>
        // <style>". $infoStyle::renderStyle() ."</style>
		// <aside class='widget widget-contact'>
			// <div class='contact-area'>
				// $iconEl $titleEl $descEl 
			// </div>	
		// </aside>
    // </div>";
	
	echo "<div class='av-column-".$columns['desktop']." ".$infoTypes."' id='accronInfo-$cId'>
			<aside class='widget widget-contact'>
				<div class='contact-area'>
					$iconEl $titleEl $descEl 
				</div>	
			</aside>
		</div>";

    $infoStyle::$styles = array(); // Empty before blocks styles in after blocks
    return ob_get_clean();
}