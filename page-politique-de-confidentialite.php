<?php
/* Page: Politique de confidentialité (slug: politique-de-confidentialite) */
get_header(); ?>

<main id="primary" class="ns-legal ns-privacy">

    <section class="ns-legal__hero">
        <div class="ns-container">
            <h1 class="ns-title-xl">Politique de confidentialité</h1>
            <p class="ns-subtitle">Comment <?php bloginfo('name'); ?> collecte, utilise et protège vos données.</p>
        </div>
    </section>

    <section class="ns-container ns-legal__content">
        <article class="ns-legal__card" style="max-width:900px;margin:0 auto;">
            <h2 class="ns-title-lg">1. Responsable du traitement</h2>
            <p>Le responsable du traitement est la société éditrice de <?php bloginfo('name'); ?> (ci‑après « Nous »), joignable à l’adresse <a href="mailto:<?php echo antispambot( get_option('admin_email') ); ?>"><?php echo antispambot( get_option('admin_email') ); ?></a>.</p>

            <h2 class="ns-title-lg">2. Données collectées</h2>
            <p>Nous collectons des données nécessaires à la gestion de vos commandes et de votre compte : identité, coordonnées, adresses de livraison et de facturation, historique d’achats, moyens de paiement (derniers chiffres et jetons de transaction uniquement), préférences produits et données techniques de navigation (adresse IP, navigateur, pages consultées, cookies).</p>

            <h2 class="ns-title-lg">3. Finalités et bases légales</h2>
            <p>Les données sont traitées pour : (i) exécuter le contrat (commande, paiement, livraison, service client), (ii) respecter nos obligations légales (comptabilité, lutte contre la fraude), (iii) l’intérêt légitime (amélioration du site, prévention des abus, statistiques), (iv) votre consentement (newsletter, cookies non essentiels).</p>

            <h2 class="ns-title-lg">4. Destinataires</h2>
            <p>Vos données peuvent être transmises à nos prestataires techniques et logistiques (paiement, hébergement, transport, emailing) strictement pour les finalités énoncées. Nous ne vendons pas vos données.</p>

            <h2 class="ns-title-lg">5. Durées de conservation</h2>
            <p>Les comptes inactifs sont conservés jusqu’à 3 ans après le dernier contact. Les documents de facturation sont conservés 10 ans. Les données liées aux cookies sont conservées selon leur finalité, jusqu’à 13 mois pour les cookies de mesure d’audience. Les newsletters sont conservées jusqu’au retrait du consentement.</p>

            <h2 class="ns-title-lg">6. Vos droits</h2>
            <p>Vous disposez de droits d’accès, rectification, effacement, limitation, opposition, portabilité, et du droit de définir des directives post‑mortem. Pour les exercer : <a href="mailto:<?php echo antispambot( get_option('admin_email') ); ?>"><?php echo antispambot( get_option('admin_email') ); ?></a>. Vous pouvez introduire une réclamation auprès de la CNIL.</p>

            <h2 class="ns-title-lg">7. Sécurité</h2>
            <p>Nous mettons en œuvre des mesures techniques et organisationnelles adaptées : chiffrement des transactions, contrôle d’accès, journalisation, sauvegardes et politique de gestion des incidents.</p>

            <h2 class="ns-title-lg">8. Paiements</h2>
            <p>Les paiements sont opérés par un prestataire certifié. Nous n’avons pas accès aux données complètes de votre carte bancaire ; seuls les identifiants techniques (tokens) et les 4 derniers chiffres sont conservés.</p>

            <h2 class="ns-title-lg">9. Prospection et newsletter</h2>
            <p>Vous pouvez recevoir des emails concernant nos actualités si vous y consentez. Vous pouvez vous désinscrire à tout moment via le lien présent dans chaque message ou en nous contactant.</p>

            <h2 class="ns-title-lg">10. Transferts hors UE</h2>
            <p>En cas de transfert hors UE par certains sous‑traitants, nous exigeons des garanties appropriées (clauses contractuelles types, pays adéquats, mesures complémentaires).</p>

            <h2 class="ns-title-lg">11. Cookies</h2>
            <p>Pour en savoir plus sur les traceurs utilisés et paramétrer vos choix, consultez notre page <a href="<?php echo esc_url( get_permalink( get_page_by_path('cookies') ) ); ?>">Cookies</a>.</p>

            <h2 class="ns-title-lg">12. Modifications</h2>
            <p>Nous pouvons mettre à jour la présente politique pour refléter des évolutions légales ou opérationnelles. La date de mise à jour sera précisée en en‑tête. Nous vous invitons à la consulter régulièrement.</p>
        </article>
    </section>

</main>

<?php get_footer();


