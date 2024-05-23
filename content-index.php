<?php
/**
 * The template for displaying content in the index.php template.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-6 col-lg-4'); ?>>
	<div class="card texto-sobre-foto">
		<a href="<?php the_permalink() ?>" title="Leer más">
			<div class="overlay-min-blog"></div>
			<?php if (has_post_thumbnail($post->ID)): ?>
				<?php the_post_thumbnail('min-blog', array('class' => 'card-img-top img-fluid')); ?>
			<?php else: ?>
				<img src="<?php echo get_template_directory_uri(); ?>/build/images/mercado-exterior-limpio-sin-cielo.jpg"
					class="img-responsive" alt="<?php the_title(); ?>">
			<?php endif; ?>
		</a>
		<div class="card-body">

			<p class="datos-noticia">
				<!--<i class="fa fa-user"></i> <?php the_author(); ?> | -->
				<?php the_time('j, F Y'); ?>
			</p>
			<div class="text-min">
				<h2><a href="<?php the_permalink(); ?>"
						class="stretched-link"><?php the_title(); ?></a></h2>
				<p>
					<?php the_excerpt(); ?>
				</p>
			</div>


		</div>
	</div> <!-- /.col -->
</article><!-- /#post-<?php the_ID(); ?> -->