<?php
/**
 * Template pour les pages de catégories avec filtre par marque
 * @package Next Step
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );

$term = get_queried_object();
$category_name = $term->name;
$category_slug = $term->slug;
?>

<main id="primary" class="ns-category-page">
    
    <!-- Hero section de la catégorie -->
    <section class="ns-category__hero">
        <div class="ns-container">
            <div class="ns-category__hero-content">
                <h1 class="ns-category__title"><?php echo esc_html( $category_name ); ?></h1>
                <p class="ns-category__subtitle">Découvrez notre sélection <?php echo esc_html( strtolower( $category_name ) ); ?> avec les meilleures marques</p>
            </div>
        </div>
    </section>

    <?php
    // Récupérer les marques disponibles pour cette catégorie
    $brands = ns_get_brands_for_category( $category_slug );
    
    // Compter le nombre total de produits dans cette catégorie
    $products_count = $term->count;
    ?>

    <!-- Filtres et tri -->
    <section class="ns-category__filters">
        <div class="ns-container">
            <div class="ns-filters__wrapper">
                <div class="ns-filters__left">
                    <span class="ns-filters__count">
                        <?php echo $products_count . ' produits'; ?>
                    </span>
                </div>
                
                <div class="ns-filters__center">
                    <?php if ( !empty( $brands ) && !is_wp_error( $brands ) ) : ?>
                        <div class="ns-brand-filter">
                            <label for="brand-filter" class="ns-filter__label">Marque :</label>
                            <select id="brand-filter" class="ns-filter__select ns-filter__select--brand">
                                <option value="">Toutes les marques</option>
                                <?php foreach ( $brands as $brand ) : ?>
                                    <option value="<?php echo esc_attr( $brand->slug ); ?>">
                                        <?php echo esc_html( $brand->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="ns-filters__right">
                    <select class="ns-filter__select ns-filter__select--sort">
                        <option value="date">Plus récents</option>
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                        <option value="popularity">Plus populaires</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Grille des produits -->
    <section class="ns-category__products">
        <div class="ns-container">
            <div class="ns-products__grid">
                
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="ns-no-products">
                        <p>Aucun produit trouvé dans cette catégorie.</p>
                    </div>
                <?php endif; ?>

            </div>
            
            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandFilter = document.getElementById('brand-filter');
    const sortFilter = document.querySelector('.ns-filter__select--sort');
    
    if (brandFilter) {
        brandFilter.addEventListener('change', function() {
            const selectedBrand = this.value;
            const currentUrl = new URL(window.location);
            
            if (selectedBrand) {
                currentUrl.searchParams.set('brand', selectedBrand);
            } else {
                currentUrl.searchParams.delete('brand');
            }
            
            window.location.href = currentUrl.toString();
        });
    }
    
    if (sortFilter) {
        sortFilter.addEventListener('change', function() {
            const selectedSort = this.value;
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('orderby', selectedSort);
            window.location.href = currentUrl.toString();
        });
    }
});
</script>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
