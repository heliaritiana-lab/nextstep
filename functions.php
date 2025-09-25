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
        $favicon_file = get_stylesheet_directory() . '/assets/icons/next-step-favicon.png';
        $version = file_exists($favicon_file) ? filemtime($favicon_file) : time();
        echo '
        <link rel="icon" type="image/png" href="'.$base.'/next-step-favicon.png?v='.$version.'">
        <link rel="shortcut icon" type="image/png" href="'.$base.'/next-step-favicon.png?v='.$version.'">
        <meta name="theme-color" content="#ff822e">
        ';
    });

    // JavaScript pour l'effet hover des cartes de catégories et gestion de la connexion
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

            // Gestion de l'état de connexion - solution simple
            function checkLoginState() {
                // Vérifier si on vient de se déconnecter
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('logged_out') || urlParams.has('logout')) {
                    // Recharger la page pour mettre à jour l'état
                    window.location.href = '<?php echo home_url('/'); ?>';
                }
            }

            // Vérifier l'état au chargement
            checkLoginState();

            // Écouter les clics sur les liens de déconnexion
            const logoutLinks = document.querySelectorAll('a[href*="logout"], a[href*="deconnexion"], a[href*="wp-login.php?action=logout"]');
            logoutLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    // Attendre un peu puis recharger
                    setTimeout(function() {
                        window.location.href = '<?php echo home_url('/'); ?>';
                    }, 2000);
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

// Modifier l'affichage du stock WooCommerce
add_filter( 'woocommerce_get_availability_text', 'ns_custom_stock_text', 10, 2 );
function ns_custom_stock_text( $availability, $product ) {
    if ( $product->is_in_stock() ) {
        $availability = 'En stock';
    } else {
        $availability = 'Rupture de stock';
    }
    return $availability;
}


// Menus (header + footer)
add_action('after_setup_theme', function(){
    register_nav_menus([
        'primary'       => __('Menu principal', 'next-step'),
        'footer'        => __('Menu pied de page', 'next-step'),
        'footer_legal'  => __('Menu légal pied de page', 'next-step'),
    ]);
});

// Forcer l'utilisation du template page-login.php pour la page connexion
add_filter('page_template', function($template) {
    if (is_page('connexion')) {
        $new_template = locate_template(['page-login.php']);
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
});

// Rediriger vers l'accueil après déconnexion
add_action('wp_logout', function() {
    // Vider tous les caches
    wp_cache_flush();
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache();
    }
    
    // Rediriger vers l'accueil
    wp_redirect(home_url('/?logged_out=1'));
    exit;
});

// Forcer la mise à jour après déconnexion
add_action('init', function() {
    if (isset($_GET['logged_out']) && $_GET['logged_out'] == '1') {
        // Vider le cache de session
        wp_cache_flush();
        
        // Supprimer le paramètre de l'URL après traitement
        add_action('wp_head', function() {
            echo '<script>if(window.history.replaceState) { window.history.replaceState({}, "", "' . home_url('/') . '"); }</script>';
        });
    }
});

// Retirer le bouton "Ajouter/Choix des options" de la boucle produit (pages boutique/catégories)
add_action( 'init', function () {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
});

// Ajouter un lien overlay sur toute la carte produit
add_action( 'woocommerce_before_shop_loop_item', function () {
    global $product;
    if ( ! $product ) return;
    echo '<a class="ns-card-link" href="' . esc_url( get_permalink( $product->get_id() ) ) . '" aria-label="' . esc_attr( $product->get_name() ) . '"></a>';
}, 1 );

// Fonctionnalité de suppression de compte
add_action('init', function() {
    // Traitement de la suppression de compte
    if (isset($_POST['delete_account']) && isset($_POST['delete_account_nonce']) && is_user_logged_in()) {
        if (wp_verify_nonce($_POST['delete_account_nonce'], 'delete_account_' . get_current_user_id())) {
            $user_id = get_current_user_id();
            $confirm_email = sanitize_email($_POST['confirm_email']);
            $user = get_user_by('id', $user_id);
            
            // Vérifier que l'email correspond
            if ($user && $user->user_email === $confirm_email) {
                // Supprimer l'utilisateur
                wp_delete_user($user_id);
                
                // Rediriger vers l'accueil avec message de confirmation
                wp_redirect(home_url('/?account_deleted=1'));
                exit;
            } else {
                // Email incorrect
                wp_redirect(wc_get_page_permalink('myaccount') . '?delete_error=1');
                exit;
            }
        }
    }
});

