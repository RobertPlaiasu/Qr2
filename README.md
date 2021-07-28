# QRMenu

QrMenu reprezinta o solutie pentru terasele si restaurantele din tara ce doresc sa inlocuiasca ideea de meniu fizic cu unul digital.

## Tehnologii

Ce tehnologii am utilizat:

- Docker pentru a creea enviromentul
- Laravel pentru partea de backend
- Inertia.js pentru ca aplicatia sa fie SPA
- Vue.js pentru partea de front-end

## Ghid de instalare

- `docker-compose up -d --build site`
- `docker-compose run --rm composer install`
- `docker-compose run --rm npm install`
- `docker-compose run --rm npm run dev`
- `docker-compose run --rm artisan key:generate`
- `docker-compose run --rm artisan storage:link`

## Pachete utilizate

- Laravel Cashier(Stripe) (https://laravel.com/docs/8.x/billing)
- Laravel Fortify(https://laravel.com/docs/8.x/fortify)
- Laravel Jetstream(https://jetstream.laravel.com/2.x/introduction.html)
- Laravel Socialite (https://laravel.com/docs/8.x/socialite)
- Generatorul de QR (https://github.com/SimpleSoftwareIO/simple-qrcode)

## Comenzi docker

- `docker-compose up -d --build site` - pentru ca docker-ul functioneaza
- `docker-compose run --rm composer` - pentru composer
- `docker-compose run --rm npm` - pentru npm
- `docker-compose run --rm artisan ` - pentru artisan 

## Creareea folderului mysql(optional)

Pentru ca baza de date sa fie persistenta si dupa ce proiectul este inchis trebuie urmate urmatoarele instrunctiuni

1. crearea unui folder mysql, langa `nginx` si `src` .
2. Adaugarea liniilor in `docker-compose.yml` :

```
volumes:
  - ./mysql:/var/lib/mysql
```

## Ce dificultati am intampinat

- Intelegerea conceptului de SPA si de a invata Inertia.js care este inca la inceput si resursele sunt putine.
- Utilizarea TDD-ului pentru a creea aplicatia, consumand mult timp pretios pentru a scrie teste unitare
- Utilizarea pachetului de generare a QR-ului
- Modul cum functioneaza Stripe ca sistem de plati si cum functioneaza pachetul de la laravel Cashier
- Creare unui enviorement pentru lucru local in docker

## Functionalitati

- Sistem de plati
- CRUD Restaurant
- CRUD Meniu
- CRUD Categorii
- CRUD Roluri
- Sistem de roluri bazat pe permisiuni asemanator cu cel dintr-un CRM
- CRUD Judete
- CRUD Orase
- CRD Promotii
- CRD Produse
- Generare de QR pentru meniu

