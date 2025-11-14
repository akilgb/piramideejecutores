<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Accron
 */
get_header();
?>
<section class="section-404">
	<div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card-404">
					<h2><?php echo wp_kses_post('4 <i class="fas fa-cog"></i> 4','accron'); ?></h2>
					<h3 class="not-found"><?php echo wp_kses_post('Oops! Page Not Found','accron'); ?></h3>
					<p><?php echo wp_kses_post('Oops! The page you are looking for does not exist.','accron'); ?></p>					
					<a href="<?php echo esc_url( home_url( '/' )); ?>" class="main-btn"><span><?php echo esc_html_e('Back To Home','accron'); ?></span></a>					
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
