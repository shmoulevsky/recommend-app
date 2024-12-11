## Demo of Recomendation app


The app contains car features dataset from https://www.kaggle.com/datasets/rupindersinghrana/car-features-and-prices-dataset


In this app I show an example of using pg vector to store embeddings of cars features. This Laravel application utilizes `pgvector` to store and query car feature embeddings for similarity search. Embeddings are calculated by applying Min-Max scaling and one-hot encoding to car attributes such as `mark_id`, `transmission type`, `price` etc.   This Laravel app example can be used as a base template for own projects.

App launches on http://127.200.200.250

App features:

- Project has front and back part
- Installed pg vector extension for PosgresSQL
- Project structured in modules
- Basic auth (JWT auth) and register system
- Swagger (http://127.200.200.250/api/documentation](http://127.200.200.165/api/documentation))
- Vue3
- Laravel 11
- Docker (php 8.3, PosgresSQL with pg vector)

How launch app

- for launch: make up (or ./vendor/bin/sail up)
- to run container bash: make bash (or ./vendor/bin/sail bash)
- install composer dependencies
- php artisan migrate
- php artisan db:seed (seed DB over by 11799 cars from dataset https://www.kaggle.com/datasets/rupindersinghrana/car-features-and-prices-dataset
- in front folder run npm i and npm run dev
- you can change project IP in env (by default http://127.200.200.250))
