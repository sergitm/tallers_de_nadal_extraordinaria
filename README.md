Aquest readme es llegeix millor a la pàgina de [GitHub].(https://github.com/striado/tallers_de_nadal_extraordinaria)<br/>

El fitxer amb les dades dels alumnes s'ha de col·locar a /storage/app/ i s'ha de dir llista.txt.

## DESPLEGAMENT

A més d'arrencar el servidor amb "php artisan serve", s'ha d'obrir el terminal i fer les següents comandes:

* C:\laragon\www\
* λ cd tallers_de_nadal_extraordinaria\ 
<br/>

* C:\laragon\www\tallers_de_nadal_extraordinaria(main -> origin)
* λ npm install
<br/>

* C:\laragon\www\tallers_de_nadal_extraordinaria(main -> origin)
* λ npm run dev
<br/>

D'aquesta manera engeguem el Vite, que es la forma en la que he implementat bootstrap SI NO NO HO TROBARÀ

Fer "php artisan migrate" per crear la base de dades.

Els canvis que he realitzat al .env son els següents:
1. Afegir les línies referents al OAuth2 de Google (No les he esborrat perque tancaré el projecte de Google Cloud quan acabi el curs).
2. Donar-li el nom a la base de dades a través de la variable d'entorn DB_DATABASE.
3. Canviar el FILESYSTEM_DISK a public per utilitzar el mode de disc public amb les imatges dels tallers (De totes formes utilitzo tant el mode de disc public com el mode de disc local per a què el fitxer d'importació d'alumnes llista.txt no sigui públic).
****

## PUNTS DESENVOLUPATS

* Les fases 1 i 2 estan completes. 
* De la fase 3 m'ha quedat per fer les pàgines personalitzades dels errors HTTP. He fet una mica de gestió d'errors (sobretot de l'error 403 quan els permisos no son suficients, detectat per middlewares), però no he creat pàgines personalitzades dels diferents errors HTTP. A més, el llistat de tallers ho he fet amb format Accordion enlloc de Card, ja que els Accordions de Bootstrap hereden de les Cards i són més interactius. Per tant, he considerat que l'ús d'Accordions enlloc de Cards està justificat.
* He fet servir Middlewares per gestionar la redirecció dels usuaris que no estàn logats a la pàgina de Login, i per mostrar un error 403 si un usuari sense els permisos suficients accedeix força la connexió a una pàgina que no deu.
****

## EXPLICACIÓ DE LES FUNCIONALITATS, CASUÍSTIQUES DE CADA FUNCIONALITAT I LA MEVA INTERPRETACIÓ DE L'ENUNCIAT

He considerat que la creació de tallers es realitzi en dos passos, un d'ells inclou l'acció d'un administrador. 
1. Pas 1. L'alumne (autenticat) accedeix al formulari de creació de tallers i crea el taller. Aquest es crearà i quedarà a la BBDD de forma inactiva, és a dir, no es veurà per a ningú que no sigui un administrador.
2. Pas 2. Un administrador accedeix a la pàgina de modificació de tallers i posa el taller com a ACTIU. D'aquesta forma, el taller queda aprovat i els alumnes s'hi podràn apuntar.

Casuístiques de la creació de tallers: 

* Un alumne que crea un taller no s'hi apunta automàticament, ja que un alumne pot crear múltiples tallers si té bones propostes i sería difícil determinar l'ordre de prioritat, així que he considerat que es millor donar banda ampla a la creació de tallers i que s'apuntin als que vulguin (sempre i quan un administrador hagi aprovat el taller) segons l'ordre de prioritat que l'alumne consideri i fins a un màxim de 3. A dalt de tot de la llista de tallers hi ha un comptador de tallers que es posarà en verd un cop l'alumne s'hagi apuntat a 3 tallers, si s'ha apuntat a menys, el missatge serà vermell. A la dreta, hi haurà un missatge informatiu sobre les dates inicial i final per apuntar-se als tallers (sempre que hi hagi dates especificades per administració).

* Els tallers només es podràn crear si:
    1. L'alumne està autenticat.
    2. No hi ha especificada una data per crear tallers (disponible per administradors a la pàgina d'administració) ja que si no hi han dates ho he considerat com a via lliure.
    3. Hi ha una data inicial i final per crear tallers, i el dia d'avui es troba entre aquestes dates, és a dir, si encara no ha arribat la data inicial o ja ha passat la data final, no deixa crear tallers.

* Un usuari només es podrà apuntar a un taller si:
    1. L'usuari està autenticat i és un alumne (doncs els professors i administradors no s'apunten com a participants sino com a encarregats).
    2. No hi ha especificada una data per escollir tallers (disponible per administradors a la pàgina d'administració) ja que si no hi han dates ho he considerat com a via lliure.
    3. Hi ha una data inicial i final per escollir tallers, i el dia d'avui es troba entre aquestes dates, és a dir, si encara no ha arribat la data inicial o ja ha passat la data final, no deixa escollir tallers.

****

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
