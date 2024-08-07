<?php

/**
 * Include Theme Customizer.
 *
 * @since v1.0
 */
$theme_customizer = __DIR__ . '/inc/customizer.php';
if ( is_readable( $theme_customizer ) ) {
	require_once $theme_customizer;
}

if ( ! function_exists( 'dsbs502_setup_theme' ) ) {
	/**
	 * General Theme Settings.
	 *
	 * @since v1.0
	 *
	 * @return void
	 */
	function dsbs502_setup_theme() {
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'dsbs502', __DIR__ . '/languages' );

		/**
		 * Set the content width based on the theme's design and stylesheet.
		 *
		 * @since v1.0
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 800;
		}

		// Theme Support.
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'evento-list-item-thumb',555,416, true);
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for full and wide alignment.
		add_theme_support( 'align-wide' );
		// Add support for Editor Styles.
		add_theme_support( 'editor-styles' );
		// Enqueue Editor Styles.
		add_editor_style( 'style-editor.css' );

		// Default attachment display settings.
		update_option( 'image_default_align', 'none' );
		update_option( 'image_default_link_type', 'none' );
		update_option( 'image_default_size', 'large' );

		// Custom CSS styles of WorPress gallery.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
	add_action( 'after_setup_theme', 'dsbs502_setup_theme' );

	/**
	 * Enqueue editor stylesheet (for iframed Post Editor):
	 * https://make.wordpress.org/core/2023/07/18/miscellaneous-editor-changes-in-wordpress-6-3/#post-editor-iframed
	 *
	 * @since v3.5.1
	 *
	 * @return void
	 */
	function dsbs502_load_editor_styles() {
		if ( is_admin() ) {
			wp_enqueue_style( 'editor-style', get_theme_file_uri( 'style-editor.css' ) );
		}
	}
	add_action( 'enqueue_block_assets', 'dsbs502_load_editor_styles' );

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since v2.2
	 *
	 * @return void
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if ( ! function_exists( 'dsbs502_add_user_fields' ) ) {
	/**
	 * Add new User fields to Userprofile:
	 * get_user_meta( $user->ID, 'facebook_profile', true );
	 *
	 * @since v1.0
	 *
	 * @param array $fields User fields.
	 *
	 * @return array
	 */
	function dsbs502_add_user_fields( $fields ) {
		// Add new fields.
		$fields['facebook_profile'] = 'Facebook URL';
		$fields['twitter_profile']  = 'Twitter URL';
		$fields['linkedin_profile'] = 'LinkedIn URL';
		$fields['xing_profile']     = 'Xing URL';
		$fields['github_profile']   = 'GitHub URL';

		return $fields;
	}
	add_filter( 'user_contactmethods', 'dsbs502_add_user_fields' );
}

/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 *
 * @global WP_Post $post Global post object.
 *
 * @return bool
 */
function is_blog() {
	global $post;
	$posttype = get_post_type( $post );

	return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || ( is_tag() && ( 'post' === $posttype ) ) ) ? true : false );
}

/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 *
 * @param bool $open    Comments open/closed.
 * @param int  $post_id Post ID.
 *
 * @return bool
 */
function dsbs502_filter_media_comment_status( $open, $post_id = null ) {
	$media_post = get_post( $post_id );

	if ( 'attachment' === $media_post->post_type ) {
		return false;
	}

	return $open;
}
add_filter( 'comments_open', 'dsbs502_filter_media_comment_status', 10, 2 );

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Post Edit Link.
 *
 * @return string
 */
function dsbs502_custom_edit_post_link( $link ) {
	return str_replace( 'class="post-edit-link"', 'class="post-edit-link badge bg-secondary"', $link );
}
add_filter( 'edit_post_link', 'dsbs502_custom_edit_post_link' );

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Comment Edit Link.
 */
function dsbs502_custom_edit_comment_link( $link ) {
	return str_replace( 'class="comment-edit-link"', 'class="comment-edit-link badge bg-secondary"', $link );
}
add_filter( 'edit_comment_link', 'dsbs502_custom_edit_comment_link' );

/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 *
 * @param string $html Inner HTML.
 *
 * @return string
 */
function dsbs502_oembed_filter( $html ) {
	return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'dsbs502_oembed_filter', 10 );

if ( ! function_exists( 'dsbs502_content_nav' ) ) {
	/**
	 * Display a navigation to next/previous pages when applicable.
	 *
	 * @since v1.0
	 *
	 * @param string $nav_id Navigation ID.
	 */
	function dsbs502_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			?>
			<div id="<?php echo esc_attr( $nav_id ); ?>" class="d-flex mb-4 justify-content-between">
				<div><?php next_posts_link( '<span aria-hidden="true">&larr;</span> ' . esc_html__( 'Older posts', 'dsbs502' ) ); ?></div>
				<div><?php previous_posts_link( esc_html__( 'Newer posts', 'dsbs502' ) . ' <span aria-hidden="true">&rarr;</span>' ); ?></div>
			</div><!-- /.d-flex -->
			<?php
		} else {
			echo '<div class="clearfix"></div>';
		}
	}

	/**
	 * Add Class.
	 *
	 * @since v1.0
	 *
	 * @return string
	 */
	function posts_link_attributes() {
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
	add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );
}

/**
 * Init Widget areas in Sidebar.
 *
 * @since v1.0
 *
 * @return void
 */
