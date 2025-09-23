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

    // JavaScript pour l'effet hover des cartes de catégories
    add_action('wp_footer', function () {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryCards = document.querySelectorAll('.ns-card--tile[data-hover-bg]');
            
            categoryCards.forEach(function(card) {
                const hoverBg = card.getAttribute('data-hover-bg');
                
                card.addEventListener('mouseenter', function() {
                    this.style.setProperty('--hover-bg', 'url(' + hoverBg + ')');
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.removeProperty('--hover-bg');
                });
            });
        });
        </script>
        <?php
    });

    // Modifier l'affichage des prix pour les produits variables
    add_filter('woocommerce_get_price_html', function($price, $product) {
        if (is_admin() || !$product) {
            return $price;
        }
        
        // Seulement dans les boucles de produits (pas sur les pages individuelles)
        if (is_product()) {
            return $price;
        }
        
        if ($product->is_type('variable')) {
            $variation_prices = $product->get_variation_prices();
            if (!empty($variation_prices['price'])) {
                $min_price = min($variation_prices['price']);
                $formatted_min_price = wc_price($min_price);
                return '<span class="price">À partir de ' . $formatted_min_price . '</span>';
            }
        }
        
        return $price;
    }, 10, 2);

    // Modifier le texte du bouton d'ajout au panier
    add_filter('woocommerce_product_add_to_cart_text', function($text, $product) {
        if (is_admin() || !$product) {
            return $text;
        }
        
        // Seulement dans les boucles de produits (pas sur les pages individuelles)
        if (is_product()) {
            return $text;
        }
        
        if ($product->is_type('variable') || $product->is_type('grouped')) {
            return 'Voir le produit';
        }
        
        return $text;
    }, 10, 2);

    // Modifier l'URL du bouton d'ajout au panier pour les produits variables
    add_filter('woocommerce_product_add_to_cart_url', function($url, $product) {
        if (is_admin() || !$product) {
            return $url;
        }
        
        // Seulement dans les boucles de produits (pas sur les pages individuelles)
        if (is_product()) {
            return $url;
        }
        
        if ($product->is_type('variable') || $product->is_type('grouped')) {
            return $product->get_permalink();
        }
        
        return $url;
    }, 10, 2);


});

// Menus (header + footer)
add_action('after_setup_theme', function(){
    register_nav_menus([
        'primary'       => __('Menu principal', 'next-step'),
        'footer'        => __('Menu pied de page', 'next-step'),
        'footer_legal'  => __('Menu légal pied de page', 'next-step'),
    ]);
});