// Ajouter la section suppression de compte dans "Mon compte"
add_action('woocommerce_account_menu_items', function($items) {
    $items['delete-account'] = 'Supprimer mon compte';
    return $items;
});

// Modifier l'ordre et supprimer "Téléchargements" du menu "Mon compte"
add_action('woocommerce_account_menu_items', function($items) {
    // Supprimer les téléchargements
    unset($items['downloads']);
    
    // Réorganiser l'ordre des éléments
    $new_items = array();
    
    // Éléments principaux (en haut)
    if (isset($items['dashboard'])) $new_items['dashboard'] = $items['dashboard'];
    if (isset($items['orders'])) $new_items['orders'] = $items['orders'];
    if (isset($items['edit-address'])) $new_items['edit-address'] = $items['edit-address'];
    if (isset($items['edit-account'])) $new_items['edit-account'] = $items['edit-account'];
    if (isset($items['customer-logout'])) $new_items['customer-logout'] = $items['customer-logout'];
    
    // Séparateur et suppression de compte (en bas)
    $new_items['delete-account'] = 'Supprimer mon compte';
    
    return $new_items;
}, 20);

// Contenu de la page suppression de compte
add_action('woocommerce_account_delete-account_endpoint', function() {
    $user = wp_get_current_user();
    ?>
    <div class="ns-delete-account">
        <h2 class="ns-delete-account__title">Supprimer mon compte</h2>
        
        <?php if (isset($_GET['delete_error'])): ?>
            <div class="ns-delete-account__error">
                <span class="dashicons dashicons-warning"></span>
                L'adresse email ne correspond pas. Veuillez réessayer.
            </div>
        <?php endif; ?>
        
        <div class="ns-delete-account__warning">
            <h3>⚠️ Attention : Cette action est irréversible</h3>
            <p>La suppression de votre compte entraînera :</p>
            <ul>
                <li>• La perte définitive de toutes vos données personnelles</li>
                <li>• L'annulation de vos commandes en cours</li>
                <li>• La suppression de votre historique d'achats</li>
                <li>• L'impossibilité de récupérer vos informations</li>
            </ul>
        </div>
        
        <form method="post" class="ns-delete-account__form">
            <?php wp_nonce_field('delete_account_' . get_current_user_id(), 'delete_account_nonce'); ?>
            
            <div class="ns-form__group">
                <label for="confirm_email" class="ns-form__label">
                    Pour confirmer, saisissez votre adresse email :
                </label>
                <input type="email" 
                       id="confirm_email" 
                       name="confirm_email" 
                       class="ns-form__input" 
                       placeholder="votre@email.com"
                       required>
                <p class="ns-form__help">
                    Email associé à votre compte : <strong><?php echo esc_html($user->user_email); ?></strong>
                </p>
            </div>
            
            <div class="ns-form__group">
                <label class="ns-form__checkbox">
                    <input type="checkbox" name="confirm_deletion" required>
                    <span class="ns-checkbox__custom"></span>
                    Je comprends que cette action est définitive et irréversible
                </label>
            </div>
            
            <button type="submit" name="delete_account" class="ns-btn ns-btn--danger ns-btn--full" onclick="return confirm('Êtes-vous ABSOLUMENT certain de vouloir supprimer votre compte ? Cette action ne peut pas être annulée.')">
                Supprimer définitivement mon compte
            </button>
        </form>
        
        <div class="ns-delete-account__alternatives">
            <h4>Alternatives à la suppression :</h4>
            <p>
                <a href="<?php echo wc_get_page_permalink('myaccount'); ?>">Modifier mes informations</a> • 
                <a href="<?php echo wc_get_page_permalink('myaccount') . 'orders/'; ?>">Voir mes commandes</a> • 
                <a href="<?php echo wp_logout_url(home_url('/')); ?>">Me déconnecter</a>
            </p>
        </div>
    </div>
    <?php
});

