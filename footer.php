
			

		</main><!-- /#main -->
		<footer id="footer" class="py-5">
			<div class="container">
				<div class="row">
					<div class="col-md-4">


					<?php dynamic_sidebar( 'footer_widget_01' );?>		

						<!-- <img src="<?php echo get_site_url()?>/wp-content/uploads/2024/05/simbolo-mercado-abastos.png" alt="Logo Mercado de Abastos">
						<ul class="list-style-none mt-2 p-0">
							<li><i class="bi bi-geo-alt me-2"></i>C/ Jesús Guridi</li>
							<li><i class="bi bi-envelope me-2"></i><a href="mailto:info@mercadoabastos.eus">info@mercadoabastos.eus</a></li>
							<li><i class="bi bi-telephone me-2"></i>945 28 79 72</li>
						</ul> -->
					
					
					</div>
					<div class="col-md-4">
						<h3>Newsletter</h3>
						<form action="">
							<input type="text" value="email" class="bg-dark text-white">
						</form>
					</div>
					<div class="col-md-4">
						
					<?php
						if ( has_nav_menu( 'footer-menu' ) ) : // See function register_nav_menus() in functions.php
							/*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'footer-menu', 'Footer Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Footer menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
							*/
							wp_nav_menu(
								array(
									'container'       => 'nav',
									'container_class' => 'col-md-6',
									//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
									'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
									'theme_location'  => 'footer-menu',
									'items_wrap'      => '<ul class="menu nav justify-content-end text-end">%3$s</ul>',
								)
							);
						endif;

						
					?>
					</div>
						<div class="col-md-12">
							<?php
								dynamic_sidebar( 'footer_widget_02' );

								if ( current_user_can( 'manage_options' ) ) :
							?>
								<span class="edit-link"><a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" class="badge bg-secondary"><?php esc_html_e( 'Edit', 'dsbs502' ); ?></a></span><!-- Show Edit Widget link -->
							<?php
								endif;
							?>
						</div>
					
				</div><!-- /.row -->
				<div class="row">
				<p class="text-end"><?php printf( esc_html__( '&copy; %1$s %2$s.', 'dsbs502' ), wp_date( 'Y' ), get_bloginfo( 'name', 'display' ) ); ?></p>
				</div>
			</div><!-- /.container -->
		</footer><!-- /#footer -->
	</div><!-- /#wrapper -->
	<!-- <img src="./wp-content/uploads/2024/05/bg-footer.jpg" alt="" style="position: absolute; z-index:-1; object-fit:cover;"> -->
	<?php
		wp_footer();
	?>
</body>
</html>
