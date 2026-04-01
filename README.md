# BioSachet Togo

Application Laravel pour la gestion commerciale, productive et administrative d'une activite de sachets biodegradables a base d'amidon de manioc au Togo.

Le projet couvre deux volets :
- un site public vitrine oriente prise de contact et demande via WhatsApp
- un back-office interne pour suivre produits, productions, commandes, paiements, rapports et stock

## Points cles

- Catalogue public verrouille a 4 references officielles :
  - `PETIT SACHET TRANSPARENT`
  - `SACHET MOYEN SOUPLE`
  - `GRAND SACHET EPAIS ET SOLIDE`
  - `FILM PLASTIQUE BIODEGRADABLE`
- Tunnel public sans paiement en ligne :
  - le panier prepare un message WhatsApp pre-rempli
  - la validation commerciale se fait manuellement sur WhatsApp
- Module production journaliere avec 4 champs metier :
  - `sachets_petit_transparent`
  - `sachets_moyen_souple`
  - `sachets_grand_solide`
  - `film_biodegradable_m2`
- Recettes, notes de production, temps de sechage et proprietes stockes au niveau produit
- Exports admin :
  - impact environnemental
  - finance
  - production par type
- API Sanctum pour usage mobile/futur front externe

## Stack

- PHP 8.3+
- Laravel 11
- MySQL
- Blade
- Livewire 4
- Tailwind CSS
- Laravel Sanctum
- Laravel Excel
- DomPDF

## Fonctionnalites

### Site public

- Accueil marketing
- Catalogue produits
- Fiche detail produit par `slug`
- Panier public
- Redirection de demande vers WhatsApp avec message automatique
- Contact
- Suivi de commande
- Telechargement de devis

### Administration

- Dashboard
- Produits
- Clients
- Commandes
- Productions
- Stock matiere
- Paiements
- Rapports
- Alertes
- Journaux d'activite
- Gestion des comptes admin

## Catalogue officiel

Les 4 produits officiels sont seedes et verrouilles dans l'application.

Chaque produit contient :
- `slug`
- `usage_ideal`
- `description`
- `format`
- `prix_unitaire`
- `cout_revient`
- `stock_disponible`
- `recette` JSON
- `notes_production`
- `sechage_heures_min`
- `sechage_heures_max`
- `proprietes` JSON

## Architecture metier

### Commande publique

Le site public ne cree plus de commande finalisee en ligne.

Le parcours est :
1. le visiteur ajoute des produits au panier
2. il renseigne ses informations
3. le site genere un message WhatsApp pre-rempli
4. l'equipe confirme manuellement la suite

### Commande admin

Les vraies commandes metier restent gerees depuis l'administration et peuvent :
- reserver du stock
- etre livrees
- decrementer le stock lors de la livraison
- enregistrer des paiements

### Production

La production journaliere suit :
- le manioc utilise
- les 3 types de sachets
- le film biodegradable en `m2`

Les recettes des 4 types sont affichees dans le formulaire de production comme aide rapide.

## Base de donnees

Le schema a ete aligne pour MySQL avec :
- tables metier critiques converties en `InnoDB`
- cles etrangeres reelles
- migration de rattrapage pour les anciennes bases

## Installation locale

### 1. Dependencies

```bash
composer install
npm install
```

### 2. Environnement

```bash
copy .env.example .env
php artisan key:generate
```

Configurer ensuite la base MySQL dans `.env`.

Variables projet utiles :

```env
APP_URL=http://localhost/biosachet-togo/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biosachet_togo
DB_USERNAME=root
DB_PASSWORD=

BIOSACHET_PHONE="+228 92 31 79 78"
BIOSACHET_EMAIL="contact@biosachet-togo.tg"
BIOSACHET_ADDRESS="Lome, Togo"
BIOSACHET_WHATSAPP=22892317978
```

### 3. Base de donnees

```bash
php artisan migrate --seed
```

### 4. Assets

```bash
npm run build
```

Pour le developpement front :

```bash
npm run dev
```

### 5. Lancement

```bash
php artisan serve
```

## Comptes de demonstration

Mot de passe seed : `password`

- `admin@biosachet-togo.tg`
- `operations@biosachet-togo.tg`
- `finance@biosachet-togo.tg`

## Exports disponibles

- rapport impact environnemental PDF / Excel
- rapport financier PDF / Excel
- rapport production par type Excel / CSV

## Commandes utiles

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan route:list
php artisan test
```

## Tests

La suite automatisee couvre notamment :
- authentification
- back-office admin
- catalogue officiel
- panier public et redirection WhatsApp
- suivi public
- exports admin

Etat valide au moment de la mise a jour :

```bash
php artisan test
# 39 passed
```

## Notes importantes

- `.env` n'est pas versionne
- `vendor/` et `node_modules/` sont ignores par Git
- le panier public sert a lancer une discussion WhatsApp, pas a encaisser en ligne
- la gestion complete des commandes et paiements reste cote administration
