<?php
/**
 * The header for our theme
 *
 * @package NextStep
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<div id="page" class="site">

	<header id="masthead" class="ns-header">
		<div class="ns-header__inner">

			<!-- Logo -->
			<div class="ns-logo">
				<a href="<?php echo esc_url( home_url('/') ); ?>" class="ns-logo__link">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/icons/logo.png' ); ?>" alt="<?php bloginfo('name'); ?>" class="ns-logo__img">
				</a>
			</div>

			<!-- Menu principal -->
			<?php
			// Helper pour générer les URLs de catégories
			function ns_term_url_by_slug( $slug ) {
				if ( function_exists('get_term_by') && function_exists('get_term_link') ) {
					$term = get_term_by( 'slug', $slug, 'product_cat' );
					if ( $term && ! is_wp_error( $term ) ) {
						$link = get_term_link( $term );
						if ( $link && ! is_wp_error( $link ) ) return $link;
					}
				}
				return home_url( '/categorie-produit/' . $slug . '/' ); // fallback
			}
			?>

			<nav class="ns-nav" aria-label="<?php esc_attr_e('Navigation principale','nextstep'); ?>">
				<ul class="ns-nav__list">
					<li>
						<a href="<?php echo esc_url( home_url('/nouveautes/') ); ?>">Nouveauté</a>
					</li>
					<li>
						<a href="<?php echo esc_url( ns_term_url_by_slug('homme') ); ?>"
						   <?php if ( is_product_category('homme') ) echo 'aria-current="page"'; ?>>
							Homme
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( ns_term_url_by_slug('femme') ); ?>"
						   <?php if ( is_product_category('femme') ) echo 'aria-current="page"'; ?>>
							Femme
						</a>
					</li>
					<li>
						<a href="<?php echo esc_url( ns_term_url_by_slug('enfant') ); ?>"
						   <?php if ( is_product_category('enfant') ) echo 'aria-current="page"'; ?>>
							Enfant
						</a>
					</li>
				</ul>
			</nav>

			<!-- Recherche + Icônes -->
			<div class="ns-actions">

				<!-- Recherche -->
				<form role="search" method="get" class="ns-search" action="<?php echo esc_url( home_url('/') ); ?>">
					<button type="submit" class="ns-search__icon" aria-label="<?php esc_attr_e('Rechercher','nextstep'); ?>">
						<span class="dashicons dashicons-search"></span>
					</button>
					<input type="search" class="ns-search__input" name="s" value="<?php echo get_search_query(); ?>"
						placeholder="Rechercher" aria-label="<?php esc_attr_e('Rechercher','nextstep'); ?>" />
				</form>

				<!-- Panier -->
				<?php if ( function_exists('wc_get_cart_url') && function_exists('WC') ) :
					$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
					<a class="ns-icon ns-cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e('Voir le panier','nextstep'); ?>">
						<span class="dashicons dashicons-cart"></span>
						<?php if ( $cart_count > 0 ) : ?>
							<span class="ns-badge"><?php echo esc_html( $cart_count ); ?></span>
						<?php endif; ?>
					</a>
				<?php endif; ?>

				<!-- Compte -->
				<a class="ns-icon" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" aria-label="<?php esc_attr_e('Mon compte','nextstep'); ?>">
					<span class="dashicons dashicons-admin-users"></span>
				</a>

			</div><!-- .ns-actions -->

		</div><!-- .ns-header__inner -->
	</header>

	<div id="content" class="site-content">
