<?php
/* Footer Next Step */
?>
<footer class="ns-footer">
    <div class="ns-container ns-footer__grid">
        <div class="ns-footer__brand">
            <a class="ns-logo" href="<?php echo esc_url( home_url('/') ); ?>">Next Step</a>
            <p class="ns-footer__tag">Sneakers. Style. Statement.</p>
            <p><a href="<?php echo esc_url( get_permalink( get_page_by_path('a-propos') ) ); ?>">À propos de Next Step</a></p>
            <div class="ns-socials">
                <a href="www.instragram.com" aria-label="Instagram" class="ns-socials__link" target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Z" stroke="currentColor" stroke-width="2"/><path d="M16.5 7.5h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2"/></svg>
                </a>
                <a href="www.tiktok.com" aria-label="TikTok" class="ns-socials__link" target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M21 8.5c-2.6 0-4.9-1.6-5.7-3.9V18a6 6 0 1 1-6-6c.4 0 .8 0 1.2.1V9.1A9.5 9.5 0 0 0 9.3 9a8 8 0 1 0 8 8V8.7A8 8 0 0 0 21 10V8.5Z"/></svg>
                </a>
                <a href="www.facebook.com" aria-label="Facebook" class="ns-socials__link" target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M13 9h3V6h-3c-1.7 0-3 1.3-3 3v2H7v3h3v7h3v-7h3l1-3h-4V9c0-.6.4-1 1-1Z"/></svg>
                </a>
                <a href="www.x.com" aria-label="X" class="ns-socials__link" target="_blank" rel="noopener">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M3 3h3.5L14 14.3 20.8 3H23l-8.5 13.9L21.3 21H17.8l-6-7.4L7.2 21H1l9.1-14.8L6.2 3Z"/></svg>
                </a>
            </div>
        </div>

        <div class="ns-footer__col">
            <h3 class="ns-footer__title">Explorer</h3>
            <ul class="ns-footer__list">
                <li><a href="<?php echo esc_url( add_query_arg( ['orderby' => 'date'], wc_get_page_permalink('shop') ) ); ?>">Nouveautés</a></li>
                <li><a href="<?php echo esc_url( get_term_link( 'homme', 'product_cat' ) ); ?>">Homme</a></li>
                <li><a href="<?php echo esc_url( get_term_link( 'femme', 'product_cat' ) ); ?>">Femme</a></li>
                <li><a href="<?php echo esc_url( get_term_link( 'enfant', 'product_cat' ) ); ?>">Enfant</a></li>
            </ul>
        </div>

        <div class="ns-footer__col">
            <h3 class="ns-footer__title">Support</h3>
            <ul class="ns-footer__list">
                <li><a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>">Boutique</a></li>
                <li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Panier</a></li>
                <li><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">Commander</a></li>
                <li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>">Mon compte</a></li>
            </ul>
        </div>

        <div class="ns-footer__col">
            <h3 class="ns-footer__title">Légal</h3>
            <ul class="ns-footer__list">
                <li><a href="<?php echo esc_url( get_permalink( get_page_by_path('mentions-legales') ) ); ?>">Mentions légales</a></li>
                <li><a href="<?php echo esc_url( get_permalink( get_page_by_path('cgv') ) ); ?>">CGV</a></li>
                <li><a href="<?php echo esc_url( get_permalink( get_page_by_path('politique-de-confidentialite') ) ); ?>">Politique de confidentialité</a></li>
                <li><a href="<?php echo esc_url( get_permalink( get_page_by_path('cookies') ) ); ?>">Cookies</a></li>
            </ul>
        </div>
    </div>

    <div class="ns-footer__bottom">
        <div class="ns-container ns-footer__bottom__inner">
            <p>© <?php echo date('Y'); ?> Next Step — Tous droits réservés.</p>
            <p>Fait avec passion pour les sneakers.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>


