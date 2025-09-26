<?php
/**
 * Template de la page Nouveautés
 * @package Next Step
 */

get_header(); ?>

<main id="primary" class="ns-nouveautes-page">
    
    <!-- Hero section -->
    <section class="ns-nouveautes__hero">
        <div class="ns-container">
            <div class="ns-nouveautes__hero-content">
                <h1 class="ns-nouveautes__title">Nouveautés</h1>
                <p class="ns-nouveautes__subtitle">Découvrez nos dernières créations, des chaussures tendance pour tous les styles</p>
            </div>
        </div>
    </section>

    <?php
    // Récupérer les 18 dernières sneakers de WooCommerce
    $sneakers = wc_get_products(array(
        'limit' => 18,
        'orderby' => 'date',
        'order' => 'DESC',
        'status' => 'publish',
        'category' => array('sneakers', 'baskets', 'chaussures-sport'), // Ajustez selon vos catégories
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_stock_status',
                'value' => 'instock'
            ),
            array(
                'key' => '_stock_status',
                'value' => 'onbackorder'
            )
        )
    ));

    // Si pas de sneakers trouvées, récupérer les derniers produits
    if (empty($sneakers)) {
        $sneakers = wc_get_products(array(
            'limit' => 18,
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'publish'
        ));
    }
    
    // Compter le nombre total de produits
    $products_count = count($sneakers);
    ?>

    <!-- Filtres et tri -->
    <section class="ns-nouveautes__filters">
        <div class="ns-container">
            <div class="ns-filters__wrapper">
                <div class="ns-filters__left">
                    <span class="ns-filters__count">
                        <?php echo $products_count . ' produits'; ?>
                    </span>
                </div>
                <div class="ns-filters__right">
                    <select class="ns-filter__select">
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
    <section class="ns-nouveautes__products">
        <div class="ns-container">
            <div class="ns-products__grid">
                
                <?php if (!empty($sneakers)) :
                    foreach ($sneakers as $product) :
                        $product_id = $product->get_id();
                        $product_title = $product->get_name();
                        $product_price = $product->get_price_html();
                        $product_url = get_permalink($product_id);
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'large');
                        $product_image_url = $product_image ? $product_image[0] : wc_placeholder_img_src('large');
                        $product_categories = wp_get_post_terms($product_id, 'product_cat');
                        $category_name = !empty($product_categories) ? $product_categories[0]->name : 'Chaussures';
                        
                        // Vérifier si le produit est nouveau (moins de 30 jours)
                        $is_new = (time() - strtotime($product->get_date_created())) < (30 * 24 * 60 * 60);
                        ?>
                        
                        <a href="<?php echo esc_url($product_url); ?>" class="ns-product__card ns-product__card--link">
                            <div class="ns-product__image">
                                <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_title); ?>" loading="lazy">
                                <?php if ($is_new) : ?>
                                    <div class="ns-product__badge">Nouveau</div>
                                <?php endif; ?>
                            </div>
                            <div class="ns-product__content">
                                <h3 class="ns-product__title"><?php echo esc_html($product_title); ?></h3>
                                <p class="ns-product__category"><?php echo esc_html($category_name); ?></p>
                                <div class="ns-product__price">
                                    <?php echo $product_price; ?>
                                </div>
                                <div class="ns-product__btn">Voir le produit</div>
                            </div>
                        </a>
                        
                    <?php endforeach; ?>
                    
                <?php else : ?>
                    <div class="ns-no-products">
                        <p>Aucun produit trouvé. Veuillez ajouter des produits dans WooCommerce.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>


</main>

<?php get_footer(); ?>
