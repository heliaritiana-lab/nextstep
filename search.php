<?php
/**
 * Template de recherche personnalisé
 * @package Next Step
 */

get_header(); ?>

<main id="primary" class="ns-search-page">
    
    <!-- Hero section de recherche -->
    <section class="ns-search__hero">
        <div class="ns-container">
            <div class="ns-search__hero-content">
                <h1 class="ns-search__title">
                    <?php if (have_posts()) : ?>
                        Résultats pour "<?php echo get_search_query(); ?>"
                    <?php else : ?>
                        Aucun résultat trouvé
                    <?php endif; ?>
                </h1>
                <p class="ns-search__subtitle">
                    <?php if (have_posts()) : ?>
                        Découvrez nos produits correspondant à votre recherche
                    <?php else : ?>
                        Essayez avec d'autres mots-clés ou parcourez nos catégories
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </section>

    <?php if (have_posts()) : 
        // Compter les résultats
        global $wp_query;
        $results_count = $wp_query->found_posts;
        $search_query = get_search_query();
    ?>
    
    <!-- Filtres et tri -->
    <section class="ns-search__filters">
        <div class="ns-container">
            <div class="ns-filters__wrapper">
                <div class="ns-filters__left">
                    <span class="ns-filters__count">
                        <?php echo $results_count; ?> résultat<?php echo $results_count > 1 ? 's' : ''; ?> pour "<?php echo esc_html($search_query); ?>"
                    </span>
                </div>
                <div class="ns-filters__right">
                    <select class="ns-filter__select ns-filter__select--sort">
                        <option value="relevance">Pertinence</option>
                        <option value="date">Plus récents</option>
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                        <option value="popularity">Plus populaires</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Grille des résultats -->
    <section class="ns-search__results">
        <div class="ns-container">
            <div class="ns-products__grid">
                
                <?php while (have_posts()) : the_post(); ?>
                    <?php 
                    // Vérifier si c'est un produit WooCommerce
                    if (get_post_type() === 'product') {
                        wc_get_template_part('content', 'product');
                    } else {
                        // Pour les autres types de contenu (articles, pages, etc.)
                        ?>
                        <article class="ns-product__card ns-product__card--content">
                            <div class="ns-product__image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" 
                                         alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                                <?php else : ?>
                                    <div class="ns-product__placeholder">
                                        <span class="dashicons dashicons-format-aside"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ns-product__content">
                                <h3 class="ns-product__title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <?php echo esc_html(get_the_title()); ?>
                                    </a>
                                </h3>
                                <p class="ns-product__category"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></p>
                                <div class="ns-product__excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                </div>
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="ns-product__btn">Voir plus</a>
                            </div>
                        </article>
                        <?php
                    }
                    ?>
                <?php endwhile; ?>

            </div>
            
            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '← Précédent',
                'next_text' => 'Suivant →',
                'class' => 'ns-pagination'
            ));
            ?>
        </div>
    </section>

    <?php else : ?>
    
    <!-- Page aucun résultat -->
    <section class="ns-search__no-results">
        <div class="ns-container">
            <div class="ns-no-results">
                <div class="ns-no-results__icon">
                    <span class="dashicons dashicons-search"></span>
                </div>
                <h2 class="ns-no-results__title">Aucun produit trouvé</h2>
                <p class="ns-no-results__text">
                    Nous n'avons trouvé aucun produit correspondant à votre recherche "<?php echo esc_html(get_search_query()); ?>".
                </p>
                
                <!-- Suggestions -->
                <div class="ns-no-results__suggestions">
                    <h3>Suggestions :</h3>
                    <ul>
                        <li>Vérifiez l'orthographe de vos mots-clés</li>
                        <li>Essayez des mots-clés plus généraux</li>
                        <li>Utilisez moins de mots-clés</li>
                        <li>Essayez des synonymes</li>
                    </ul>
                </div>
                
                <!-- Nouvelle recherche -->
                <div class="ns-no-results__search">
                    <h3>Nouvelle recherche</h3>
                    <form role="search" method="get" class="ns-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="ns-search-form__wrapper">
                            <input type="search" 
                                   class="ns-search-form__input" 
                                   name="s" 
                                   value="<?php echo get_search_query(); ?>" 
                                   placeholder="Rechercher des chaussures..."
                                   required>
                            <button type="submit" class="ns-search-form__button">
                                <span class="dashicons dashicons-search"></span>
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Catégories populaires -->
                <div class="ns-no-results__categories">
                    <h3>Ou explorez nos catégories</h3>
                    <div class="ns-categories__grid">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'number' => 3,
                            'slug' => array('homme', 'femme', 'enfant')
                        ));
                        
                        if (!empty($categories) && !is_wp_error($categories)) :
                            foreach ($categories as $category) :
                                $category_link = get_term_link($category);
                                $category_image = get_term_meta($category->term_id, 'thumbnail_id', true);
                                $image_url = $category_image ? wp_get_attachment_image_url($category_image, 'medium') : '';
                                ?>
                                <a href="<?php echo esc_url($category_link); ?>" class="ns-category__card">
                                    <?php if ($image_url) : ?>
                                        <div class="ns-category__image">
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="ns-category__content">
                                        <h4><?php echo esc_html($category->name); ?></h4>
                                        <span class="ns-category__count"><?php echo $category->count; ?> produits</span>
                                    </div>
                                </a>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortFilter = document.querySelector('.ns-filter__select--sort');
    
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

<?php get_footer(); ?>
