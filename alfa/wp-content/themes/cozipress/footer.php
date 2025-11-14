<!--===// Start: Footer
    =================================-->
</div>
<?php 
	$footer_bg_img			= get_theme_mod('footer_bg_img',esc_url(get_template_directory_uri() .'/assets/images/bg/footer_bg.jpg')); 
	$footer_back_attach		= get_theme_mod('footer_back_attach','scroll');
?>	
	<footer id="footer-section" class="footer-section main-footer" style="background:url('<?php echo esc_url($footer_bg_img); ?>') no-repeat <?php echo esc_attr($footer_back_attach); ?> center center / cover rgb(0 0 0 / 0.75);background-blend-mode:multiply;">
		<?php  if ( is_active_sidebar( 'cozipress-footer-widget-area' ) ) { ?>	
			<div class="footer-main st-pt-default">
				<div class="container">
					<div class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-5">
						<?php  dynamic_sidebar( 'cozipress-footer-widget-area' ); ?>
					</div>
				</div>
			</div>
		<?php } 
		?>	
        <div class="footer-copyright">
            <div class="container">
                <div class="row align-items-center gy-lg-0 gy-4">
					<div class="col-lg-6 col-md-6 col-12 text-lg-left text-md-left text-center">
						<div class="widget-left text-lg-left text-md-left text-center">
							<?php 
								$hide_show_footer_btm_support	= get_theme_mod('hide_show_footer_btm_support','1');
								$footer_btm_support_icon		= get_theme_mod('footer_btm_support_icon','fa-phone');
								$footer_btm_support_ttl			= get_theme_mod('footer_btm_support_ttl');
								$footer_btm_support_text		= get_theme_mod('footer_btm_support_text'); 
								if($hide_show_footer_btm_support =='1'){
									?>
										<aside class="widget widget-contact">
											<div class="contact-area">
												<div class="contact-icon">
													<div class="contact-corn"><i class="fa <?php echo esc_attr($footer_btm_support_icon); ?>"></i></div>
												</div>
												<div class="contact-icon-duplicate"><i class="fa <?php echo esc_attr($footer_btm_support_icon); ?>"></i></div>
												<div class="contact-info">
													<h6 class="title"><?php echo wp_kses_post($footer_btm_support_ttl); ?></h6>
													<p class="text"><?php echo wp_kses_post($footer_btm_support_text); ?></p>
												</div>
											</div>
										</aside>
									<?php
								}
							?>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-12 text-lg-right text-md-right text-center">
						<?php
							$footer_copyright	= get_theme_mod('footer_copyright','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');
							if ( ! empty( $footer_copyright ) ){ ?>
								<?php 	
									$cozipress_copyright_allowed_tags = array(
										'[current_year]' => date_i18n('Y'),
										'[site_title]'   => get_bloginfo('name'),
										'[theme_author]' => sprintf(__('<a href="#">CoziPress</a>', 'cozipress')),
									);
								?>                          
								<div class="copyright-text">
									<?php
										echo apply_filters('cozipress_footer_copyright', wp_kses_post(cozipress_str_replace_assoc($cozipress_copyright_allowed_tags, $footer_copyright)));
									?>
								</div>
							<?php }	?>
					</div>
                </div>
            </div>
        </div>
    </footer>
	
    <!-- Scrolling Up -->	
	<button type="button" class="scrollingUp scrolling-btn" aria-label="scrollingUp"><i class="fa fa-angle-up"></i></button>	

</div>		
<?php wp_footer(); ?>
</body>
</html>
