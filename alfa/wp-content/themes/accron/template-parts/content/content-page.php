<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Accron
 */
?>
<div class="<?php accron_post_columns(); ?>">
	<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<?php if ( has_post_thumbnail() ) { ?>
			<figure class="post-image ">	
					<?php the_post_thumbnail('accron-large-image'); ?>
				</figure>
		<?php } ?>
		
		<div class="post-content">
				<div class="post-meta up">
					<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>" title="<?php echo esc_url(get_avatar_url(get_the_author_meta( 'name' ))) ?>" class="author">
						<span class="author-image"><img src="<?php echo esc_url(get_avatar_url(get_the_author_meta( 'ID' ))) ?>" alt="<?php echo esc_attr__('Author Image','accron'); ?>" width="70" height="70"></span>
						<span class="author-name"><?php echo esc_html__('Posted By :','accron'); ?> <span class="primary-color"><?php esc_html(the_author()); ?></span></span>
					</a>
					<span class="post-date">
						<a href="<?php echo esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))); ?>">  <?php echo esc_html(get_the_date('j M')); ?>, <span><?php echo esc_html(get_the_date('Y')); ?></span></a>
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
						__( 'Read Blog', 'accron' ), 
						'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
					) 
				);
		?>
		</div>
	</div>
</div>	