# Catálogo de Produtos

## Esta API é um CRUD de Produtos e Categorias.

### Após clonar o repositório seguir os passos a seguir:

* #### Iniciar o docker:
> docker compose up -d --build
---
* #### Abra o terminal do container php:
> docker exec -it php bash
---
* #### Inicie o bando de dados
> php bin/console doctrine:database:create
___
* #### Rode o migration
> php bin/console doctrine:migrations:migrate
___
* #### Rode o seeder
> php vendor/bin/phinx seed:run
___
