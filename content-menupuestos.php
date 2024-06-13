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