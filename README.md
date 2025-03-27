# SiteWebBDE
Réalisation du site du BDE Informatique de l'IUT du Havre

Changements par rapport à ce qui a été vu en cours :

- **Le dossier public**
    - Pour que le site fonctionne dans le dossier _public_html_, les fichiers présents dans le dossier public ont été déplacés à la racine.
    - CSS / JS : Ces fichiers seront placés dans assets afin de limiter le nombre de fichiers présents à la racine.

- **Twig**
    - La fonction view de la classe AbstractController a été modifiée pour appeler un fichier Twig au lieu d'un fichier PHP. Le système de passage de paramètres à la vue ne change pas, sauf pour le paramètre title qui, s'il est ajouté, sera utilisé dans la balise _title_.
    - Pour retirer Bootstrap du projet, supprimez les lignes 8 et 86 du fichier base.html.twig.
    - pour installer :
```bash
composer install
```

- **Configuration de la base de données**
    - Pensez à modifier le fichier config.php pour renseigner les bonnes informations de connexion à la base de données (hôte, nom de la base, utilisateur et mot de passe).
      Pour le reste, il n'y a pas de changement majeur. Vous êtes libres d'utiliser des services (notamment pour limiter la duplication du code), mais cela n'est pas obligatoire.

Bon courage !!!
