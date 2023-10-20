# Groupe de jezier_c 936467
MUB est un projet Laravel
Pour pouvoir l'executer suite au téléchargement, il faut:
- réaliser la commande "composer install" ou la commande "composer update" 
- créer une database SQL
- créer le fichier .env et y copier le contenu de .env.example
- modifier dans le fichier .env afin que cela corresponde a votre situation : DB_DATABASE, DB_USERNAME et DB_PASSWORD
- effectuer les migrations avec la commande "php artisan migrate"
- lancer le serveur avec la commande "php artisan serve"

Vous avez réussi, bravo :)

Si vous souhaitez donner le droit d'administrateur sur MUB à un utilisateur:
 - rentrer dans la database de MUB*
 - entrer la commande : "UPDATE users SET admin=1 WHERE id={id_utilisateur};"
