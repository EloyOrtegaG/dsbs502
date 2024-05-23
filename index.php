<?php
/**
 * Template Name: Blog Index
 * Description: The template for displaying the Blog index /blog.
 *
 */

get_header();

$page_id = get_option( 'page_for_posts' );
?>
<div class="container">
	<div class="row">
		<h2>BLOG</h2>
		<div class="col-md-12">
			<?php
				echo apply_filters( 'the_content', get_post_field( 'post_content', $page_id ) );
	
				edit_post_link( __( 'Edit', 'dsbs502' ), '<span class="edit-link">', '</span>', $page_id );
			?>
		</div><!-- /.col -->
		<div class="col-md-12">
			<?php
				get_template_part( 'archive', 'loop' );
			?>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
<?php
get_footer();
