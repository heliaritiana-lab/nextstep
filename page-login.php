<?php
/**
 * Template de la page de connexion
 * @package Next Step
 */

// Traitement du formulaire de connexion AVANT tout contenu HTML
if ($_POST && isset($_POST['log']) && isset($_POST['pwd'])) {
    $credentials = array(
        'user_login'    => sanitize_user($_POST['log']),
        'user_password' => $_POST['pwd'],
        'remember'      => isset($_POST['rememberme']) ? true : false
    );
    
    $user = wp_signon($credentials, false);
    
    if (!is_wp_error($user)) {
        // Redirection après connexion réussie
        $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url('/');
        wp_redirect($redirect_to);
        exit;
    } else {
        $login_error = $user->get_error_message();
    }
}

get_header(); ?>

<main id="primary" class="ns-login-page">
    
    <!-- Hero section -->
    <section class="ns-login__hero">
        <div class="ns-container">
            <div class="ns-login__hero-content">
                <h1 class="ns-title-xl">Connexion</h1>
                <p class="ns-subtitle">Accédez à votre compte Next Step</p>
            </div>
        </div>
    </section>

    <!-- Formulaire de connexion -->
    <section class="ns-login__form-section">
        <div class="ns-container">
            <div class="ns-login__wrapper">
                
                <!-- Formulaire de connexion -->
                <div class="ns-login__card">
                    <div class="ns-login__header">
                        <h2 class="ns-login__title">Se connecter</h2>
                        <p class="ns-login__subtitle">Entrez vos identifiants pour accéder à votre compte</p>
                    </div>



                    <?php if (isset($login_error)): ?>
                        <div class="ns-login__error">
                            <span class="dashicons dashicons-warning"></span>
                            <?php echo esc_html($login_error); ?>
                        </div>
                    <?php endif; ?>

                    <form class="ns-login__form" method="post" action="">
                        <div class="ns-form__group">
                            <label for="user_login" class="ns-form__label">Email ou nom d'utilisateur</label>
                            <input type="text" 
                                   id="user_login" 
                                   name="log" 
                                   class="ns-form__input" 
                                   placeholder="votre@email.com"
                                   value="<?php echo isset($_POST['log']) ? esc_attr($_POST['log']) : ''; ?>"
                                   required>
                        </div>

                        <div class="ns-form__group">
                            <label for="user_pass" class="ns-form__label">Mot de passe</label>
                            <div class="ns-form__password-wrapper">
                                <input type="password" 
                                       id="user_pass" 
                                       name="pwd" 
                                       class="ns-form__input" 
                                       placeholder="••••••••"
                                       required>
                                <button type="button" class="ns-form__password-toggle" aria-label="Afficher le mot de passe">
                                    <span class="dashicons dashicons-visibility"></span>
                                </button>
                            </div>
                        </div>

                        <div class="ns-login__options">
                            <label class="ns-form__checkbox">
                                <input type="checkbox" name="rememberme" value="forever" <?php checked(isset($_POST['rememberme'])); ?>>
                                <span class="ns-checkbox__custom"></span>
                                Se souvenir de moi
                            </label>
                            <a href="<?php echo wp_lostpassword_url(); ?>" class="ns-login__forgot-link">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <button type="submit" class="ns-btn ns-btn--primary ns-btn--full">
                            Se connecter
                        </button>
                    </form>
                </div>

                <!-- Inscription -->
                <div class="ns-login__card ns-login__card--secondary">
                    <div class="ns-login__header">
                        <h3 class="ns-login__title">Pas encore de compte ?</h3>
                        <p class="ns-login__subtitle">Créez votre compte Next Step et profitez d'avantages exclusifs</p>
                    </div>

                    <div class="ns-login__benefits">
                        <div class="ns-login__benefit">
                            <span class="dashicons dashicons-truck"></span>
                            <span>Livraison gratuite dès 50€</span>
                        </div>
                        <div class="ns-login__benefit">
                            <span class="dashicons dashicons-bell"></span>
                            <span>Accès en avant-première aux nouveautés</span>
                        </div>
                        <div class="ns-login__benefit">
                            <span class="dashicons dashicons-heart"></span>
                            <span>Wishlist personnalisée</span>
                        </div>
                        <div class="ns-login__benefit">
                            <span class="dashicons dashicons-star-filled"></span>
                            <span>Programme de fidélité</span>
                        </div>
                    </div>

                    <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>" class="ns-btn ns-btn--ghost ns-btn--full">
                        Créer un compte
                    </a>
                </div>

            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const passwordToggle = document.querySelector('.ns-form__password-toggle');
    const passwordInput = document.querySelector('#user_pass');
    
    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('.dashicons');
            icon.className = type === 'password' ? 'dashicons dashicons-visibility' : 'dashicons dashicons-hidden';
        });
    }

    // Form validation
    const form = document.querySelector('.ns-login__form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const email = document.querySelector('#user_login').value.trim();
            const password = document.querySelector('#user_pass').value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs');
                return false;
            }
            
            if (email.includes('@') && !email.includes('.')) {
                e.preventDefault();
                alert('Veuillez entrer une adresse email valide');
                return false;
            }
        });
    }
});
</script>

<?php get_footer(); ?>
