<?php
/* Page: Cookies (slug: cookies) */
get_header(); ?>

<main id="primary" class="ns-legal ns-cookies">

    <section class="ns-legal__hero">
        <div class="ns-container">
            <h1 class="ns-title-xl">Cookies</h1>
            <p class="ns-subtitle">Votre navigation, vos choix. Découvrez comment nous utilisons les cookies.</p>
        </div>
    </section>

    <section class="ns-container ns-legal__content">
        <article class="ns-legal__card" style="max-width:900px;margin:0 auto;">
            <h2 class="ns-title-lg">1. Qu’est‑ce qu’un cookie ?</h2>
            <p>Un cookie est un petit fichier texte déposé sur votre terminal (ordinateur, mobile, tablette) lors de votre visite. Il permet de reconnaître votre appareil et d’améliorer votre expérience (panier, connexion, préférences, mesure d’audience, personnalisation).</p>

            <h2 class="ns-title-lg">2. Types de cookies utilisés</h2>
            <p>
                <strong>Cookies strictement nécessaires</strong>: essentiels au fonctionnement du site (authentification, panier, sécurité).<br>
                <strong>Mesure d’audience</strong>: statistiques anonymisées pour améliorer les performances et l’ergonomie.<br>
                <strong>Personnalisation et marketing</strong>: recommandations, suivi des campagnes, retargeting (activés uniquement avec votre consentement).
            </p>

            <h2 class="ns-title-lg">3. Durées de conservation</h2>
            <p>La durée varie selon la finalité : les cookies de session expirent à la fermeture du navigateur ; les cookies d’audience et marketing n’excèdent pas 13 mois.</p>

            <h2 class="ns-title-lg">4. Consentement</h2>
            <p>Au premier accès, une bannière vous permet d’accepter, refuser ou paramétrer les cookies non essentiels. Vous pouvez modifier vos choix à tout moment via les réglages de votre navigateur ou en revenant sur cette page.</p>

            <h2 class="ns-title-lg">5. Paramétrage du navigateur</h2>
            <p>Vous pouvez configurer votre navigateur pour refuser les cookies ou être alerté avant leur dépôt. Le refus des cookies essentiels peut dégrader certaines fonctionnalités (panier, compte).</p>

            <h2 class="ns-title-lg">6. Tiers</h2>
            <p>Certains cookies peuvent être déposés par des tiers (ex : outils d’analyse, réseaux sociaux). Nous vous invitons à consulter leurs politiques pour plus d’informations.</p>

            <h2 class="ns-title-lg">7. Contact</h2>
            <p>Pour toute question relative aux cookies et au consentement, écrivez‑nous à <a href="mailto:<?php echo antispambot( get_option('admin_email') ); ?>"><?php echo antispambot( get_option('admin_email') ); ?></a>.</p>
        </article>
    </section>

</main>

<?php get_footer();


