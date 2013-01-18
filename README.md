themoviedb-webfrontend
======================

Awesome way to manage your rated movies, search, watchlist and more.

DEMO
======================
http://www.sierag.nl/movie/


INSTALLATION
======================

Download to, or Clone on the location you prefer. 
```
# git clone https://github.com/sierag/themoviedb-webfrontend.git
```
Than you will need to make some easy changes to make this work.
```
# mv themoviedb-webfrontend movie
# mv movie/config.php.default movie/config.php
# vi movie/config.php and add the right values
```
Last step is to create the tabel into your database to make it work.
Import db.sql into your database and make sure the table name is movies

