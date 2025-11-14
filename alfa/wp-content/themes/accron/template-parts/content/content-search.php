<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Accron
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-item-inner wow fadeInUp'); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<figure class="post-image">
			<div class="featured-image">
				<a href="javascript:void(0);">
					<?php the_post_thumbnail('accron-large-image'); ?>
				</a>
				<div class="post-date-badge">
					<span class="posted-on-page post-date-page">
						<a href="<?php echo esc_url(get_the_date('Y/m/d')); ?>"> <span class="post-date-badge-1"><span><?php echo esc_html(get_the_date('j')); ?></span></span> <span class="post-badge-2"><span><?php echo esc_html(get_the_date('M, Y')); ?></span></span></a>
					</span>
				</div>
			</div>
		</figure>
	<?php } ?>
	
	<div class="post-content-page">
		<div class="post-meta up">
			<span class="author-name">
				<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><i class="fa fa-user"></i> <?php esc_html(the_author()); ?></a>
			</span>
			<span class="comments-link">
				<a href="<?php echo esc_url(get_comments_link( $post->ID )); ?>"><i class="fa fa-commenting-o"></i> <?php echo esc_html(get_comments_number($post->ID)); ?> <?php esc_html_e('Comment','accron'); ?></a>
			</span>
		</div>
	<?php     
		if ( is_single() ) :
				
		the_title('<h2 class="post-title">', '</h2>' );
		
		else:
		
		the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		
		endif; 
	?> 
	<?php 
		the_content( 
				sprintf( 
					__( 'Read More', 'accron' ), 
					'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
				) 
			);
	?>
	</div>
</article>