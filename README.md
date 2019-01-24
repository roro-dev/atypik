# Atypik'House
Atypik'House est une plateforme permettant la location d'hébergement insolites, ainsi que la mise en location de ses propres biens.

## Pré-requis

- PHP version 7 ou supérieur
- MySQL version 5.7 ou supérieur
- Apache 2.4

## Installation

Installation des composants utiles au projets :
<pre>composer install</pre>

Création de la base de données :
<pre>php bin/console doctrine:database:create</pre>

Générations des requêtes SQL (tables et données) :
<pre>php bin/console make:migration</pre>

Exécution des requêtes SQL générées précédemment :
<pre>php bin/console doctrine:migrations:migrate</pre>

Installation du module de Stripe :
<pre>composer require stripe/stripe-php</pre>

##Identifiants
- Administrateur :
  <pre>E-mail : stefanerodrigues75010@gmail.com<br>Mot de passe : test</pre>