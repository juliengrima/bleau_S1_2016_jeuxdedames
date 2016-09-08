WcSCmS
======

#### Pré-requis
Avoir "composer" d'installé ==> https://getcomposer.org/doc/00-intro.md

#### Initialisation du projet

1. **SSH** git clone git@github.com:WildCodeSchool/bleau_jeuxdedames.git
2. **HTTPS** git clone https://github.com/WildCodeSchool/bleau_jeuxdedames.git
3. cd jeuxdedames
4. composer install
5. php app/console doctrine:database:create
6. php app/console doctrine:schema:update --force
7. php app/console asset:install

A Symfony project created on June 20, 2016, 11:26 am.
