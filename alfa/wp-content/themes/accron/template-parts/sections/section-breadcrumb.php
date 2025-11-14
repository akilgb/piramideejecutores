<?php 
$hs_breadcrumb							= get_theme_mod('hs_breadcrumb','1');
$breadcrumb_effect_enable				= get_theme_mod('breadcrumb_effect_enable','1');
$breadcrumb_back_attach					= get_theme_mod('breadcrumb_back_attach');
$breadcrumb_bg_img						= get_theme_mod('breadcrumb_bg_img',esc_url(get_template_directory_uri() .'/assets/images/breadcrumb.jpg'));
$accron_effect_class 					= ($breadcrumb_effect_enable=='1')?'breadcrumb-blur':'';
if($hs_breadcrumb == '1') {	
?>
<section class="breadcrumb-area <?php echo esc_attr($accron_effect_class); ?>">
			<div class="blur-effect2"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"
				style="position: absolute;inset:0;z-index:-1">
				<filter id="whiff" filterUnits="userSpaceOnUse" x="0" y="0" width="100%" height="100%">
					<feImage href="<?php echo esc_url($breadcrumb_bg_img); ?>" preserveAspectRatio="xMidYMid slice" result="back" />
					<feGaussianBlur stdDeviation="40" in="SourceGraphic" />
					<feComponentTransfer result="cutoff">
						<feFuncA type="linear" slope="19" intercept="-9" />
					</feComponentTransfer>
					<feComposite operator="in" in="back" in2="blur" />
					<feGaussianBlur stdDeviation="30" result="blur" />
				</filter>
				<image id="scene" href="<?php echo esc_url($breadcrumb_bg_img); ?>" width="100%" height="100%"
					preserveAspectRatio="xMidYMid slice" />
				<g id="breadcrumb-effect" style="filter:url(#whiff);fill:white">
				</g>
			</svg></div>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="breadcrumb-content">	
						<h1 class="breadcrumb-heading">
						<?php 
							if ( is_home() || is_front_page()):

								single_post_title();
						
							elseif ( is_day() ) : 
							
								printf( __( 'Daily Archives: %s', 'accron' ), get_the_date() );
							
							elseif ( is_month() ) :
							
								printf( __( 'Monthly Archives: %s', 'accron' ), (get_the_date( 'F Y' ) ));
								
							elseif ( is_year() ) :
							
								printf( __( 'Yearly Archives: %s', 'accron' ), (get_the_date( 'Y' ) ) );
								
							elseif ( is_category() ) :
							
								printf( __( 'Category Archives: %s', 'accron' ), (single_cat_title( '', false ) ));

							elseif ( is_tag() ) :
							
								printf( __( 'Tag Archives: %s', 'accron' ), (single_tag_title( '', false ) ));
								
							elseif ( is_404() ) :

								printf( __( 'Error 404', 'accron' ));
								
							elseif ( is_author() ) :
							
								printf( __( 'Author: %s', 'accron' ), (get_the_author( '', false ) ));	
								
							elseif ( class_exists( 'woocommerce' ) ) : 
								
								if ( is_shop() ) {
									woocommerce_page_title();
								}
								
								elseif ( is_cart() ) {
									the_title();
								}
								
								elseif ( is_checkout() ) {
									the_title();
								}
								
								else {
									the_title();
								}
							else :
									the_title();
									
							endif;
								
						?>
					</h1>
				</div>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
					<?php if (function_exists('accron_breadcrumbs')) accron_breadcrumbs();?>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</section>
<?php } ?>	