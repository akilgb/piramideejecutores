<?php 
	$cozipress_hs_blog		 	 = get_theme_mod('hs_blog','1');
	$cozipress_blog_title		 = get_theme_mod('blog_title');
	$cozipress_blog_subtitle	 = get_theme_mod('blog_subtitle');
	$cozipress_blog_desc		 = get_theme_mod('blog_description');
	$cozipress_blog_display_num	 = get_theme_mod('blog_display_num','3');
if($cozipress_hs_blog == '1'){		
?>	
<section id="post-section" class="home-blog post-section st-pb-default st-pt-default">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-12 mx-lg-auto mb-5 text-center">
				<div class="heading-default wow fadeInUp">
					<?php if ( ! empty( $cozipress_blog_title ) ) : ?>
						 <span class="badge ttl"><?php echo esc_html($cozipress_blog_title); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $cozipress_blog_subtitle ) ) : ?>		
						<h2><?php echo wp_kses_post($cozipress_blog_subtitle); ?></h2>   							
					<?php endif; ?>	
					<?php if ( ! empty( $cozipress_blog_desc ) ) : ?>		
						<p><?php echo esc_html($cozipress_blog_desc); ?></p>    
					<?php endif; ?>	
				</div>
			</div>
		</div>
		<div class="row row-cols-1 wow fadeInUp g-5">
				<?php 	
					$cozipress_blogs_args = array( 'post_type' => 'post', 'posts_per_page' => $cozipress_blog_display_num,'post__not_in'=>get_option("sticky_posts")) ; 	
					$cozipress_blog_wp_query = new WP_Query($cozipress_blogs_args);
					if($cozipress_blog_wp_query)
					{	
					while($cozipress_blog_wp_query->have_posts()):$cozipress_blog_wp_query->the_post(); ?>
						<div class="col-lg-4">
							<?php get_template_part('template-parts/content/content','page-grid');  ?>
						</div>
				<?php
					endwhile;
					}
				?>
		</div>
	</div>
</section>
<?php } ?>