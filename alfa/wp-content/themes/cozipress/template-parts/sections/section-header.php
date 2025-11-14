<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>	
<?php endif;  ?>
<!--===// Start: Main Header
    =================================-->
    <header id="main-header" class="main-header">
        <?php do_action( 'cozipress_above_header');  ?>
		
		<!--===// Start: Navigation Wrapper
        =================================-->
        <div class="navigation-wrapper">
            <!--===// Start: Main Desktop Navigation
            =================================-->
            <div class="main-navigation-area d-none d-lg-block">
                <div class="main-navigation <?php echo esc_attr(cozipress_sticky_menu()); ?> ">
                    <div class="container">
                        <div class="row">
                            <div class="col-3 my-auto">
                                <div class="logo">
                                   <?php 
										if(has_custom_logo())
										{	
											the_custom_logo();
										}
										else { 
										?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<h4 class="site-title">
												<?php 
													echo esc_html(bloginfo('name'));
												?>
											</h4>
										</a>	
									<?php 						
										}
									?>
									<?php
										$cozipress_site_desc = get_bloginfo( 'description');
										if ($cozipress_site_desc) : ?>
											<p class="site-description"><?php echo esc_html($cozipress_site_desc); ?></p>
									<?php endif; ?>
                                </div>
                            </div>
                            <div class="col-9 my-auto">
                                <nav class="navbar-area">
                                    <div class="main-navbar">
                                       <?php 
											wp_nav_menu( 
												array(  
													'theme_location' => 'primary_menu',
													'container'  => '',
													'menu_class' => 'main-menu',
													'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
													'walker' => new WP_Bootstrap_Navwalker()
													 ) 
												);
									    ?>                            
                                    </div>
                                    <div class="main-menu-right">
                                        <ul class="menu-right-list">
											<?php 
												$cozipress_hs_cart       = get_theme_mod( 'hide_show_cart','1'); 
												if($cozipress_hs_cart == '1') { 
												 if ( class_exists( 'WooCommerce' ) ) { ?>
													<li class="cart-wrapper">
														<button type="button" class="cart-icon-wrap header-cart">
															<i class="fa fa-shopping-cart"></i>
															<?php 
																if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
																	$count = WC()->cart->cart_contents_count;
																	$cart_url = wc_get_cart_url();
																	
																	if ( $count > 0 ) {
																	?>
																		 <span><?php echo esc_html( $count ); ?></span>
																	<?php 
																	}
																	else {
																		?>
																		<span><?php esc_html_e('0','cozipress'); ?></span>
																		<?php 
																	}
																}
																?>
														</button>
														<!-- Shopping Cart -->
														<div class="shopping-cart">
															<ul class="shopping-cart-items">
																<?php get_template_part('woocommerce/cart/mini','cart'); ?>
															</ul>
														</div>
														<!--end shopping-cart -->
													</li>
												<?php } } ?>
												<?php 
													$cozipress_hs_nav_search       = get_theme_mod( 'hs_nav_search','1'); 
													if($cozipress_hs_nav_search == '1') { ?>
														<li class="search-button">
															<button type="button" id="header-search-toggle" class="header-search-toggle" aria-expanded="false" aria-label="<?php esc_attr_e( 'Search Popup', 'cozipress' ); ?>"><i class="fa fa-search"></i></button>
															<!--===// Start: Header Search PopUp
															=================================-->
															<div class="header-search-popup">
																<div class="header-search-flex">
																	<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site Search', 'cozipress' ); ?>">
																		<input type="search" class="form-control header-search-field" placeholder="<?php esc_attr_e( 'Type To Search', 'cozipress' ); ?>" name="s" id="search">
																		<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
																	</form>
																	<button type="button" id="header-search-close" class="close-style header-search-close" aria-label="<?php esc_attr_e( 'Search Popup Close', 'cozipress' ); ?>"></button>
																</div>
															</div>
															<!--===// End: Header Search PopUp
															=================================-->
														</li>
													<?php }	?>
                                        </ul>                            
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--===// End:  Main Desktop Navigation
            =================================-->
            <!--===// Start: Main Mobile Navigation
            =================================-->
            <div class="main-mobile-nav <?php echo esc_attr(cozipress_sticky_menu()); ?>"> 
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="main-mobile-menu">
                                <div class="mobile-logo">
                                    <div class="logo">
                                        <?php 
											if(has_custom_logo())
											{	
												the_custom_logo();
											}
											else { 
											?>
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
												<h4 class="site-title">
													<?php 
														echo esc_html(bloginfo('name'));
													?>
												</h4>
											</a>	
										<?php 						
											}
										?>
										<?php
											$cozipress_site_desc = get_bloginfo( 'description');
											if ($cozipress_site_desc) : ?>
												<p class="site-description"><?php echo esc_html($cozipress_site_desc); ?></p>
										<?php endif; ?>
                                    </div>
                                </div>
                                <div class="menu-collapse-wrap">
                                    <div class="hamburger-menu">
                                        <button type="button" class="menu-collapsed" aria-label="<?php esc_attr_e( 'Menu Collaped', 'cozipress' ); ?>">
                                            <div class="top-bun"></div>
                                            <div class="meat"></div>
                                            <div class="bottom-bun"></div>
                                        </button>
                                    </div>
                                </div>
                                <div class="main-mobile-wrapper">
                                    <div id="mobile-menu-build" class="main-mobile-build">
                                        <button type="button" class="header-close-menu close-style" aria-label="<?php esc_attr_e( 'Header Close Menu', 'cozipress' ); ?>"></button>
                                    </div>
                                </div>
								<?php if ( function_exists( 'burger_companion_activated' ) ) { ?>
									<div class="header-above-btn">
										<button type="button" class="header-above-collapse" aria-label="<?php esc_attr_e( 'Header Above Collapse', 'cozipress' ); ?>"><span></span></button>
									</div>
									<div class="header-above-wrapper">
										<div id="header-above-bar" class="header-above-bar"></div>
									</div>
								<?php } ?>	
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
            <!--===// End: Main Mobile Navigation
            =================================-->
        </div>
        <!--===// End: Navigation Wrapper
        =================================-->
    </header>
    <!-- End: Main Header
    =================================-->