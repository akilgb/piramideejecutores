<?php 
	$footer_bg_img				= get_theme_mod('footer_bg_img');
?>

<!-- footer section -->
<footer class="footer-section footer-blur" style="background-image: url(<?php echo esc_url(get_template_directory_uri() .'/assets/images/bg-footer.jpg'); ?>)">
	<div class="blur-effect">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"
            style="position: absolute;inset:0;z-index:-1">
            <filter id="footerb" filterUnits="userSpaceOnUse" x="0" y="0" width="100%" height="100%">
                <feImage href="<?php echo esc_url(get_template_directory_uri() .'/assets/images/bg-footer.jpg'); ?>" preserveAspectRatio="xMidYMid slice" result="back" />
                <feGaussianBlur stdDeviation="40" in="SourceGraphic" />
                <feComponentTransfer result="cutoff">
                    <feFuncA type="linear" slope="19" intercept="-9" />
                </feComponentTransfer>
                <feComposite operator="in" in="back" in2="blur" />
                <feGaussianBlur stdDeviation="30" result="blur" />
            </filter>
            <image id="scene1" href="<?php echo esc_url($footer_bg_img); ?>" width="100%" height="100%"
                preserveAspectRatio="xMidYMid slice" />
            <g id="footer-effect" style="filter:url(#footerb);fill:white">
				</g>
        </svg>
    </div>
	<div class="container">
		<div class="footer-main">
			<?php if ( is_active_sidebar( 'accron-footer-widget' ) ) { ?>
				<div class="row">
					<?php  dynamic_sidebar( 'accron-footer-widget' ); ?>
				</div>	
			 <?php } ?>
		</div>
	
		<?php 		
			$hide_show_footer_mbl_details 		= get_theme_mod( 'hide_show_footer_mbl_details','1'); 
			$footer_get_in_touch_icon 			= get_theme_mod( 'footer_get_in_touch_icon','fa-phone');
			$footer_get_in_touch_title 			= get_theme_mod( 'footer_get_in_touch_title'); 
			$footer_get_in_touch_number 		= get_theme_mod( 'footer_get_in_touch_number'); 
			
			$hide_show_footer_email_details 	= get_theme_mod( 'hide_show_footer_email_details','1');
			$footer_email_icon 					= get_theme_mod( 'footer_email_icon','fa-envelope'); 
			$footer_email_title 				= get_theme_mod( 'footer_email_title'); 
			$footer_email 						= get_theme_mod( 'footer_email');
			
			$hide_show_footer_cntct_details 	= get_theme_mod( 'hide_show_footer_cntct_details','1'); 
			$footer_contct_icon 				= get_theme_mod( 'footer_contct_icon','fa-location-arrow');
			$footer_address_title 				= get_theme_mod( 'footer_address_title'); 
			$footer_contact_address 			= get_theme_mod( 'footer_contact_address');
			

			if($hide_show_footer_cntct_details =='1' || $hide_show_footer_email_details =='1' || $hide_show_footer_mbl_details =='1'):
		?>
			<div class="footer-middle">
				<div class="row">
					<?php if($hide_show_footer_cntct_details =='1' && !empty($footer_contact_address)): ?>
						<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="contactinfo-box">
								<aside class="widget widget-contact">
									<div class="contact-area">
										<div class="contact-icon">
											<i class="fas <?php echo esc_attr($footer_contct_icon); ?>"></i>
											<i class="fas <?php echo esc_attr($footer_contct_icon); ?>"></i>
										</div>
										<div class="contact-info">
											<p class="text">
												<span class="title"><?php echo wp_kses_post($footer_address_title); ?></span>
												<a href="#"><?php echo wp_kses_post($footer_contact_address); ?></a>
											</p>
										</div>
									</div>
								</aside>
							</div>
						</div>
					<?php endif; ?>	
					
					<?php if($hide_show_footer_email_details =='1' && !empty($footer_email)): ?>	
						<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="contactinfo-box">
								<aside class="widget widget-contact">
									<div class="contact-area">
										<div class="contact-icon">
											<i class="fas <?php echo esc_attr($footer_email_icon); ?>"></i>
											<i class="fas <?php echo esc_attr($footer_email_icon); ?>"></i>
										</div>
										<div class="contact-info">
											<p class="text">
												<span class="title"><?php echo wp_kses_post($footer_email_title); ?></span>
												<a href="mailto:<?php echo esc_attr($footer_email); ?>">
													<?php echo esc_html($footer_email); ?>
												</a>
											</p>
										</div>
									</div>
								</aside>
							</div>
						</div>
					<?php endif; ?>	
						
					<?php if($hide_show_footer_mbl_details =='1' && !empty($footer_get_in_touch_number)): ?>	
						<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="contactinfo-box">
								<aside class="widget widget-contact">
									<div class="contact-area">
										<div class="contact-icon">
											<i class="fas <?php echo esc_attr($footer_get_in_touch_icon); ?>"></i>
											<i class="fas <?php echo esc_attr($footer_get_in_touch_icon); ?>"></i>
										</div>
										<div class="contact-info">
											<p class="text">
												<span class="title"><?php echo esc_html($footer_get_in_touch_title); ?></span>
												<a href="tel:<?php echo esc_attr(str_replace(' ','',$footer_get_in_touch_number)); ?>">
													<?php echo esc_html($footer_get_in_touch_number); ?>
												</a>
											</p>
										</div>
									</div>
								</aside>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
        <div class="footer-copyright">
            <div class="row">
                <div class="col-lg-6 col-md-6">
					<?php 	
						$footer_first_custom 		= get_theme_mod('footer_first_custom','Copyright &copy; [current_year] | Powered by [theme_author]');
						
						$accron_copyright_allowed_tags = array(
							'[current_year]' => date_i18n('Y', current_time( 'timestamp' )),
							'[site_title]'   => get_bloginfo('name'),
							'[theme_author]' => sprintf(__('<a href="#">%s</a>', 'accron'), esc_html__('Accron', 'accron')),
						);
					?>                        
						<p class="copyright-text">
							<?php
								echo apply_filters('accron_footer_copyright', wp_kses_post(accron_str_replace_assoc($accron_copyright_allowed_tags, $footer_first_custom)));
							?>
						</p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <aside class="widget widget_pages">
                        <?php do_action('accron_footer_navigation'); ?>
                    </aside>
                </div>
            </div>
        </div>
	</div>	
</footer>
<!-- END FOOTER -->

<!-- START: SCROLL UP -->
	<?php 
		$hs_scroller 	= get_theme_mod('hs_scroller','1');	
		if($hs_scroller == '1') :
	?>
	<!-- ======== Back to Top =====- -->
    <!-- scroll-top -->
	<button type="button" class="scrollingUp scroll-btn" aria-label="scrollingUp"><i class="fas fa-angle-double-up"></i></button>
    <!-- ======== End ======== -->
	<?php endif; ?>
<!-- END: SCROLL UP -->
<?php 
wp_footer(); ?>
</body>
</html>
