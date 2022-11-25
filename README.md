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
## Neste momento o container Docker estará usando a porta 8080
### Escutando então na url http://localhost:8080

---

### Para Efetuar o login na api use uma request POST para /api/login_check com a seguinte estrutura:
> {
> "username":"admin¨,
> "password":"teste1234"
> }
### Então receberá um token para poder realizar as requisições.

___
### Observação:
#### Utilizando -se no navegador da url '/api' será exibido o <span style="color: gold">api-plataform</span>, onde podemos observar todos os métodos das entidades cadastradas.

---
## Estrutura para requisições:
#### Category:
##### x-www-form-urlencoded ou raw/json
> {
> "name": "string",
> }

#### Metodos:
* Para obter todas as categorias use GET para "/api/categories"
* Para obter uma categoria pelo seu id use GET para "/api/categories/<span style='color: green'>id desejado</span>"
* Para cadastrar uma nova categoria use POST para "/api/categories/create"
* Para atualizar uma categoria pelo seu id use GET para "/api/categories/update/<span style='color: green'>id desejado</span>"
* Para deletar uma categoria pelo seu id use GET para "/api/categories/delete/<span style='color: green'>id desejado</span>"

#### Products:
##### x-www-form-urlencoded ou raw/json

>{"code": "string",
"name": "string",
"price": 0,
"pricePromotion": 0,
"tax": 0,
"promotion": true,
"active": true,
"category": "string"}

#### Metodos:
* Para obter todos os produtos use GET para "/api/products"
* Para obter um produto pelo seu id use GET para "/api/products/<span style='color: green'>id desejado</span>"
* Para cadastrar um novo produto use POST para "/api/products/create"
* Para atualizar um produto pelo seu id use GET para "/api/products/update/<span style='color: green'>id desejado</span>"
* Para deletar um produto pelo seu id use GET para "/api/products/delete/<span style='color: green'>id desejado</span>"

----

### Desafios encontrados:

Desconhecimento do framework fez me estudar ele em poucos dias e aprender o básico, levendo em conta a similaridade com laravel,
dentro da empresa que estou atualmente, tenho tido mais contato com o front.

O crud tem muito a crescer e melhorar, eu tenho um projeto pessoal que se chama osfácil, comecei ele em php puro e vou refatorar em laravel.
Gostei muito da oportunidade, onde pude me desafiar em poucos dias a aprender um novo framework.

Eu acredito que tudo pode ser aprendido, quando se tem força de vontade.

Obrigado time Tiki pela oportunidade de me desafiar!

Roger Cheruti