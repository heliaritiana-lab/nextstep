<?php
add_action('wp_enqueue_scripts', function () {
    // CSS du parent
    wp_enqueue_style(
        'orchid-store-style',
        get_template_directory_uri() . '/style.css',
        [],
        filemtime( get_template_directory() . '/style.css' )
    );

    // CSS du child (style.css)
    wp_enqueue_style(
        'next-step-style',
        get_stylesheet_uri(),
        ['orchid-store-style'],
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    // Ton CSS perso supplémentaire (facultatif)
    $custom = get_stylesheet_directory() . '/custom.css';
    if ( file_exists($custom) ) {
        wp_enqueue_style(
            'next-step-custom',
            get_stylesheet_directory_uri() . '/custom.css',
            ['next-step-style'],
            filemtime( $custom )
        );
    }
    // Remplacer le header du parent par un header custom
    add_action('after_setup_theme', function () {
        // retire l'action par défaut du thème parent
        remove_action( 'orchid_store_header', 'orchid_store_header_action', 10 );
        // insère ton header
        add_action( 'orchid_store_header', 'next_step_header', 10 );
    });

    function next_step_header() {
        ?>
        <header class="ns-header">
            <div class="ns-header__inner">
                <a class="ns-logo" href="<?php echo esc_url( home_url('/') ); ?>">
                    <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) { the_custom_logo(); } else { bloginfo('name'); } ?>
                </a>

                <nav class="ns-nav" aria-label="Menu principal">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'ns-nav__list',
                        'fallback_cb'    => false,
                    ]);
                    ?>
                </nav>

                <div class="ns-actions">
                    <?php get_search_form(); ?>
                    <?php if ( class_exists('WooCommerce') ) : ?>
                        <a class="ns-cart" href="<?php echo wc_get_cart_url(); ?>">
                            Panier (<?php echo WC()->cart->get_cart_contents_count(); ?>)
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <?php
    }
    add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style('next-step-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap', [], null);
    }, 5);

    add_action('wp_head', function () {
        $base = get_stylesheet_directory_uri() . '/assets/icons';
        echo '
        <link rel="icon" type="image/png" sizes="32x32" href="'.$base.'/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="'.$base.'/favicon-16x16.png">
        <link rel="apple-touch-icon" sizes="180x180" href="'.$base.'/apple-touch-icon.png">
        <meta name="theme-color" content="#ff822e">
        ';
    });


});
