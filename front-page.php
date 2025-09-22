<?php
/* Template de la page d'accueil */
get_header(); ?>

    <main id="primary" class="ns-home">

        <!-- HERO -->
        <section class="ns-hero">
            <div class="ns-hero__bg" style="background-image:url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/hero.png' ); ?>');"></div>
            <div class="ns-hero__shade"></div>
            <div class="ns-container ns-hero__inner">
                <div class="ns-hero__text">
                    <p class="ns-eyebrow">ONE STEP AHEAD</p>
                    <h1 class="ns-title-xl"><span>Ton prochain pas</span><br><span>commence ici</span></h1>
                    <div class="ns-cta">
                        <a class="ns-btn ns-btn--primary" href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">Shop now</a>
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

        <!-- READY / sélection -->
        <section class="ns-ready">
            <div class="ns-container">
                <h2 class="ns-title-ready">Ready for your<br>Next Step ?</h2>
                <div class="ns-ready__grid">
                    <?php echo do_shortcode('[products limit="4" columns="4" orderby="date" order="DESC" visibility="visible"]'); ?>
                </div>
            </div>
        </section>

        <!-- Catégories (Homme / Femme / Enfant) -->
        <section class="ns-cats">
            <div class="ns-container">
                <div class="ns-cats__grid">
                    <?php
                    $ns_categories = [
                        [ 'slug' => 'homme',  'label' => 'HOMME'  ],
                        [ 'slug' => 'femme',  'label' => 'FEMME'  ],
                        [ 'slug' => 'enfant', 'label' => 'ENFANT' ],
                    ];
                    foreach ( $ns_categories as $item ) {
                        $term = get_term_by( 'slug', $item['slug'], 'product_cat' );
                        if ( ! $term || is_wp_error( $term ) ) { continue; }
                        $thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                        $img_url = $thumb_id ? wp_get_attachment_image_url( (int) $thumb_id, 'large' ) : '';
                        $style   = $img_url ? 'style="background-image:url(' . esc_url( $img_url ) . ');"' : '';
                        $link    = get_term_link( $term );
                        ?>
                        <div class="ns-card ns-card--tile" <?php echo $style; ?>>
                            <div class="ns-card__body">
                                <h3><?php echo esc_html( $item['label'] ); ?></h3>
                                <a class="ns-btn ns-btn--ghost" href="<?php echo esc_url( $link ); ?>">Explorer</a>
                            </div>
                        </div>
                    <?php } ?>
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

        <!-- Statement brand section -->
        <section class="ns-statement">
            <div class="ns-container ns-statement__inner">
                <div class="ns-statement__text">
                    <h2>Next Step, ce n’est pas qu’une paire de sneakers, c’est une culture.</h2>
                    <p class="ns-statement__claim"><span>SNEAKERS.</span> <span>STYLE.</span> <span>STATEMENT.</span></p>
                </div>
                <div class="ns-statement__visual"></div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="ns-newsletter">
            <div class="ns-container ns-newsletter__inner">
                <div class="ns-newsletter__copy">
                    <h2 class="ns-title-lg">Reçois les drops en avant-première</h2>
                    <p class="ns-subtitle">Des actus courtes, zéro spam. Désinscription en 1 clic.</p>
                </div>
                <form class="ns-form" action="#" method="post">
                    <input class="ns-input" type="email" name="email" placeholder="Ton email" required>
                    <button class="ns-btn ns-btn--primary" type="submit">S’inscrire</button>
                </form>
            </div>
        </section>

    </main>

<?php get_footer();
