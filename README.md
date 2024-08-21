# Gerenciador de carnês

## Como instalar

Softwares obrigatórios:

-   PHP ^8.2
-   Composer 2
-   mysql

Dentro da pasta raiz do projeto você deve criar uma cópia do arquivo ".env.example" dentro da pasta raiz chamada apenas ".env", deve ser preenchidas as variáveis de ambiente de banco de dados no arquivo .env, na raiz do projeto executar o comando "composer install", em seguida o comando "php artisan key:generate" seguido do comando "php artisan migrate" e por último o comando "php artisan serve" e sua aplicação estará disponível na porta 8000

Comandos necessários

-   `cp .env.example .env`
-   `composer install`
-   `php artisan key:generate`
-   `php artisan migrate`
-   `php artisan serve`

## Rotas disponíveis

-   `GET -`
    `/api/generate-invoicing`

-   `GET -`
    `/api/invoicing`

## Postman

-   `https://documenter.getpostman.com/view/12460528/2sAXjDdaNr`
