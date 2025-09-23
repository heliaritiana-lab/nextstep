<?php
/* Page: À propos de Next Step (slug: a-propos) */
get_header(); ?>

<main id="primary" class="ns-about">

    <!-- HERO -->
    <section class="ns-about__hero">
        <div class="ns-container ns-about__hero__inner">
            <div class="ns-about__hero__text">
                <p class="ns-eyebrow">Notre histoire</p>
                <h1 class="ns-title-xl">À propos de Next Step</h1>
                <p class="ns-subtitle">Nous sélectionnons des sneakers avec exigence pour que chaque pas compte. Durable, stylé, simple.</p>
            </div>
        </div>
    </section>

    <!-- Mission + Valeurs -->
    <section class="ns-about__blocks">
        <div class="ns-container ns-about__blocks__grid">
            <div class="ns-about__block">
                <h2 class="ns-title-lg">Notre mission</h2>
                <p>Rendre l’expérience sneakers claire et inspirante. Proposer des paires fiables, livrées vite, au service d’un style assumé.</p>
            </div>
            <div class="ns-about__block">
                <h2 class="ns-title-lg">Nos valeurs</h2>
                <ul class="ns-list">
                    <li>Authenticité — produits vérifiés et descriptions transparentes.</li>
                    <li>Service — livraison rapide, retours faciles, support réactif.</li>
                    <li>Style — une curation pointue pour des looks sans effort.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Chiffres clés -->
    <section class="ns-about__stats">
        <div class="ns-container ns-about__stats__grid">
            <div class="ns-stat"><span>48h</span><small>Moyenne d’expédition</small></div>
            <div class="ns-stat"><span>+4.8/5</span><small>Note clients</small></div>
            <div class="ns-stat"><span>2000+</span><small>Commandes livrées</small></div>
            <div class="ns-stat"><span>100%</span><small>Paiement sécurisé</small></div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="ns-about__timeline">
        <div class="ns-container">
            <h2 class="ns-title-lg">Les étapes</h2>
            <ol class="ns-timeline">
                <li>
                    <div class="ns-timeline__dot"></div>
                    <div class="ns-timeline__content">
                        <h3>Lancement</h3>
                        <p>La boutique ouvre avec une première sélection de classiques revisités.</p>
                    </div>
                </li>
                <li>
                    <div class="ns-timeline__dot"></div>
                    <div class="ns-timeline__content">
                        <h3>Accélération</h3>
                        <p>Développement de partenariats et optimisation de la logistique.</p>
                    </div>
                </li>
                <li>
                    <div class="ns-timeline__dot"></div>
                    <div class="ns-timeline__content">
                        <h3>Communauté</h3>
                        <p>Éditions limitées, drops et évènements pour les passionnés.</p>
                    </div>
                </li>
            </ol>
        </div>
    </section>

    <!-- Confiance / USP -->
    <section class="ns-about__usp">
        <div class="ns-container ns-usp__grid">
            <div class="ns-usp__item">✅ Produits vérifiés</div>
            <div class="ns-usp__item">↩️ Retours 14 jours</div>
            <div class="ns-usp__item">🚚 Livraison rapide</div>
            <div class="ns-usp__item">🔒 Paiement sécurisé</div>
        </div>
    </section>

    <!-- CTA -->
    <section class="ns-about__cta">
        <div class="ns-container ns-about__cta__inner">
            <div>
                <h2 class="ns-title-lg">Rejoins la communauté</h2>
                <p class="ns-subtitle">Inscris-toi pour recevoir les nouveautés et drops en avant-première.</p>
            </div>
            <form class="ns-form" action="#" method="post">
                <input class="ns-input" type="email" name="email" placeholder="Ton email" required>
                <button class="ns-btn ns-btn--primary" type="submit">S’inscrire</button>
            </form>
        </div>
    </section>

</main>

<?php get_footer();


