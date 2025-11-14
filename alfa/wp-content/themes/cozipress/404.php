<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cozipress
 */

get_header();
?>
<section id="section-404" class="section-404 st-py-default">
	<div class="container">
		<div class="row wow fadeInUp">
			<div class="col-lg-6 col-12 text-center mx-auto">
				<div class="card-404">
					<h2><?php esc_html_e('O','cozipress'); ?><span class="text-primary"><?php esc_html_e('pp','cozipress'); ?></span><?php esc_html_e('s','cozipress'); ?></h2>
					<h1><?php esc_html_e('4','cozipress'); ?><i class="fa fa-smile-o"></i><?php esc_html_e('4','cozipress'); ?></h1>
					<p><?php esc_html_e('The page you were looking for could not be found.','cozipress'); ?></p>
					<div class="card-404-btn mt-3">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-like-icon"><?php esc_html_e('Go to Home','cozipress'); ?> <span class="bticn"><i class="fa fa-home"></i></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	
<?php get_footer(); ?>
