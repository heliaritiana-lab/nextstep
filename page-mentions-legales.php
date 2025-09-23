<?php
/* Page: Mentions légales (slug: mentions-legales) */
get_header(); ?>

<main id="primary" class="ns-legal ns-mentions">

    <section class="ns-legal__hero">
        <div class="ns-container">
            <h1 class="ns-title-xl">Mentions légales</h1>
            <p class="ns-subtitle">Informations légales relatives au site e‑commerce <?php bloginfo('name'); ?>.</p>
        </div>
    </section>

    <section class="ns-container ns-legal__content">
        <article class="ns-legal__card" style="max-width:900px;margin:0 auto;">
            <h2 class="ns-title-lg">Éditeur du site</h2>
            <p><strong><?php bloginfo('name'); ?></strong> — Société: <em>Raison sociale / Statut</em> — Siège: <em>Adresse complète</em> — Capital social: <em>€</em> — RCS/SIREN: <em>123456789</em> — TVA: <em>FR26 567890123</em> — Directeur de la publication: <em>Nom Prénom</em>. Contact: <a href="mailto:<?php echo antispambot( get_option('admin_email') ); ?>"><?php echo antispambot( get_option('admin_email') ); ?></a>.</p>

            <h2 class="ns-title-lg">Hébergeur</h2>
            <p><strong><em>OVH</em></strong>, 2 rue Kellermann, 59100 Roubaix, France. Tél.: <em>+33 4 56 67 78 89</em>.</p>

            <h2 class="ns-title-lg">Propriété intellectuelle</h2>
            <p>Le Site et l’ensemble de ses éléments (textes, visuels, logos, marques) sont protégés par le droit de la propriété intellectuelle. Toute reproduction, représentation, adaptation ou exploitation, totale ou partielle, est interdite sans autorisation écrite préalable.</p>

            <h2 class="ns-title-lg">Données personnelles</h2>
            <p>Les traitements de données sont réalisés conformément à la réglementation en vigueur. Pour plus d’informations, consultez la <a href="<?php echo esc_url( get_permalink( get_page_by_path('politique-de-confidentialite') ) ); ?>">Politique de confidentialité</a> et la page <a href="<?php echo esc_url( get_permalink( get_page_by_path('cookies') ) ); ?>">Cookies</a>. Vous disposez de droits d’accès, de rectification, d’opposition et d’effacement.</p>

            <h2 class="ns-title-lg">Responsabilité</h2>
            <p><?php bloginfo('name'); ?> s’efforce de garantir l’exactitude des informations publiées. Toutefois, des erreurs peuvent subsister ; l’utilisateur est invité à vérifier les informations et reste responsable de l’usage qu’il en fait.</p>

            <h2 class="ns-title-lg">Liens externes</h2>
            <p>Le Site peut contenir des liens vers d’autres sites. Le Vendeur décline toute responsabilité quant au contenu et aux pratiques de ces sites tiers.</p>

            <h2 class="ns-title-lg">Conditions commerciales</h2>
            <p>Les modalités de commande, de livraison, de retour et de garanties sont détaillées dans nos <a href="<?php echo esc_url( get_permalink( get_page_by_path('cgv') ) ); ?>">Conditions Générales de Vente</a>.</p>

            <h2 class="ns-title-lg">Crédits</h2>
            <p>Conception et développement: <strong>Next Step</strong>. Thème WordPress & WooCommerce personnalisé.</p>
        </article>
    </section>

</main>

<?php get_footer();


