<?php
/**
 * Sidebar Template.
 */

if ( is_active_sidebar( 'primary_widget_area' ) || is_archive() || is_single() ) :
?>
<!-- <div id="sidebar" class="col-md-3 order-md-first col-sm-12 order-sm-last"> -->
<div id="sidebar" class="col-lg-3 pt-5">
	<?php
		if ( is_active_sidebar( 'primary_widget_area' ) ) :
	?>
		<div id="widget-area" class="widget-area" role="complementary">
			<?php
				dynamic_sidebar( 'primary_widget_area' );

				if ( current_user_can( 'manage_options' ) ) :
			?>
				<span class="edit-link"><a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" class="badge bg-secondary"><?php esc_html_e( 'Edit', 'dsbs502' ); ?></a></span><!-- Show Edit Widget link -->
			<?php
				endif;
			?>
		</div><!-- /.widget-area -->
	<?php
		endif;

		if ( is_archive() || is_single() ) :
	?>
		<div class="bg-faded sidebar-nav">
			<div id="primary-two" class="widget-area">
				<?php
					$output = '<ul class="recentposts">';
						$recentposts_query = new WP_Query( array( 'posts_per_page' => 5 ) ); // Max. 5 posts in Sidebar!
						$month_check = null;
						if ( $recentposts_query->have_posts() ) :
							$output .= '<li><h3>' . pll__('Más Noticias') . '</h3></li>';
							while ( $recentposts_query->have_posts() ) :
								$recentposts_query->the_post();
								$output .= '<li>';
									// Show monthly archive and link to months.
									$month = get_the_date( 'F, Y' );
									if ( $month !== $month_check ) :
										$output .= '<a class="fecha-noticia-sidebar" href="' . esc_url( get_month_link( get_the_date( 'Y' ), get_the_date( 'm' ) ) ) . '" title="' . esc_attr( get_the_date( 'F, Y' ) ) . '">' . esc_html( $month ) . '</a>';
									endif;
									$month_check = $month;
								//	$the_excerpt = the_excerpt();

								$output .= '<h4><a href="' . esc_url( get_the_permalink() ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'dsbs502' ), the_title_attribute( array( 'echo' => false ) ) ) . '" rel="bookmark">' . esc_html( get_the_title() ) . '</a></h4>';
								//$output .= '<p>' . esc_html($the_excerpt) . '</p>';
								$output .= '</li>';
							endwhile;
						endif;
						wp_reset_postdata();
					$output .= '</ul>';

					echo $output;
				?>
				<!-- <br />
				<ul class="categories">
					<li><h3><?php echo pll__('Categorías');?></h3></li>
					<?php
						wp_list_categories( array( 'title_li' => '' ) );

						if ( ! is_author() ) :
					?>
							<li>&nbsp;</li>
							<li><a href="<?php the_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn btn-outline-secondary"><?php esc_html_e( 'more', 'dsbs502' ); ?></a></li>
					<?php
						endif;
					?>
				</ul> -->
			</div><!-- /#primary-two -->
		</div>
	<?php
		endif;
	?>
</div><!-- /#sidebar -->
<?php
	endif;
?>