// CSS pour la page de suppression de compte et le menu "Mon compte"
add_action('wp_head', function() {
    if (is_wc_endpoint_url('delete-account')) {
        ?>
        <style>
        .ns-delete-account{max-width:600px;margin:0 auto;padding:20px;}
        .ns-delete-account__title{color:#d32f2f;margin-bottom:24px;font-size:24px;}
        .ns-delete-account__warning{background:#fff3e0;border:2px solid #ff9800;border-radius:8px;padding:20px;margin-bottom:24px;}
        .ns-delete-account__warning h3{color:#e65100;margin:0 0 12px;}
        .ns-delete-account__warning ul{margin:12px 0;padding-left:20px;}
        .ns-delete-account__warning li{margin-bottom:6px;}
        .ns-delete-account__error{background:#ffebee;border:2px solid #f44336;color:#d32f2f;padding:12px 16px;border-radius:8px;margin-bottom:24px;display:flex;align-items:center;gap:8px;}
        .ns-delete-account__form{margin-bottom:32px;}
        .ns-form__help{margin-top:8px;font-size:14px;color:#666;}
        .ns-btn--danger{background:#d32f2f;color:#fff;}
        .ns-btn--danger:hover{background:#b71c1c;}
        .ns-delete-account__alternatives{background:#f5f5f5;border-radius:8px;padding:20px;text-align:center;}
        .ns-delete-account__alternatives h4{margin:0 0 12px;color:#333;}
        .ns-delete-account__alternatives p{margin:0;}
        .ns-delete-account__alternatives a{color:var(--ns-blue);text-decoration:none;margin:0 8px;}
        .ns-delete-account__alternatives a:hover{text-decoration:underline;}
        </style>
        <?php
    }
    
    // CSS moderne pour la page "Mon compte" (sur toutes les pages du compte)
    if (is_account_page()) {
        ?>
        <style>
        /* ===== DESIGN MODERNE PAGE MON COMPTE ===== */
        
        /* Container principal */
        .woocommerce-account .woocommerce {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 80vh;
            padding: 40px 0;
        }
        
        /* Supprimer la bande blanche en haut */
        .woocommerce-account .woocommerce::before,
        .woocommerce-account .woocommerce::after {
            display: none !important;
        }
        
        /* Supprimer tout padding/margin en haut */
        .woocommerce-account {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .woocommerce-account .woocommerce-MyAccount-navigation,
        .woocommerce-account .woocommerce-MyAccount-content {
            margin-top: 0 !important;
        }
        
        /* Layout principal */
        .woocommerce-MyAccount-navigation,
        .woocommerce-MyAccount-content {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        /* Navigation moderne */
        .woocommerce-MyAccount-navigation {
            padding: 0;
            margin-bottom: 24px;
            overflow: hidden;
        }
        
        .woocommerce-MyAccount-navigation ul {
            margin: 0;
            padding: 0;
            list-style: none;
            border: none;
        }
        
        .woocommerce-MyAccount-navigation ul li {
            border: none;
            border-bottom: 1px solid #f0f0f0;
            margin: 0;
            transition: all 0.3s ease;
        }
        
        .woocommerce-MyAccount-navigation ul li:last-child {
            border-bottom: none;
        }
        
        .woocommerce-MyAccount-navigation ul li a {
            display: flex;
            align-items: center;
            padding: 20px 24px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .woocommerce-MyAccount-navigation ul li a:before {
            content: '';
            width: 4px;
            height: 0;
            background: var(--ns-orange);
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            transition: height 0.3s ease;
        }
        
        .woocommerce-MyAccount-navigation ul li a:hover,
        .woocommerce-MyAccount-navigation ul li.is-active a {
            background: linear-gradient(135deg, rgba(255,130,46,0.1) 0%, rgba(255,138,61,0.05) 100%);
            color: var(--ns-orange);
            padding-left: 32px;
        }
        
        .woocommerce-MyAccount-navigation ul li a:hover:before,
        .woocommerce-MyAccount-navigation ul li.is-active a:before {
            height: 100%;
        }
        
        /* Supprimer les émojis du menu */
        .woocommerce-MyAccount-navigation ul li a:after { 
            display: none; 
        }
        
        /* "Se déconnecter" en bleu */
        .woocommerce-MyAccount-navigation ul li a[href*="customer-logout"] {
            color: var(--ns-blue) !important;
        }
        
        .woocommerce-MyAccount-navigation ul li:hover a[href*="customer-logout"] {
            background: linear-gradient(135deg, rgba(0,123,255,0.1) 0%, rgba(0,123,255,0.05) 100%) !important;
        }
        
        /* "Supprimer mon compte" en rouge avec séparation */
        .woocommerce-MyAccount-navigation ul li a[href*="delete-account"] {
            color: #d32f2f !important;
            font-weight: 600;
            border-top: 2px solid #d32f2f;
            margin-top: 20px;
        }
        
        .woocommerce-MyAccount-navigation ul li a[href*="delete-account"]:before {
            content: "⚠️ ";
            margin-right: 8px;
            width: auto;
            height: auto;
            background: none;
            position: static;
        }
        
        .woocommerce-MyAccount-navigation ul li:hover a[href*="delete-account"] {
            background: linear-gradient(135deg, rgba(211,47,47,0.1) 0%, rgba(211,47,47,0.05) 100%) !important;
        }
        
        /* Contenu principal */
        .woocommerce-MyAccount-content {
            padding: 32px;
            border-radius: 16px;
        }
        
        .woocommerce-MyAccount-content h2 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 3px solid var(--ns-orange);
            display: inline-block;
        }
        
        /* Cartes modernes pour les commandes */
        .woocommerce-MyAccount-orders {
            display: grid;
            gap: 16px;
        }
        
        .woocommerce-orders-table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid #f0f0f0;
        }
        
        .woocommerce-orders-table th,
        .woocommerce-orders-table td {
            padding: 16px;
            border: none;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .woocommerce-orders-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        /* Boutons modernes */
        .woocommerce-button,
        .woocommerce-Button,
        .button {
            background: var(--ns-orange);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255,130,46,0.3);
        }
        
        .woocommerce-button:hover,
        .woocommerce-Button:hover,
        .button:hover {
            background: #e6730a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,130,46,0.4);
        }
        
        /* Formulaire moderne */
        .woocommerce-form-row {
            margin-bottom: 20px;
        }
        
        .woocommerce-form-row input,
        .woocommerce-form-row select,
        .woocommerce-form-row textarea {
            width: 100%;
            padding: 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .woocommerce-form-row input:focus,
        .woocommerce-form-row select:focus,
        .woocommerce-form-row textarea:focus {
            border-color: var(--ns-orange);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255,130,46,0.1);
        }
        
        .woocommerce-form-row label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        
        /* Messages de statut */
        .woocommerce-message,
        .woocommerce-info,
        .woocommerce-error {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border-left: 4px solid;
            font-weight: 500;
        }
        
        .woocommerce-message {
            background: #d4edda;
            color: #155724;
            border-color: #28a745;
        }
        
        .woocommerce-info {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #17a2b8;
        }
        
        .woocommerce-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #dc3545;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .woocommerce-MyAccount-navigation,
            .woocommerce-MyAccount-content {
                margin-bottom: 16px;
            }
            
            .woocommerce-MyAccount-content {
                padding: 20px;
            }
            
            .woocommerce-MyAccount-navigation ul li a {
                padding: 16px 20px;
                font-size: 15px;
            }
            
            .woocommerce-MyAccount-content h2 {
                font-size: 24px;
            }
            
            .woocommerce-orders-table {
                font-size: 14px;
            }
            
            .woocommerce-orders-table th,
            .woocommerce-orders-table td {
                padding: 12px 8px;
            }
        }
        
        @media (max-width: 480px) {
            .woocommerce-orders-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        
        /* ===== DESIGN TABLEAU DE BORD ===== */
        
        /* Message de bienvenue moderne */
        .woocommerce-MyAccount-content .woocommerce-message {
            background: linear-gradient(135deg, var(--ns-blue) 0%, #0056b3 100%);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 8px 24px rgba(0,123,255,0.3);
            position: relative;
            overflow: hidden;
        }
        
        .woocommerce-MyAccount-content .woocommerce-message::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }
        
        .woocommerce-MyAccount-content .woocommerce-message p {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        
        .woocommerce-MyAccount-content .woocommerce-message a {
            color: rgba(255,255,255,0.9);
            text-decoration: underline;
            font-weight: 500;
        }
        
        .woocommerce-MyAccount-content .woocommerce-message a:hover {
            color: white;
        }
        
        /* Cartes de statistiques */
        .ns-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }
        
        .ns-stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .ns-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        
        .ns-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--ns-blue) 0%, #0056b3 100%);
        }
        
        .ns-stat-card__icon {
            font-size: 32px;
            margin-bottom: 16px;
            display: block;
        }
        
        .ns-stat-card__title {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        
        .ns-stat-card__value {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .ns-stat-card__description {
            font-size: 14px;
            color: #888;
            line-height: 1.4;
        }
        
        .ns-stat-card__link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            color: var(--ns-blue);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .ns-stat-card__link:hover {
            color: #004085;
            transform: translateX(4px);
        }
        
        .ns-stat-card__link::after {
            content: '→';
            transition: transform 0.3s ease;
        }
        
        .ns-stat-card__link:hover::after {
            transform: translateX(4px);
        }
        
        /* Section des actions rapides */
        .ns-quick-actions {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border: 1px solid #f0f0f0;
            margin-bottom: 32px;
        }
        
        .ns-quick-actions h3 {
            color: #333;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--ns-blue);
            display: inline-block;
        }
        
        .ns-quick-actions__grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .ns-quick-action {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .ns-quick-action:hover {
            background: white;
            border-color: var(--ns-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.2);
        }
        
        .ns-quick-action__icon {
            font-size: 24px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--ns-blue);
            border-radius: 8px;
            color: white;
        }
        
        .ns-quick-action__content h4 {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .ns-quick-action__content p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        /* Responsive pour le tableau de bord */
        @media (max-width: 768px) {
            .ns-dashboard-stats {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .ns-stat-card {
                padding: 20px;
            }
            
            .ns-quick-actions {
                padding: 24px;
            }
            
            .ns-quick-actions__grid {
                grid-template-columns: 1fr;
            }
            
            .ns-quick-action {
                padding: 16px;
            }
        }
        </style>
        <?php
    }
});


// Personnaliser le contenu du tableau de bord
add_action('woocommerce_account_dashboard', function() {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Compter les commandes
    $orders_count = wc_get_customer_order_count($user_id);
    $total_spent = wc_get_customer_total_spent($user_id);
    
    // Récupérer les commandes récentes
    $recent_orders = wc_get_orders(array(
        'customer' => $user_id,
        'limit' => 3,
        'status' => array('completed', 'processing', 'on-hold')
    ));
    
    ?>
    <div class="ns-dashboard-stats">
        <div class="ns-stat-card">
            <span class="ns-stat-card__icon">📦</span>
            <div class="ns-stat-card__title">Commandes totales</div>
            <div class="ns-stat-card__value"><?php echo $orders_count; ?></div>
            <div class="ns-stat-card__description">Nombre total de commandes passées</div>
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'orders/'; ?>" class="ns-stat-card__link">
                Voir toutes les commandes
            </a>
        </div>
        
        <div class="ns-stat-card">
            <span class="ns-stat-card__icon">💰</span>
            <div class="ns-stat-card__title">Total dépensé</div>
            <div class="ns-stat-card__value"><?php echo wc_price($total_spent); ?></div>
            <div class="ns-stat-card__description">Montant total de vos achats</div>
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'orders/'; ?>" class="ns-stat-card__link">
                Historique des commandes
            </a>
        </div>
        
        <div class="ns-stat-card">
            <span class="ns-stat-card__icon">👤</span>
            <div class="ns-stat-card__title">Membre depuis</div>
            <div class="ns-stat-card__value"><?php echo date('M Y', strtotime($current_user->user_registered)); ?></div>
            <div class="ns-stat-card__description">Date d'inscription sur le site</div>
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'edit-account/'; ?>" class="ns-stat-card__link">
                Modifier mes informations
            </a>
        </div>
    </div>
    
    <div class="ns-quick-actions">
        <h3>Actions rapides</h3>
        <div class="ns-quick-actions__grid">
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'orders/'; ?>" class="ns-quick-action">
                <div class="ns-quick-action__icon">📦</div>
                <div class="ns-quick-action__content">
                    <h4>Mes commandes</h4>
                    <p>Suivre et consulter vos commandes</p>
                </div>
            </a>
            
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'edit-address/'; ?>" class="ns-quick-action">
                <div class="ns-quick-action__icon">📍</div>
                <div class="ns-quick-action__content">
                    <h4>Mes adresses</h4>
                    <p>Gérer vos adresses de livraison</p>
                </div>
            </a>
            
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'edit-account/'; ?>" class="ns-quick-action">
                <div class="ns-quick-action__icon">⚙️</div>
                <div class="ns-quick-action__content">
                    <h4>Paramètres</h4>
                    <p>Modifier mot de passe et détails</p>
                </div>
            </a>
            
            <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="ns-quick-action">
                <div class="ns-quick-action__icon">🛍️</div>
                <div class="ns-quick-action__content">
                    <h4>Continuer mes achats</h4>
                    <p>Découvrir nos nouveaux produits</p>
                </div>
            </a>
        </div>
    </div>
    
    <?php if (!empty($recent_orders)): ?>
    <div class="ns-recent-orders">
        <h3>Commandes récentes</h3>
        <div class="ns-orders-list">
            <?php foreach ($recent_orders as $order): ?>
            <div class="ns-order-item">
                <div class="ns-order-info">
                    <div class="ns-order-number">Commande #<?php echo $order->get_order_number(); ?></div>
                    <div class="ns-order-date"><?php echo $order->get_date_created()->date('d/m/Y'); ?></div>
                </div>
                <div class="ns-order-status">
                    <span class="ns-status-badge ns-status-<?php echo $order->get_status(); ?>">
                        <?php echo wc_get_order_status_name($order->get_status()); ?>
                    </span>
                </div>
                <div class="ns-order-total"><?php echo $order->get_formatted_order_total(); ?></div>
                <div class="ns-order-actions">
                    <a href="<?php echo $order->get_view_order_url(); ?>" class="ns-btn ns-btn--small">
                        Voir
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="ns-orders-footer">
            <a href="<?php echo wc_get_page_permalink('myaccount') . 'orders/'; ?>" class="ns-btn ns-btn--outline">
                Voir toutes les commandes
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <style>
    /* Styles pour les commandes récentes */
    .ns-recent-orders {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        border: 1px solid #f0f0f0;
    }
    
    .ns-recent-orders h3 {
        color: #333;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--ns-blue);
        display: inline-block;
    }
    
    .ns-orders-list {
        display: grid;
        gap: 16px;
    }
    
    .ns-order-item {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 20px;
        align-items: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .ns-order-item:hover {
        background: white;
        border-color: var(--ns-blue);
        box-shadow: 0 4px 12px rgba(0,123,255,0.1);
    }
    
    .ns-order-number {
        font-weight: 600;
        color: #333;
        font-size: 16px;
    }
    
    .ns-order-date {
        color: #666;
        font-size: 14px;
    }
    
    .ns-status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .ns-status-completed { background: #d4edda; color: #155724; }
    .ns-status-processing { background: #d1ecf1; color: #0c5460; }
    .ns-status-on-hold { background: #fff3cd; color: #856404; }
    .ns-status-pending { background: #f8d7da; color: #721c24; }
    
    .ns-order-total {
        font-weight: 600;
        color: var(--ns-blue);
        font-size: 16px;
    }
    
    .ns-btn--small {
        padding: 8px 16px;
        font-size: 14px;
    }
    
    .ns-btn--outline {
        background: transparent;
        border: 2px solid var(--ns-blue);
        color: var(--ns-blue);
    }
    
    .ns-btn--outline:hover {
        background: var(--ns-blue);
        color: white;
    }
    
    .ns-orders-footer {
        margin-top: 24px;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .ns-order-item {
            grid-template-columns: 1fr;
            gap: 12px;
            text-align: center;
        }
        
        .ns-recent-orders {
            padding: 24px;
        }
    }
    </style>
    <?php
});

// Message de confirmation après suppression de compte
add_action('wp_footer', function() {
    if (isset($_GET['account_deleted']) && $_GET['account_deleted'] == '1') {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Afficher une notification de confirmation
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #4caf50;
                color: white;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                font-size: 14px;
                max-width: 300px;
                animation: slideIn 0.3s ease-out;
            `;
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="dashicons dashicons-yes-alt" style="color: white;"></span>
                    <div>
                        <strong>Compte supprimé</strong><br>
                        Votre compte a été supprimé avec succès.
                    </div>
                </div>
            `;
            
            // Ajouter l'animation CSS
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(notification);
            
            // Supprimer la notification après 5 secondes
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 5000);
            
            // Nettoyer l'URL
            if (window.history.replaceState) {
                window.history.replaceState({}, '', window.location.pathname);
            }
        });
        </script>
        <?php
    }
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('dashicons'); // nécessaire pour afficher les .dashicons côté front
  });
  