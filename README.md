#PHP MVC BOOTSTRAP

Este é um projeto PHP que utiliza o padrão de arquitetura MVC para criar uma aplicação web. Ele se comunica com um banco de dados MariaDB, realiza requisições HTTP, implementa middlewares e expõe uma API.



 Requisitos do Sistema

- PHP 7.4 ou superior
- MariaDB 10.3 ou superior
- Composer (para gerenciamento de dependências)
## Configuração do Ambiente

bash
# Instalar dependências
composer install

# Configurar banco de dados
cp .env.example .env
# Editar o arquivo .env com as configurações do banco de dados
php artisan migrate

Uso de Middlewares
Os middlewares são utilizados para realizar a autenticação do usuário, e se ele está ou não logado, se o conteúdo da página é ou não cacheável, e identifica se a rota é ou não da api assim alterando o tipo de documentação que será recebida.

API
A API do projeto possui os seguintes endpoints:

Usuários:
(GET) /api/v1/users: Retorna a lista de usuários.
(GET) /api/v1/users/me: Retorna o usuário que está sendo utilizado no momento
(GET) /api/v1/users/{id}:  Retorna o usuário do id passado como parâmetro


Depoimentos:
(GET) /api/v1/testimonies: Retorna todos os depoimentos
(GET) /api/v1/testimonies/{id}: Consulta individual de depoimento
(POST) /api/v1/testimonies/: Cadastro de novo depoimento


Contato
Para entrar em contato, envie um e-mail para seu.erikagomes1407@gmail.com.





