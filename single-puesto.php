<?php

get_header();

//the_post();
?>
<div class="container">
    <div class="row">
    <div class="col-xl-10 order-xl-2">
            <header class="entry-header cab-puesto mb-2">
            <?php if ( has_post_thumbnail($post->ID)) : ?>
                <?php $thumbnail_id = get_post_thumbnail_id($post->ID);
                $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); ?>
                <img src="<?php the_post_thumbnail_url(); ?>" class="img-cabpuesto-bg" alt="<?php echo $alt; ?>" />
                <?php else : ?>
                  <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/05/mercado-exterior-limpio-sin-cielo.jpg" class="img-cabpuesto-bg" alt="<?php the_title(); ?>">
                <?php endif; ?>

                
                     


                <h1 class="entry-title"
                <?php
                
                
        
                $ColorFruteria = 'var(--Color-Fruteria)';      
                $ColorCarniceria = 'var(--Color-Carniceria)';      
                $ColorPescaderia = 'var(--Color-Pescaderia)';      
                $ColorEcopuestos = 'var(--Color-Ecopuestos)';      
                $ColorFundacionAbastos = 'var(--Color-FundacionAbastos)';      
                $ColorGastrobares = 'var(--Color-Gastrobares)';      
        
                
                $ColorPolleria = 'var(--Color-Polleria-Quesos)';                                                     
                $ColorOtros = 'var(--Color-Otros)';      





                if (has_term('fruterias', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorFruteria . '; padding-left: 1rem;">';
                    elseif (has_term('carnicerias-y-charcuterias', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorCarniceria . '; padding-left: 1rem;">';   
                    elseif (has_term('pescaderias', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorPescaderia . '; padding-left: 1rem;">';
                    elseif (has_term('ecopuestos', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorEcopuestos . '; padding-left: 1rem;">';
                        elseif (has_term('fundacion-abastos', 'gremios-puesto')) :
                            echo 'style="border-left: 8px solid ' . $ColorFundacionAbastos . '; padding-left: 1rem;">';
                    elseif (has_term('gastrobares', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorGastrobares . '; padding-left: 1rem;">';
                    elseif (has_term('pollerias-y-quesos', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorPolleria . '; padding-left: 1rem;">';
                        elseif (has_term('otros', 'gremios-puesto')) :
                        echo 'style="border-left: 8px solid ' . $ColorOtros . '; padding-left: 1rem;">';
                endif;

               ?>
                
            <?php the_title(); ?>
            </h1>

                <?php
                if ('post' === get_post_type()):
                    ?>
                    <div class="entry-meta">
                        <?php dsbs502_article_posted_on(); ?>
                    </div><!-- /.entry-meta -->
                    <?php
                endif;
                ?>
                <div class="overlay-cabpuesto"></div>
            </header><!-- /.entry-header -->

            <div class="row g-0">
                <div class="col-lg-8 pe-lg-3"><?php the_content(); ?>
                <div class="mt-5 d-flex">
                <?php

/*                 if( has_term( '', 'planta-baja') ) {                            
                    echo '<div> <p>hola hola</p> </div>';
                    
                    }
                else;*/

                    if( has_term( 'planta-baja', 'plantas-puesto' ) ) : ?>
                        <i class="bi bi-arrow-left"></i><a href="https://mercadoabastos.eus/planta-baja/"><?php echo pll__('Volver al plano');?></a>

                        <?php else : ?>
                            <i class="bi bi-arrow-left"></i><a href="https://mercadoabastos.eus/planta-superior/"><?php echo pll__('Volver al plano');?></a>
                    <?php endif; 
                    get_query_var('taxonomy');
                    ?>

                    
                 

                 
                
                </div>
            </div>
                <div id="sidebar" class="sidebar-puesto col-lg-4 p-0">

                    <ul class="datos-puesto">


                        <?php
                        $numpuesto = get_post_meta($post->ID, 'meta-box-puesto-numpuesto', true);
                        if (!empty($numpuesto)): ?>
                            <li><span><strong><?php echo pll__('Puesto') . ':'; ?></strong></span>&nbsp;<?php echo $numpuesto; ?>
                            </li>
                        <?php endif; ?>

                        <?php
                        $telefono = get_post_meta($post->ID, 'meta-box-puesto-telefono', true);
                        if (!empty($telefono)): ?>
                            <li><span><strong><?php echo pll__('Teléfono') . ':'; ?></strong></span>&nbsp;<?php echo $telefono; ?>
                            </li>
                        <?php endif; ?>

                        <?php
                        $movil = get_post_meta($post->ID, 'meta-box-puesto-movil', true);
                        if (!empty($movil)): ?>
                            <li><span><strong><?php echo pll__('Móvil') . ':'; ?></strong></span>&nbsp;<?php echo $movil; ?>
                            </li>
                        <?php endif; ?>

                        <?php
                        $correoe = get_post_meta($post->ID, 'meta-box-puesto-correoe', true);
                        if (!empty($correoe)): ?>
                            <li><span><strong><?php echo pll__('E-mail') . ':'; ?></strong></span>&nbsp;<?php echo $correoe; ?>
                            </li>
                        <?php endif; ?>

                        <?php
                        $web = get_post_meta($post->ID, 'meta-box-puesto-web', true);
                        if (!empty($web)): ?>
                            <li><span><strong><?php echo pll__('Sitio web') . ':'; ?></strong></span>&nbsp;<?php echo $web; ?>
                            </li>
                        <?php endif; ?>

                        <?php
                        $especialidad = get_post_meta($post->ID, 'meta-box-puesto-especialidad', true);
                        if (!empty($especialidad)): ?>
                            <li><span><strong><?php echo pll__('Especialidad') . ':'; ?></strong></span>&nbsp;<?php echo $especialidad; ?>
                            </li>
                        <?php endif; ?>


                        <!-- <li><strong><?php echo pll__('Est. mín.') . ':'; ?></strong>&nbsp;<?php echo get_post_meta(get_the_ID(), 'meta-box-empleo-estudiosMinimos', true); ?></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-2 pt-5">
            <h3>
                <a href="<?php echo get_site_url(); ?>/planta-baja">
                    <?php echo pll__('Planta baja'); ?>
                </a>
            </h3>
            <?php
            if (has_nav_menu('planta-baja-menu')): // See function register_nav_menus() in functions.php
                /*
                                         Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
                                         Menu name taken from functions.php!!! ... register_nav_menu( 'puesto-menu', 'Puesto Menu' );
                                         !!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Puesto menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
                                     */
                wp_nav_menu(
                    array(
                        'container' => 'nav',
                        //'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                        'container_class' => 'menu-puestos',
                        //'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Puesto::fallback',
                        'walker' => new WP_Bootstrap_Navwalker_Puestos(),
                        'theme_location' => 'planta-baja-menu',
                        'items_wrap' => '<ul class="menu nav flex-column">%3$s</ul>',
                    )
                );
            endif;


            ?>

<h3 class="mt-5">
                <a href="<?php echo get_site_url(); ?>/planta-superior">
                    <?php echo pll__('Planta superior'); ?>
                </a>
            </h3>
            <?php
            if (has_nav_menu('planta-sup-menu')): // See function register_nav_menus() in functions.php
                /*
                                         Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
                                         Menu name taken from functions.php!!! ... register_nav_menu( 'puesto-menu', 'Puesto Menu' );
                                         !!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Puesto menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
                                     */
                wp_nav_menu(
                    array(
                        'container' => 'nav',
                        //'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                        'container_class' => 'menu-puestos',
                        //'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Puesto::fallback',
                        'walker' => new WP_Bootstrap_Navwalker_Puestos(),
                        'theme_location' => 'planta-sup-menu',
                        'items_wrap' => '<ul class="menu nav flex-column">%3$s</ul>',
                    )
                );
            endif;


            ?>
        </div>
        


    </div>
    <div style="height:80px;" aria-hidden="true" class="wp-block-spacer"></div>
</div>

<?php get_footer(); ?>

