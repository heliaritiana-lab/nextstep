# 🏷️ Next Step – Site e-commerce sneakers

Projet réalisé avec **WordPress + WooCommerce** en local.  
L’objectif est de mettre en place une boutique en ligne moderne de sneakers, avec importation de produits via un fichier **CSV**.

Lien du github : https://github.com/heliaritiana-lab/nextstep

---

## 🚀 Installation du projet

### 1. Prérequis
- [XAMPP](https://www.apachefriends.org/) ou équivalent (Apache + PHP + MySQL)  
- WordPress installé en local (ici accessible via `http://localhost/wordpress`)  
- Un navigateur moderne (Chrome, Firefox, Edge)

### 2. Mise en place
1. Cloner ou télécharger le projet et placer le dossier dans :  
C:\xampp\htdocs\wordpress


2. **Lancer XAMPP** → démarrer **Apache** (et MySQL même si non utilisé directement).

3. Accéder au site :  
👉 [http://localhost/wordpress](http://localhost/wordpress)  

4. Accéder à l’administration WordPress :  
👉 [http://localhost/wordpress/wp-admin](http://localhost/wordpress/wp-admin)  

Identifiants par défaut :  
- **Utilisateur** : `admin`  
- **Mot de passe** : `admin123`  

---

## 📦 Importation des produits (CSV)
Les produits sont importés depuis un fichier CSV WooCommerce.

1. Aller dans **Produits > Importer**  
2. Sélectionner `products.csv` (fourni dans le projet)  
3. Vérifier le mapping des colonnes (titre, prix, stock, catégorie, image, etc.)  
4. Lancer l’importation → Les produits apparaissent automatiquement dans la boutique.

---

## 🛒 Fonctionnalités principales

### Côté client
- **Catalogue sneakers**
- Produits organisés par catégories : Homme, Femme, Enfant  
- Variations disponibles : tailles, couleurs  
- Stock affiché en texte : *En stock* / *Rupture de stock*  

- **Navigation & recherche**
- Menu principal : Nouveautés, Homme, Femme, Enfant  
- Barre de recherche intégrée dans le header  
- Filtres WooCommerce (par prix, catégorie, disponibilité)  

- **Gestion du panier & commandes**
- Ajout rapide d’articles au panier  
- Validation de commande simplifiée  
- Suivi des commandes depuis l’espace client  

- **Espace compte**
- Inscription / Connexion utilisateur  
- Historique des commandes  
- Gestion des adresses de livraison  

### Côté administrateur
- Import CSV des produits  
- Gestion des stocks  
- Suivi des ventes et commandes  
- Modification des pages via Elementor  

---

## ⚙️ Technologies & plugins utilisés
- **WordPress** – CMS principal  
- **WooCommerce** – gestion e-commerce  
- **Elementor** – page builder  
- **Complianz** – gestion des cookies / RGPD  
- **WP Mail SMTP** – envoi d’emails transactionnels  

👉 Tous les plugins sont inclus dans `wp-content/plugins`.

---

## 🎨 Design & thème
- **Thème enfant personnalisé** basé sur *Orchid Store*  
- Charte graphique :
- Couleurs dominantes : **orange (#ff822e)** et **bleu (#7bc4e9)**  
- Style moderne et dynamique  
- Pages personnalisées avec **Elementor**  
- Footer comprenant :  
- Bloc marque (logo + réseaux)  
- Liens boutique (Homme, Femme, Enfant, Nouveautés)  
- Aide (FAQ, Retours, Livraison, Guide des tailles, Contact)  
- Légal (Mentions légales, CGV, Politique de confidentialité, Cookies)  

---


## Les comptes utilisateurs
Compte Gestionnaire de boutique
identifiant : helia-nextstep
email : fifisland@gmail.com
mot de passe : Ky4B9j2f@iKly5vQ!Qpij*52


Compte Client : 
identifiant : ramandimbisoa.finaritra@gmail.com
email : ramandimbisoa.finaritra@gmail.com
mot de passe : Id8f(0M0@i6shPJMmDTzyOgj

## 👩‍💻 Auteur
Projet développé par **Heliaritiana RAMANDIMBISOA**