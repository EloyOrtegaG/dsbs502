<?php

get_header();

//the_post();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-2 pt-5">
            <h3>
            <a href="<?php echo get_site_url(); ?>/planta-baja">
                <?php echo pll__('Planta baja'); ?>
                </a>
            </h3>
        <?php
						if ( has_nav_menu( 'puestos-menu' ) ) : // See function register_nav_menus() in functions.php
							/*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'puesto-menu', 'Puesto Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Puesto menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
							*/
							wp_nav_menu(
								array(
									'container'       => 'nav',
                                    //'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
									'container_class' => 'menu-puestos',
									//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Puesto::fallback',
									'walker'          => new WP_Bootstrap_Navwalker_Puestos(),
									'theme_location'  => 'puestos-menu',
									'items_wrap'      => '<ul class="menu nav flex-column">%3$s</ul>',
								)
							);
						endif;

						
					?>
        </div>
        <div class="col-lg-7 px-lg-5">
            <header class="entry-header">
                
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                
                <?php
                if ('post' === get_post_type()):
                    ?>
                    <div class="entry-meta">
                        <?php dsbs502_article_posted_on(); ?>
                    </div><!-- /.entry-meta -->
                    <?php
                endif;
                ?>
            </header><!-- /.entry-header -->
            
            <?php the_content(); ?>
        </div>
        <div id="sidebar" class="col-lg-3 pt-5">

            <ul class="datos-puesto">


                <?php
                $numpuesto = get_post_meta($post->ID, 'meta-box-puesto-numpuesto', true);
                if (!empty($numpuesto)): ?>
                    <li><span><strong><?php echo pll__('Puesto') . ':'; ?></strong></span>&nbsp;<?php echo $numpuesto; ?></li>
                <?php endif; ?>

                <?php
                $telefono = get_post_meta($post->ID, 'meta-box-puesto-telefono', true);
                if (!empty($telefono)): ?>
                    <li><span><strong><?php echo pll__('Teléfono') . ':'; ?></strong></span>&nbsp;<?php echo $telefono; ?></li>
                <?php endif; ?>

                <?php
                $movil = get_post_meta($post->ID, 'meta-box-puesto-movil', true);
                if (!empty($movil)): ?>
                    <li><span><strong><?php echo pll__('Móvil') . ':'; ?></strong></span>&nbsp;<?php echo $movil; ?></li>
                <?php endif; ?>

                <?php
                $correoe = get_post_meta($post->ID, 'meta-box-puesto-correoe', true);
                if (!empty($correoe)): ?>
                    <li><span><strong><?php echo pll__('E-mail') . ':'; ?></strong></span>&nbsp;<?php echo $correoe; ?></li>
                <?php endif; ?>

                <?php
                $web = get_post_meta($post->ID, 'meta-box-puesto-web', true);
                if (!empty($web)): ?>
                    <li><span><strong><?php echo pll__('Sitio web') . ':'; ?></strong></span>&nbsp;<?php echo $web; ?></li>
                <?php endif; ?>

                <?php
                $especialidad = get_post_meta($post->ID, 'meta-box-puesto-especialidad', true);
                if (!empty($especialidad)): ?>
                    <li><span><strong><?php echo pll__('Especialidad') . ':'; ?></strong></span>&nbsp;<?php echo $especialidad; ?></li>
                <?php endif; ?>


                <!-- <li><strong><?php echo pll__('Est. mín.') . ':'; ?></strong>&nbsp;<?php echo get_post_meta(get_the_ID(), 'meta-box-empleo-estudiosMinimos', true); ?></li> -->
            </ul>
        </div>

    </div>
    <div style="height:80px;" aria-hidden="true" class="wp-block-spacer"></div>
</div>

<?php get_footer(); ?>