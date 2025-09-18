<?php
/* Template de la page d'accueil */
get_header(); ?>

    <main id="primary" class="ns-home">

        <!-- HERO -->
        <section class="ns-hero">
            <div class="ns-container ns-hero__inner">
                <div class="ns-hero__text">
                    <h1 class="ns-title-xl">NextStep — Sneakers sélection</h1>
                    <p class="ns-subtitle">Des paires triées, un style net. Nouveautés, classiques et drops.</p>
                    <div class="ns-cta">
                        <a class="ns-btn" href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">Voir la boutique</a>
                        <a class="ns-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">Mon panier</a>
                    </div>
                </div>
                <div class="ns-hero__media">
                    <?php
                    // Image mise en avant de la page "Accueil" si définie
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('large', ['class' => 'ns-hero__img']);
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- USP (arguments de valeur) -->
        <section class="ns-usp">
            <div class="ns-container ns-usp__grid">
                <div class="ns-usp__item">✅ Livraison rapide</div>
                <div class="ns-usp__item">↩️ Retours 14 jours</div>
                <div class="ns-usp__item">🔒 Paiement sécurisé</div>
                <div class="ns-usp__item">⭐ Sélection vérifiée</div>
            </div>
        </section>

        <!-- Catégories (ex. Homme / Femme) -->
        <section class="ns-cats">
            <div class="ns-container">
                <h2 class="ns-title-lg">Catégories</h2>
                <div class="ns-cats__grid">
                    <a class="ns-card ns-card--cat" href="<?php echo esc_url( get_term_link( 'Homme', 'product_cat' ) ); ?>">
                        <div class="ns-card__body">
                            <h3>Homme</h3>
                            <p>Pointures 39–49</p>
                        </div>
                    </a>
                    <a class="ns-card ns-card--cat" href="<?php echo esc_url( get_term_link( 'Femme', 'product_cat' ) ); ?>">
                        <div class="ns-card__body">
                            <h3>Femme</h3>
                            <p>Pointures 35–43</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Nouveautés -->
        <section class="ns-products">
            <div class="ns-container">
                <h2 class="ns-title-lg">Nouveautés</h2>
                <div class="ns-products__grid">
                    <?php
                    // 8 produits récents
                    echo do_shortcode('[products limit="8" columns="4" orderby="date" order="DESC" visibility="visible"]');
                    ?>
                </div>
            </div>
        </section>

        <!-- Meilleures ventes -->
        <section class="ns-products">
            <div class="ns-container">
                <h2 class="ns-title-lg">Meilleures ventes</h2>
                <div class="ns-products__grid">
                    <?php
                    // 8 best-sellers (WooCommerce calcule via total_sales)
                    echo do_shortcode('[best_selling_products limit="8" columns="4"]');
                    ?>
                </div>
            </div>
        </section>

        <!-- Newsletter (simple) -->
        <section class="ns-newsletter">
            <div class="ns-container ns-newsletter__inner">
                <h2 class="ns-title-lg">Reste au courant des drops</h2>
                <form class="ns-form" action="#" method="post">
                    <input class="ns-input" type="email" name="email" placeholder="Ton email" required>
                    <button class="ns-btn" type="submit">S’inscrire</button>
                </form>
            </div>
        </section>

    </main>

<?php get_footer();
