<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Accron
 */

get_header();
?>
<section class="blog-section blog-page">
	<div class="container">
		<div class="row">
			<div class="<?php esc_attr(accron_blog_column_layout()); ?>">
				<?php if( have_posts() ): ?>
					<div class="row">
						<?php while( have_posts() ) : the_post(); ?>
						<div class="col-md-6 col-sm-12">
							<?php get_template_part('template-parts/content/content','page'); ?>
						</div>	
						<?php endwhile; 
						the_posts_navigation();
						?>
					</div>	
				<?php else: ?>
				
					<?php get_template_part('template-parts/content/content','none'); ?>
					
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>	
<?php get_footer(); ?>
