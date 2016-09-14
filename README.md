bubble
======

A Symfony project created on September 14, 2016, 9:41 am.



Install
=======

* Install dependance :
 > composer.phar update

* Create DB :
Configurer le app/config/parameters.yml avec vos identifiants db puis :
 > php app/console doctrine:database:create
 
* Update DB :
 > php app/console doctrine:schema:update --dump-sql
 
 > php app/console doctrine:schema:update --force

* Run server :
 > php app/console server:run
 
 
 
Usage
=====

* /  ==> liste des shop créés
* /shop ==> liste des shop créés
* /shop/create ==> Creation d'un shop 
* /shop/get/[id] ==> detail d'un shop (JSON)
* /shop/Set/[id] ==> mise à jour d'un shop

