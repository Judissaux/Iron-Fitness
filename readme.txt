    - Mettre le dossier IronFitness en place.

    - Taper Composer install pour télécharger les dépendances.

    - Dans le fichier .env, mettre en place les informations de connection de la base de donnée de votre hébergeur.

    - Taper symfony console doctrine:database:create (pour créer la base de donnée ) puis doctrine:migrations:migrate (pour insérer les différentes tables)

    - Créer un compte sur mailJet avec votre adresse e-mail d'herbergeur en n'oubliant pas de bien spécifiant  la nature de votre activité, vos coordonnées et la page de votre politique de confidentialité. (Attention ne pas prendre d'email GMAIL,YAHOO,HOTMAIL en email d'inscription. Utilisez celle de l'hebergeur).

    - Récupérer les clefs Api(public et secrete) et les mettre en place dans le fichier .env

    - Mettre dans /var/www/html/Iron-Fitness/src/Service/MailerService.php, l'adresse mise dans mailjet. 

    - Creer un compte sur Stripe avec les informations de la société.

    - Récupérer les clefs Api(public et secrete) et les mettre en place dans le fichier .env

    - Creer un administrateur dans la base de donnée avec le ["ROLE_ADMIN"] dans la colonne role

    - Connecter vous au site avec votre compte admin et commencer à construire le site blog,exercice,programme,cours collectifs.

    - Vous pouvez modifier des informations du site en vous rendant dans le tableau de bord -> informations du site -> editer.