# NE PAS OUBLIER :

## Installation des dépendances
effectuer un 
````
composer update
````
Afin d'installer les dependances.

Effectuer un git init dans un terminal pointant vers le dossier de travail "blablafpa"

## Mise en place de la bdd
Modifier le fichier .env selon votre configuration.
    => La base de données suivie de l'adresse de la base de données que l'on a choisi.
    => Bien penser à mettre le nom de la base de données

Effectuer dans le terminal la commande suivante :
````
php bin/console doctrine:database:create
````

## si problème, ne sutout pas nous appeler ;) 
Maël: tfaçon j'ai pas vos nums !vffff

## Installation
Initialiser git dans un dossier de travail avec la commande
````
git init
````

Commentaire de Kiwiii à 10h 
Pour switcher sur une autre branche que MASTER le bonne commande :
git checkout front/template ou git checkout routes/controllers etc...
Le message Switched to branch 'front/template' s'affichera 
Ensuite taper la commande : 
git branch 
pour vérifier que nous sommes bien sur la bonne branche ! 
:D 

Commentaire de Gaëtan à 10h30
La commande : GIT ADD .
ça veut dire je prends tout ce qui y a dans mon répertoire. 
Ensuite on fait la commande : GIT COMMIT -M "enfaite le -M permet de mettre un message"
Puis la commande : GIT PUSH ORIGIN nom-de-la-branche 
WTF maaaaan !?!?