function dsbs502_widgets_init() {
	// Area 1.
	register_sidebar(
		array(
			'name'          => 'Primary Widget Area (Sidebar)',
			'id'            => 'primary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

// Area 2
register_sidebar(
	array(
		'name'          => 'DS Sidebar',
		'id'            => 'ds_sidebar',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	)
);


	// Area 3.
	register_sidebar(
		array(
			'name'          => 'Header Widget 01 (Header 01)',
			'id'            => 'header_widget_01',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	

	// Area 4.
	/*register_sidebar(
		array(
			'name'          => 'Header Widget 02 (Header Right)',
			'id'            => 'header_widget_02',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);*/

	// Area 5.
	register_sidebar(
		array(
			'name'          => 'Footer Widget 01',
			'id'            => 'footer_widget_01',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
		// Area 6.
		register_sidebar(
			array(
				'name'          => 'Footer Widget 02',
				'id'            => 'footer_widget_02',
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
}
add_action( 'widgets_init', 'dsbs502_widgets_init' );

if ( ! function_exists( 'dsbs502_article_posted_on' ) ) {
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function dsbs502_article_posted_on() {
		printf(
			wp_kses_post( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'dsbs502' ) ),
			esc_url( get_the_permalink() ),
			esc_attr( get_the_date() . ' - ' . get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' - ' . get_the_time() ),
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'dsbs502' ), get_the_author() ),
			get_the_author()
		);
	}
}

/**
 * Template for Password protected post form.
 *
 * @since v1.0
 *
 * @global WP_Post $post Global post object.
 *
 * @return string
 */
function dsbs502_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );

	$output                  = '<div class="row">';
		$output             .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
		$output             .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__( 'This content is password protected. To view it please enter your password below.', 'dsbs502' ) . '</h4>';
			$output         .= '<div class="col-md-6">';
				$output     .= '<div class="input-group">';
					$output .= '<input type="password" name="post_password" id="' . esc_attr( $label ) . '" placeholder="' . esc_attr__( 'Password', 'dsbs502' ) . '" class="form-control" />';
					$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__( 'Submit', 'dsbs502' ) . '" /></div>';
				$output     .= '</div><!-- /.input-group -->';
			$output         .= '</div><!-- /.col -->';
		$output             .= '</form>';
	$output                 .= '</div><!-- /.row -->';

	return $output;
}
add_filter( 'the_password_form', 'dsbs502_password_form' );


if ( ! function_exists( 'dsbs502_comment' ) ) {
	/**
	 * Style Reply link.
	 *
	 * @since v1.0
	 *
	 * @param string $class Link class.
	 *
	 * @return string
	 */
	function dsbs502_replace_reply_link_class( $class ) {
		return str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class );
	}
	add_filter( 'comment_reply_link', 'dsbs502_replace_reply_link_class' );

	/**
	 * Template for comments and pingbacks:
	 * add function to comments.php ... wp_list_comments( array( 'callback' => 'dsbs502_comment' ) );
	 *
	 * @since v1.0
	 *
	 * @param object $comment Comment object.
	 * @param array  $args    Comment args.
	 * @param int    $depth   Comment depth.
	 */
	function dsbs502_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				?>
		<li class="post pingback">
			<p>
				<?php
					esc_html_e( 'Pingback:', 'dsbs502' );
					comment_author_link();
					edit_comment_link( esc_html__( 'Edit', 'dsbs502' ), '<span class="edit-link">', '</span>' );
				?>
			</p>
				<?php
				break;
			default:
				?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
							$avatar_size = ( '0' !== $comment->comment_parent ? 68 : 136 );
							echo get_avatar( $comment, $avatar_size );

							/* Translators: 1: Comment author, 2: Date and time */
							printf(
								wp_kses_post( __( '%1$s, %2$s', 'dsbs502' ) ),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf(
									'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* Translators: 1: Date, 2: Time */
									sprintf( esc_html__( '%1$s ago', 'dsbs502' ), human_time_diff( (int) get_comment_time( 'U' ), current_time( 'timestamp' ) ) )
								)
							);

							edit_comment_link( esc_html__( 'Edit', 'dsbs502' ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-author .vcard -->

					<?php if ( '0' === $comment->comment_approved ) { ?>
						<em class="comment-awaiting-moderation">
							<?php esc_html_e( 'Your comment is awaiting moderation.', 'dsbs502' ); ?>
						</em>
						<br />
					<?php } ?>
				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => esc_html__( 'Reply', 'dsbs502' ) . ' <span>&darr;</span>',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								)
							)
						);
					?>
				</div><!-- /.reply -->
			</article><!-- /#comment-## -->
				<?php
				break;
		endswitch;
	}

	/**
	 * Custom Comment form.
	 *
	 * @since v1.0
	 * @since v1.1: Added 'submit_button' and 'submit_field'
	 * @since v2.0.2: Added '$consent' and 'cookies'
	 *
	 * @param array $args    Form args.
	 * @param int   $post_id Post ID.
	 *
	 * @return array
	 */
	function dsbs502_custom_commentform( $args = array(), $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}

		$commenter     = wp_get_current_commenter();
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args( $args );

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true' required" : '' );
		$consent  = ( empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"' );
		$fields   = array(
			'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_html__( 'Name', 'dsbs502' ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="author">' . esc_html__( 'Name', 'dsbs502' ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_html__( 'Email', 'dsbs502' ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="email">' . esc_html__( 'Email', 'dsbs502' ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'url'     => '',
			'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'dsbs502' ) . '</label>
						</p>',
		);

		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__( 'Comment', 'dsbs502' ) . ( $req ? '*' : '' ) . '"></textarea>
											<label for="comment">' . esc_html__( 'Comment', 'dsbs502' ) . '</label>
										</div>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf( wp_kses_post( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'dsbs502' ) ), wp_login_url( esc_url( get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses_post( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'dsbs502' ) ), get_edit_user_link(), $user->display_name, wp_logout_url( apply_filters( 'the_permalink', esc_url( get_the_permalink( get_the_ID() ) ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="small comment-notes">' . esc_html__( 'Your Email address will not be published.', 'dsbs502' ) . '</p>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_submit'         => 'btn btn-primary',
			'name_submit'          => 'submit',
			'title_reply'          => '',
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'dsbs502' ),
			'cancel_reply_link'    => esc_html__( 'Cancel reply', 'dsbs502' ),
			'label_submit'         => esc_html__( 'Post Comment', 'dsbs502' ),
			'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'format'               => 'html5',
		);

		return $defaults;
	}
	add_filter( 'comment_form_defaults', 'dsbs502_custom_commentform' );
}

if ( function_exists( 'register_nav_menus' ) ) {
	/**
	 * Nav menus.
	 *
	 * @since v1.0
	 *
	 * @return void
	 */
	register_nav_menus(
		array(
			'main-menu'   => 'Main Navigation Menu',
			'footer-menu' => 'Footer Menu',
			'mercado-menu' => 'Mercado Menu',
			'planta-baja-menu' => 'Planta Baja Menu',
			'planta-sup-menu' => 'Planta Sup Menu',
		)
	);
}

// Custom Nav Walker: wp_bootstrap_navwalker().
$custom_walker = __DIR__ . '/inc/wp-bootstrap-navwalker.php';
if ( is_readable( $custom_walker ) ) {
	require_once $custom_walker;
}

$custom_walker_footer = __DIR__ . '/inc/wp-bootstrap-navwalker-footer.php';
if ( is_readable( $custom_walker_footer ) ) {
	require_once $custom_walker_footer;
}

$custom_walker_puestos = __DIR__ . '/inc/wp-bootstrap-navwalker-puestos.php';
if ( is_readable( $custom_walker_puestos ) ) {
	require_once $custom_walker_puestos;
}



/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 *
 * @return void
 */
function dsbs502_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 1. Styles.
	wp_enqueue_style( 'style', get_theme_file_uri( 'style.css' ), array(), $theme_version, 'all' );
	wp_enqueue_style( 'main', get_theme_file_uri( 'build/main.css' ), array(), $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles.
	wp_enqueue_style( 'InterFont', 'https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap', array(), $theme_version, 'all' );
	wp_enqueue_style( 'md-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $theme_version, 'all' );

	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl', get_theme_file_uri( 'build/rtl.css' ), array(), $theme_version, 'all' );
	}

	// 2. Scripts.
	//wp_enqueue_script( 'headroomjs', get_theme_file_uri( 'build/headroom.js' ), array(), $theme_version, true );
	wp_enqueue_script( 'hr_js', get_theme_file_uri( 'jsds/headroom.min.js' ), array(), $theme_version, true );

	
//wp_enqueue_script( 'planos_js02', get_theme_file_uri( 'jsds/jquery.rwdImageMaps.js' ), array(), $theme_version, true );
//wp_enqueue_script( 'sc_js', get_theme_file_uri( 'jsds/scripts.js' ), array(), $theme_version, true );
wp_enqueue_script( 'maphilight_js', get_theme_file_uri( 'jsds/jquery.maphilight.min.js' ), array(), $theme_version, true );
wp_enqueue_script( 'planos_js03', get_theme_file_uri( 'jsds/jquery.rwdImageMaps.min.js' ), array(), $theme_version, true );
	wp_enqueue_script( 'mapas_js', get_theme_file_uri( 'jsds/mapas.js' ), array(), $theme_version, true );
	


	
	
	
	
	

	wp_enqueue_script( 'mainjs', get_theme_file_uri( 'build/main.js' ), array(), $theme_version, true );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dsbs502_scripts_loader' );


function admin_style() {
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/admin/admin.css');
  }
  add_action('admin_enqueue_scripts', 'admin_style');

  function new_excerpt_length($length) {

	return 20;
	
	}
	
	add_filter('excerpt_length', 'new_excerpt_length');


	/*para Woocommerce */
	

function my_theme_setup() {
    //add_theme_support( 'woocommerce' );
	add_theme_support( 'woocommerce', array(
	//	'thumbnail_image_width' => 554,		
		//'gallery_thumbnail_image_width' => 100,
		//'single_image_width' => 500,
	) );
	
		
}
add_action( 'after_setup_theme', 'my_theme_setup' ); 


/*Compatibilidad con Bootstrap */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function my_before_main_content() {
    echo '<!-- Starting content wrapper for your theme -->';
    echo '<div class="container"><div class="row"><div class="col-sm-12">';
}
add_action( 'woocommerce_before_main_content', 'my_before_main_content' );

function my_after_main_content() {
    echo '</div></div></div>';
    echo '<!-- Ending content wrapper for your theme -->';
}
add_action( 'woocommerce_after_main_content', 'my_after_main_content' );


add_filter( 'woocommerce_template_loop_product_thumbnail', function( $size ) {
    return array(
        'width' => 554,
        'height' => 416,
        'crop' => 1,
    );
} );




// Eliminar los CSS de WooCommerce uno por uno
/*add_filter( 'woocommerce_enqueue_styles', 'woocommerce_dequeue_styles' );
function woocommerce_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}*/

// Eliminar todos los CSS de WooCommerce de golpe
//add_filter( 'woocommerce_enqueue_styles', '__return_false' );


// Deshabilitar comentarios WP
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});




/*Custom Posts*/
/*  Sliders */
// La función no será utilizada antes del 'init'.
add_action( 'init', 'crear_post_type_slider' );
/* Here's how to create your customized labels */
function crear_post_type_slider() {
    $labels = array(
    'name' => _x( 'SLIDER', 'post type general name' ),
        'singular_name' => _x( 'Slider', 'post type singular name' ),
        'add_new' => _x( 'Añadir nuevo', 'slider' ),
        'add_new_item' => __( 'Añadir nuevo Slider' ),
        'edit_item' => __( 'Editar Slider' ),
        'new_item' => __( 'Nuevo Slider' ),
        'view_item' => __( 'Ver Slider' ),
        'search_items' => __( 'Buscar Sliders' ),
        'not_found' =>  __( 'No se han encontrado Sliders' ),
        'not_found_in_trash' => __( 'No se han encontrado Sliders en la papelera' ),
        'parent_item_colon' => ''
    );
 
    // Creamos un array para $args
    $args = array( 'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-slides',
        'supports' => array( 'title', 'editor', 'thumbnail' )
    );
 
    register_post_type( 'slider', $args ); /* Registramos y a funcionar */
}
/*Fin SLIDERS*/
/*columnas slider wpadmin*/
/*cargarlos*/
 // adding our table columns with this function:  
function slider_custom_table_head( $defaults ) {  
    $defaults['orden']   = 'Orden';  
    return $defaults;  
}  
// change the _event_ part in the filter name to your CPT slug  
add_filter('manage_slider_posts_columns', 'slider_custom_table_head');  
  
  
// now let's fill our new columns with post meta content  
function slider_custom_table_content( $column_name, $post_id ) {  
    if ($column_name == 'orden') { 
        echo get_post_meta( $post_id, 'meta-box-slider-orden', true ); 
    } 
} 
// change the _event_ part in the filter name to your CPT slug 
add_action( 'manage_slider_posts_custom_column', 'slider_custom_table_content', 10, 2 );  

/*ORDENARLOS FILTRO*/
add_filter( 'manage_edit-slider_sortable_columns', 'my_slider_sortable_columns' );

function my_slider_sortable_columns( $columns ) {

    $columns['orden'] = 'orden';

    return $columns;
}

/**/
/*Meta BOXES*/
/*Propiedades Sliders*/
/*1*/

function add_custom_meta_box_slider()
{
    add_meta_box("slider-meta-box", "Propiedades slider", "custom_meta_box_slider_markup", "slider", "side", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box_slider");

/*2*/
function custom_meta_box_slider_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>
<div>    
    <!--<label for="meta-box-slider-video">¿Vídeo?</label>
    <input name="meta-box-slider-video" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-video", true); ?>">
    <br />-->
    <label for="meta-box-slider-subtitu">Subititular</label>
    <input name="meta-box-slider-subtitu" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-subtitu", true); ?>">
    <br />
    <label for="meta-box-slider-texto-bt-01">Texto Botón 01</label>
    <input name="meta-box-slider-texto-bt-01" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-texto-bt-01", true); ?>">
    <br />
    <label for="meta-box-slider-url-bt-01">URL Botón 01</label>
    <input name="meta-box-slider-url-bt-01" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-url-bt-01", true); ?>">
    <br />
    <label for="meta-box-slider-texto-bt-02">Texto Botón 02</label>
    <input name="meta-box-slider-texto-bt-02" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-texto-bt-02", true); ?>">
    <br />
    <label for="meta-box-slider-url-bt-02">URL Botón 02</label>
    <input name="meta-box-slider-url-bt-02" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-url-bt-02", true); ?>">
    <br />
    <label for="meta_box_slider_fondo">Fondo</label>
    <select name="meta_box_slider_fondo" id="meta_box_slider_fondo">
        <?php $color_fondo = get_post_meta( get_the_ID(), 'meta_box_slider_fondo', true );?>
            <option value="blanco" <?php if ($color_fondo == "blanco")  echo 'selected'; ?>>Blanco</option>                        
			<option value="oscuro" <?php if ($color_fondo == "oscuro")  echo 'selected'; ?>>Oscuro</option>            
        </select>
    <br />
    <label for="meta-box-slider-orden">Orden</label>
    <input name="meta-box-slider-orden" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-slider-orden", true); ?>">
</div>
<?php  
}

/*3*/
function save_custom_meta_box_slider($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "slider";
    if($slug != $post->post_type)
        return $post_id;
        $meta_box_slider_video = "";
        $meta_box_slider_subtitu = "";
        $meta_box_slider_texto_bt_01 = "";
        $meta_box_slider_url_bt_01 = "";
        $meta_box_slider_texto_bt_02 = "";
        $meta_box_slider_url_bt_02 = ""; 
        $selected = isset( $values['meta_box_slider_fondo'] ) ? esc_attr( $values['meta_box_slider_fondo'][0] ) : '';   
        $meta_box_slider_orden_value = "";

    if(isset($_POST["meta-box-slider-video"]))
    {
        $meta_box_slider_video = $_POST["meta-box-slider-video"];
    }   
    update_post_meta($post_id, "meta-box-slider-video", $meta_box_slider_video);

    if(isset($_POST["meta-box-slider-subtitu"]))
    {
        $meta_box_slider_subtitu = $_POST["meta-box-slider-subtitu"];
    }   
    update_post_meta($post_id, "meta-box-slider-subtitu", $meta_box_slider_subtitu);

    if(isset($_POST["meta-box-slider-texto-bt-01"]))
    {
        $meta_box_slider_texto_bt_01 = $_POST["meta-box-slider-texto-bt-01"];
    }   
    update_post_meta($post_id, "meta-box-slider-texto-bt-01", $meta_box_slider_texto_bt_01);

    if(isset($_POST["meta-box-slider-url-bt-01"]))
    {
        $meta_box_slider_url_bt_01 = $_POST["meta-box-slider-url-bt-01"];
    }   
    update_post_meta($post_id, "meta-box-slider-url-bt-01", $meta_box_slider_url_bt_01);

    if(isset($_POST["meta-box-slider-texto-bt-02"]))
    {
        $meta_box_slider_texto_bt_02 = $_POST["meta-box-slider-texto-bt-02"];
    }   
    update_post_meta($post_id, "meta-box-slider-texto-bt-02", $meta_box_slider_texto_bt_02);

    if(isset($_POST["meta-box-slider-url-bt-02"]))
    {
        $meta_box_slider_url_bt_02 = $_POST["meta-box-slider-url-bt-02"];
    }   
    update_post_meta($post_id, "meta-box-slider-url-bt-02", $meta_box_slider_url_bt_02);
    
    if( isset( $_POST['meta_box_slider_fondo'] ) )
        update_post_meta( $post_id, "meta_box_slider_fondo", esc_attr( $_POST['meta_box_slider_fondo'] ) );

     if(isset($_POST["meta-box-slider-orden"]))
    {
        $meta_box_slider_orden_value = $_POST["meta-box-slider-orden"];
    }   
    update_post_meta($post_id, "meta-box-slider-orden", $meta_box_slider_orden_value);
}

add_action("save_post", "save_custom_meta_box_slider", 10, 3);

/*Fin MetaBoxes Sliders*/



/*  Puestos */
// La función no será utilizada antes del 'init'.
add_action( 'init', 'crear_post_type_puesto' );
/* Here's how to create your customized labels */
function crear_post_type_puesto() {
    $labels = array(
    'name' => _x( 'Puestos', 'post type general name' ),
        'singular_name' => _x( 'Puesto', 'post type singular name' ),
        'add_new' => _x( 'Añadir nuevo', 'puesto' ),
        'add_new_item' => __( 'Añadir nuevo puesto' ),
        'edit_item' => __( 'Editar puesto' ),
        'new_item' => __( 'Nuevo puesto' ),
        'view_item' => __( 'Ver puesto' ),
        'search_items' => __( 'Buscar puestos' ),
        'not_found' =>  __( 'No se han encontrado puestos' ),
        'not_found_in_trash' => __( 'No se han encontrado puestos en la papelera' ),
        'parent_item_colon' => ''
    );
 
    // Creamos un array para $args
    $args = array( 'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            //'slug'       => strtolower(pll__('Puestos')),
            'slug'       => 'puestos',
            'with_front' => false,
        ),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-admin-multisite',
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'show_in_rest' => true,
		'has_archive' => false,
    );
 
    register_post_type( 'puesto', $args ); /* Registramos y a funcionar */
}
/*Fin post type puestos*/

// Lo enganchamos en la acción init y llamamos a la función create_proyecto_taxonomies() cuando arranque
add_action( 'init', 'create_puesto_taxonomies', 0 );
 
// Creamos dos taxonomías, Tipo Puesto y Tag para el custom post type "puesto"
function create_puesto_taxonomies() {
    // Añadimos nueva taxonomía y la hacemos jerárquica (como las categorías por defecto)
    $labels = array(
    'name' => _x( 'Plantas', 'taxonomy general name' ),
    'singular_name' => _x( 'Planta de Puesto', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar por Planta de Puesto' ),
    'all_items' => __( 'Todos las Plantas de Puesto' ),
    'parent_item' => __( 'Tipo Puesto padre' ),
    'parent_item_colon' => __( 'Planta de Puesto padre:' ),
    'edit_item' => __( 'Editar Planta de Puesto' ),
    'update_item' => __( 'Actualizar Planta de Puesto' ),
    'add_new_item' => __( 'Añadir nueva Planta de Puesto' ),
    'new_item_name' => __( 'Nombre del nueva Planta de Puesto' ),
	
);
register_taxonomy( 'plantas-puesto', array( 'puesto' ), array(
    'hierarchical' => true,
    'labels' => $labels, /* ADVERTENCIA: Aquí es donde se utiliza la variable $labels */
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'planta-puesto' ),
	'show_in_rest' => true,
));

$labels = array(
    'name' => _x( 'Gremios', 'taxonomy general name' ),
    'singular_name' => _x( 'Gremio de Puesto', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar por Gremio de Puesto' ),
    'all_items' => __( 'Todos los Gremios de Puesto' ),
    'parent_item' => __( 'Tipo Puesto padre' ),
    'parent_item_colon' => __( 'Gremio de Puesto padre:' ),
    'edit_item' => __( 'Editar Gremio de Puesto' ),
    'update_item' => __( 'Actualizar Gremio de Puesto' ),
    'add_new_item' => __( 'Añadir nuevo Gremio de Puesto' ),
    'new_item_name' => __( 'Nombre del nuevo Gremio de Puesto' ),
	
);
register_taxonomy( 'gremios-puesto', array( 'puesto' ), array(
    'hierarchical' => true,
    'labels' => $labels, /* ADVERTENCIA: Aquí es donde se utiliza la variable $labels */
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gremio-puesto' ),
	'show_in_rest' => true,
));

} // Fin de la función create_puesto_taxonomies().

/*columnas testim wpadmin*/
/*cargarlos*/
 // adding our table columns with this function:  
function puesto_custom_table_head( $defaults ) {  
    $defaults['thumbnail']   = 'Imagen'; 
    $defaults['orden']   = 'Orden';  
    return $defaults;  
}  
// change the _event_ part in the filter name to your CPT slug  
add_filter('manage_puesto_posts_columns', 'puesto_custom_table_head');  
  
  
// now let's fill our new columns with post meta content  
function puesto_custom_table_content( $column_name, $post_id ) {  
    if ($column_name == 'thumbnail') {  echo get_the_post_thumbnail( $post_id, array(80, 80) );
        
    } 
    if ($column_name == 'orden') { 
        echo get_post_meta( $post_id, 'meta-box-puesto-orden', true ); 
    } 
} 
// change the _event_ part in the filter name to your CPT slug 
add_action( 'manage_puesto_posts_custom_column', 'puesto_custom_table_content', 10, 2 );  

/*ORDENARLOS FILTRO*/
add_filter( 'manage_edit-puesto_sortable_columns', 'my_puesto_sortable_columns' );

function my_puesto_sortable_columns( $columns ) {
    $defaults['thumbnail']   = 'Imagen'; 
    $columns['orden'] = 'orden';

    return $columns;    
}



/*Propiedades puestos*/
/*1*/

function add_puesto_meta_box()
{
    add_meta_box("puesto-meta-box", "Propiedades puesto", "puesto_meta_box_markup", "puesto", "normal", "high", null);
}

add_action("add_meta_boxes", "add_puesto_meta_box");
/*2*/
function puesto_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>

        <div class="metaboxes-en-linea d-flex">         
            <div>
                <label for="meta-box-puesto-numpuesto">Número de puesto </label>                            
				<input name="meta-box-puesto-numpuesto" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-puesto-numpuesto", true); ?>" />
            </div>
            <div>
                <label for="meta-box-puesto-telefono">Teléfono</label>            
                <input name="meta-box-puesto-telefono" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-puesto-telefono", true); ?>" />
            </div>
            
            <div>
                <label for="meta-box-puesto-movil">Móvil</label>            
                <input name="meta-box-puesto-movil" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-puesto-movil", true); ?>" />
            </div>                                             
			<div>

                <label for="meta-box-puesto-correoe">Correo electrónico</label>            
                <input name="meta-box-puesto-correoe" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-puesto-correoe", true); ?>" />
            </div>   

			<div>
                <label for="meta-box-puesto-web">Web</label>            
                <input type="text" name="meta-box-puesto-web" value="<?php echo get_post_meta($object->ID, "meta-box-puesto-web", true); ?>" />
            </div>   
            
            <!-- <div>
                <label for="meta-box-puesto-rrss">RRSS</label>            
                <textarea rows="3" cols="27" name="meta-box-puesto-rrss"><?php echo get_post_meta($object->ID, "meta-box-puesto-rrss", true); ?></textarea>
            </div> -->

			<!--<div>
                <label for="meta-box-puesto-tarjetacomercio">Tarjeta comercio de Álava </label>            
                <textarea rows="4" cols="27" name="meta-box-puesto-tarjetacomercio"><?php echo get_post_meta($object->ID, "meta-box-puesto-tarjetacomercio", true); ?></textarea>
            </div>   -->

			<div>
				<label for="meta-box-puesto-tarjetacomercio">Tarjeta comercio de Álava </label>
				<select name="meta-box-puesto-tarjetacomercio" id="meta-box-puesto-tarjetacomercio" placeholder="Selecciona">
				<?php $tarjeta_comercio = get_post_meta( get_the_ID(), 'meta-box-puesto-tarjetacomercio', true );?>
				 <option value="Selecciona" disabled>Selecciona</option>
					<option value="Sí" <?php if ($tarjeta_comercio == "si")  echo 'selected'; ?>>Sí</option>
					<option value="No" <?php if ($tarjeta_comercio == "no")  echo 'selected'; ?>>No</option>
				</select>
			</div>

			<div>
                <label for="meta-box-puesto-especialidad">Especialidad </label>            
                <textarea rows="4" cols="27" name="meta-box-puesto-especialidad"><?php echo get_post_meta($object->ID, "meta-box-puesto-especialidad", true); ?></textarea>
            </div>   
            
            <div class="meta-box-puesto-orden">
                <label for="meta-box-puesto-orden">Orden</label>
                <input name="meta-box-puesto-orden" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-puesto-orden", true); ?>">
            </div>
            

        </div>

    <?php  
}

/*3*/
function save_puesto_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "puesto";
    if($slug != $post->post_type)
        return $post_id;
    
    $meta_box_puesto_numpuesto_value = "";      
    $meta_box_puesto_telefono_value = "";       
    $meta_box_puesto_movil_value = "";      
    $meta_box_puesto_correoe_value = "";
	$meta_box_puesto_web_value = "";
	$meta_box_puesto_rrss_value = "";
	$meta_box_puesto_tarjetacomercio_value = "";
	$meta_box_puesto_especialidad_value = "";
    $meta_box_puesto_orden_value = "";
         
    

    if(isset($_POST["meta-box-puesto-numpuesto"]))
    {
        $meta_box_puesto_numpuesto_value = $_POST["meta-box-puesto-numpuesto"];
    }   
    update_post_meta($post_id, "meta-box-puesto-numpuesto", $meta_box_puesto_numpuesto_value);
	

    if(isset($_POST["meta-box-puesto-telefono"]))
    {
        $meta_box_puesto_telefono_value = $_POST["meta-box-puesto-telefono"];
    }   
    update_post_meta($post_id, "meta-box-puesto-telefono", $meta_box_puesto_telefono_value);
    
    
    if(isset($_POST["meta-box-puesto-movil"]))
    {
        $meta_box_puesto_movil_value = $_POST["meta-box-puesto-movil"];
    }   
    update_post_meta($post_id, "meta-box-puesto-movil", $meta_box_puesto_movil_value);


	if(isset($_POST["meta-box-puesto-correoe"]))
    {
        $meta_box_puesto_correoe_value = $_POST["meta-box-puesto-correoe"];
    }   
    update_post_meta($post_id, "meta-box-puesto-correoe", $meta_box_puesto_correoe_value);

	if(isset($_POST["meta-box-puesto-web"]))
    {
        $meta_box_puesto_web_value = $_POST["meta-box-puesto-web"];
    }   
    update_post_meta($post_id, "meta-box-puesto-web", $meta_box_puesto_web_value);

    
    if(isset($_POST["meta-box-puesto-rrss"]))
    {
        $meta_box_puesto_rrss_value = $_POST["meta-box-puesto-rrss"];
    }   
    update_post_meta($post_id, "meta-box-puesto-rrss", $meta_box_puesto_rrss_value);

	
	if(isset($_POST["meta-box-puesto-tarjetacomercio"]))
    {
        $meta_box_puesto_tarjetacomercio_value = $_POST["meta-box-puesto-tarjetacomercio"];
    }   
    update_post_meta($post_id, "meta-box-puesto-tarjetacomercio", $meta_box_puesto_tarjetacomercio_value);


	if(isset($_POST["meta-box-puesto-especialidad"]))
    {
        $meta_box_puesto_especialidad_value = $_POST["meta-box-puesto-especialidad"];
    }   
    update_post_meta($post_id, "meta-box-puesto-especialidad", $meta_box_puesto_especialidad_value);

        
    if(isset($_POST["meta-box-puesto-orden"]))
    {
        $meta_box_puesto_orden_value = $_POST["meta-box-puesto-orden"];
    }   
    update_post_meta($post_id, "meta-box-puesto-orden", $meta_box_puesto_orden_value);

     
}

add_action("save_post", "save_puesto_meta_box", 10, 3);

/*Fin MetaBoxes puestos*/




/**/


/*Metaboxes Woomcomerce */
//add_meta_box("puesto-meta-box", "Propiedades puesto", "puesto_meta_box_markup", "puesto", "normal", "high", null);
function add_evento_meta_box() {
	add_meta_box(
		'evento_metabox', // Unique ID
		'Propiedades del evento',    // Meta Box title
		'metabox_evento_fecha',    // Callback function
		'product',                         // The selected post type
		"normal",
		"high", 
		null,
	);
}

add_action( 'add_meta_boxes', 'add_evento_meta_box' );

function metabox_evento_fecha( $post ) {

	$evento_fecha = get_post_meta( $post->ID, '_evento_fecha_meta_key', true );

	$evento_hora = get_post_meta( $post->ID, '_evento_hora_meta_key', true );

	$evento_lugar = get_post_meta( $post->ID, '_evento_lugar_meta_key', true );

	?>
<div class="metaboxes-en-linea d-flex">         
	<div>
		<label for="evento_fecha">Fecha del evento</label>
		<input name="evento_fecha" type="date" value="<?php echo esc_attr($evento_fecha); ?>">
	</div>

	<div>
		<label for="evento_hora">Hora del evento</label>
		<input name="evento_hora" type="time" value="<?php echo esc_attr($evento_hora); ?>">
	</div>

	<div>
		<label for="evento_lugar">Lugar del evento</label>
		<input name="evento_lugar" type="text" value="<?php echo esc_attr($evento_lugar); ?>">
	</div>
</div>
    <?php

}
function metabox_evento_fecha_save( $post_id ) {
	if ( array_key_exists( 'evento_fecha', $_POST ) ) {
	   update_post_meta(
		  $post_id,
		  '_evento_fecha_meta_key',
		  $_POST['evento_fecha'],		  
	   );	   
	}

	if ( array_key_exists( 'evento_hora', $_POST ) ) {
		update_post_meta(
		   $post_id,
		   '_evento_hora_meta_key',
		   $_POST['evento_hora'],		  
		);	
 }
 if ( array_key_exists( 'evento_lugar', $_POST ) ) {
	update_post_meta(
	   $post_id,
	   '_evento_lugar_meta_key',
	   $_POST['evento_lugar'],		  
	);

}
}
 add_action( 'save_post', 'metabox_evento_fecha_save' );

/*Fin MetaBoxes eventos*/



/**WOOCOMERCE
 * Cambiar el número de columnas en pag tienda

 */

 add_filter('loop_shop_columns', 'loop_columns', 999);

 if (!function_exists('loop_columns')) {
 
  function loop_columns() {
 
  return 1; // 1 productos por columna
 
  }
 
 }

/*modificar single product*/
 remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40); //eo eliminar gancho meta
	
 add_action( 'woocommerce_single_product_summary', 'datos_evento' );
 function datos_evento() {	
	 //$my_var = $product['get_id'];
	 //$product->get_id()
	 //$evento_fecha = get_post_meta( $post->ID, '_evento_fecha_meta_key', true );
 
	 global $product;
	 $my_var = $product->get_id();
 
	 $evento_fecha = get_post_meta( $my_var, '_evento_fecha_meta_key', true );
		 // create a new date format
		 $new_format = date_i18n('d F Y', strtotime($evento_fecha));
	 
	 $evento_hora = get_post_meta( $my_var, '_evento_hora_meta_key', true );			
	 $evento_lugar = get_post_meta( $my_var, '_evento_lugar_meta_key', true );
 
	 if (!empty($evento_fecha) || !empty($evento_hora) || !empty($evento_lugar)) {
		 echo '<ul class="datos-evento">';}
	 if (!empty($evento_fecha)) {
		 echo '<li><i class="bi bi-calendar-event me-1"></i> ' . $new_format . '</li>';
		 }
		 if (!empty($evento_hora)) {
			 echo '<li><i class="bi bi-clock me-1"></i> ' . $evento_hora . '</li>';
		 }
		 if (!empty($evento_lugar)) {
			 echo '<li><i class="bi bi-geo-alt me-2"></i>' . $evento_lugar . '</li>';
		 }
		 if (!empty($evento_fecha) || !empty($evento_hora) || !empty($evento_lugar)) {
			 echo '</ul>';
		 }
 
 
	 
	 } 
/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	 
/*Modificar listado products*/


//remove_action('woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_title', 10); 
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop_item', 'anadir_fecha_abrir_div' );
function anadir_fecha_abrir_div() {	
	 global $product;
	 $my_var = $product->get_id();
 
	 $evento_fecha = get_post_meta( $my_var, '_evento_fecha_meta_key', true );
	 $evento_hora = get_post_meta( $my_var, '_evento_hora_meta_key', true );			
		 // create a new date format
		 $dia = date_i18n('d', strtotime($evento_fecha));
		 $mes = date_i18n('F', strtotime($evento_fecha));		 
		 //$anio = date_i18n('Y', strtotime($evento_fecha));
		 
		 
		 echo '<div class="fecha-item-evento">' ;
		 echo '<div class="mes"> ' .  $mes . ' </div>';		 
		 echo '<div class="dia"> ' .  $dia  .' </div>';
		 echo '<div class="anio"> ' .  $evento_hora  .' </div>';
		 //echo '<div class="anio"> ' .  $anio  .' </div>';
		 echo '</div>';
		 echo '<div class="foto-tit-info">';
 
		 
}

add_action('woocommerce_before_shop_loop_item_title', 'agrupar_tit_precio_en_div');
function agrupar_tit_precio_en_div() {
	echo '<div class="texto-evento-item">';
	
	}
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');	
add_action('woocommerce_after_shop_loop_item_title', 'descripcion_corta_evento');
function descripcion_corta_evento() {
	the_excerpt();
}



add_action( 'woocommerce_after_shop_loop_item', 'cerrar_div' );
function cerrar_div() {
	
	echo '</div></div>';
	}

	add_filter( 'single_product_archive_thumbnail_size', function( $size ) {
		return 'evento-list-item-thumb';
	} );
	
	//add_action( 'woocommerce_before_shop_loop_item', 'anadir_fecha_abrir_div' );

	add_action( 'woocommerce_after_main_content', 'espacio_sobre_pie' );
function espacio_sobre_pie() {
	echo('<div style="height:144px" aria-hidden="true" class="wp-block-spacer"></div>');
}


/*Polylang*/    
pll_register_string("Planta Baja", "Planta Baja", "Puestos");
pll_register_string("Planta Superior", "Planta Superior", "Puestos");

pll_register_string("Link Planta Baja", "Link Planta Baja", "Puestos");
pll_register_string("Link Planta Superior", "Link Planta Superior", "Puestos");


pll_register_string("Puesto", "Puesto", "Puestos");
pll_register_string("Teléfono", "Teléfono", "Puestos");
pll_register_string("Móvil", "Móvil", "Puestos");
pll_register_string("E-mail", "E-mail", "Puestos");
pll_register_string("Sitio web", "Sitio web", "Puestos");
pll_register_string("Especialidad", "Especialidad", "Puestos");

pll_register_string("Volver al plano", "Volver al plano", "Puestos");
pll_register_string("URL_volver_a_plano_planta_baja", "URL_volver_a_plano_planta_baja", "Puestos");
pll_register_string("URL_volver_a_plano_planta_superior", "URL_volver_a_plano_planta_superior", "Puestos");


pll_register_string("Eventos", "Eventos", "Cadenas");