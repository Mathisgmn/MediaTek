# MediaTek-Demo

## 01 – Entrées / Sorties

### Documentation

- [PHP: Fonctions sur les chaînes de caractères - Manual](https://www.php.net/manual/fr/ref.strings.php)

### Éléments additionnels

1. Méthode de soumission des données
    - `$_SERVER['REQUEST_METHOD']`
    - Gestion de l'erreur correspondante (redirection, code de statut HTTP)
2. Champ requis (obligatoire)
    - Rappel : les données du formulaire sont récupérées dans un tableau (ici, `$_GET`) de chaînes de caractères (`string`)
    - `isset($_GET['champ'])`
    - `trim($_GET['champ']) !== ''`
    - Gestion de l'erreur correspondante (redirection, code de statut HTTP)  
3. Spécifications (format des données)
    - Taille (ex. : nombre de caractères min. et max.) : `strlen()`
    - Format spécifique (ex. : email, date, etc.) : utilisation des expressions régulières (*regex*)
    - Gestion de l'erreur correspondante (redirection, code de statut HTTP)
4. Cas particulier des fichiers uploadés
    - Rappel : le traitement des fichiers uploadés se fait via un tableau distinct (`$_FILES`)
    - Réussite ou échec de l'upload : `$_FILES['champ']['error']`
    - Spécifications (cas d'une image)
        - Poids du fichier (octets) : `$_FILES['champ']['size']`
        - Type de fichier (ex. : image) : `getimagesize()` et/ou classe `finfo` 
        - Format du fichier (ex. : JPEG ou PNG) : `getimagesize()` et/ou classe `finfo` 
        - Dimensions (hauteur × largeur) : `getimagesize()` et/ou classe `finfo`
        - Nom du fichier (ex. : nombre de caractères min. et max.) : `strlen()`
    - Gestion de l'erreur correspondante (redirection, code de statut HTTP)

## 02 - Contrôle d'accès : authentification

### Documentation

- [PHP Regular Expressions | W3Schools](https://www.w3schools.com/php/php_regex.asp)
- [Hachage des mots de passe de manière sûre et sécurisée | PHP Manual](https://www.php.net/manual/fr/faq.passwords.php)
- [How to Secure hash and salt for PHP passwords | by Mrityunjay Singh | Medium](https://medium.com/@mrityunjay.webmaster/how-to-secure-hash-and-salt-for-php-passwords-54f1c9d268a6)

### Éléments additionnels

1. *À venir si besoin*

## 03 - Contrôle d'accès : autorisations

### Documentation

- *À venir si besoin*

### Éléments additionnels

1. *À venir si besoin*

## Avertissement

Ce dépôt a été conçu à des fins pédagogiques pour illustrer des concepts et des principes spécifiques. Le code n'est pas destiné à être utilisé en production, car il peut ne pas répondre aux exigences de qualité, de robustesse et de performance nécessaires dans un environnement professionnel. Il sert uniquement à des fins d'apprentissage et ne doit pas être considéré comme un modèle de développement. Ce code est donc fourni à des fins éducatives et sans engagement de performance ou de fiabilité.
