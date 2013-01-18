themoviedb-webfrontend
======================
Awesome way to manage your rated movies, search, watchlist and more.

DEMO
======================
http://www.sierag.nl/movie/

FEATURES
======================
- Responsive Wedesign
- Slide through your movies with keyboard navigation
- Loading only the images when needed (by Lazy loading) 
- Displaying all movies in one screen (Masonry)
- Searching movies in local database and on themoviedb.org
- Import all movies from themoviedb.org that you have rated allready
- Rate a movie and it also will be send to themoviedb.org
- Using the APIv3 from themoviedb.org in combination of this fantasic TMDb-PHP-API wrapper 
- Easy use of known javascript and CSS frameworks as Bootstrap, jQuery.

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

SCREENSHOTS
======================
![Front page](http://github.com/sierag/themoviedb-webfrontend/raw/master/img/screen1.jpg)
![Movie page](http://github.com/sierag/themoviedb-webfrontend/raw/master/img/screen2.jpg)
![Front page iPad](http://github.com/sierag/themoviedb-webfrontend/raw/master/img/ipad1.jpg)
![Movie page iPad](http://github.com/sierag/themoviedb-webfrontend/raw/master/img/ipad2.jpg)


Resources Used
===============
* [TMDb-PHP-API](https://github.com/glamorous/TMDb-PHP-API)
* [Bootstrap](http://getbootstrap.com)
* [FontAwesome](http://fortawesome.github.com/Font-Awesome/)
* [Masonry](http://masonry.desandro.com/)
* [LazyLoading](http://www.appelsiini.net/projects/lazyload)
