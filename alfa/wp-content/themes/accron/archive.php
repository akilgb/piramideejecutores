<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
							<?php get_template_part('template-parts/content/content','page'); ?>
						<?php endwhile; ?>
					</div>	
				<?php else: ?>							
						<?php get_template_part('template-parts/content/content','none'); ?>
				<?php endif; ?>						
			</div>
			<?php  get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
