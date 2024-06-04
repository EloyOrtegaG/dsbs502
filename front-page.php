<?php get_header(); ?>
<?php the_content(); ?>
<div class="container">
    <div class="row listado-posts">
        <?php
        $args = array(
            'posts_per_page' => '3',
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $three_blog_posts = new WP_Query($args);

        if ($three_blog_posts->have_posts()):
            while ($three_blog_posts->have_posts()):
                $three_blog_posts->the_post();
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
                                <h2><a href="<?php the_permalink(); ?>" class="stretched-link"><?php the_title(); ?></a></h2>
                                <p>
                                    <?php the_excerpt(); ?>
                                </p>
                            </div>


                        </div>
                    </div> <!-- /.col -->
                </article><!-- /#post-<?php the_ID(); ?> -->
                <?php
            endwhile;
        else:
            ?>
            Vaya, no hay entradas.
            <?php
        endif;
        ?>

    </div>
    <div style="height:144px" aria-hidden="true" class="wp-block-spacer"></div>
    <section class="eventos-home">
        <h2 class="text-center mb-5"><?php echo pll__('Eventos');?></h2>
        <ul class="products">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 3
            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                while ($loop->have_posts()):
                    $loop->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
            } else {
                echo __('No products found');
            }
            wp_reset_postdata();
            ?>
        </ul>
    </section>
</div>
<div style="height:144px" aria-hidden="true" class="wp-block-spacer"></div>
<?php get_footer(); ?>