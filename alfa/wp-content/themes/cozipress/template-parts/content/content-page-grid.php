<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cozipress
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-items'); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="post-image post-image-absolute">
			<div class="featured-image">
				<a href="<?php esc_url(the_permalink()); ?>" class="post-hover">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>
		</figure>
	<?php endif; ?>	
	<div class="post-content">
		<div class="post-meta">
			<div class="post-line">
				<span class="post-list">
					<ul class="post-categories">
						<li><a href="#"></a><a href="<?php echo esc_url(get_permalink());?>"><?php the_category(', '); ?></a></li>
					</ul>
				</span>
			</div>
			<div>
				<span class="post-date">
					<a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>"><span><?php echo esc_html(get_the_date('j')); ?></span><?php echo esc_html(get_the_date('M')); ?><br><?php echo esc_html(get_the_date('Y')); ?></a>
				</span>
				<span class="author-name">	
					<?php  $user = wp_get_current_user(); ?>
					<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>" title="<?php esc_attr(the_author()); ?>" class="author meta-info hide-on-mobile"> <span class="author-image" style="background-image: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>');"></span></a>
				</span>
			</div>
		</div>
		<?php 
			if ( is_single() ) :
				
			the_title('<h5 class="post-title">', '</h5>' );
			
			else:
			
			the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
			
			endif; 
			
			the_content( 
					sprintf( 
						__( 'Read More', 'cozipress' ), 
						'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
					) 
				);
		?>
	</div>
</article>