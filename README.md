# Projeto Estoque v2 - Symfony

Sistema de estoque refeito em Symfony, com login, cadastro de categorias e de produtos (com entrada e venda de estoque).

Requisitos: PHP 8.4+, Composer, Symfony CLI e MySQL 8.

## Como rodar

1. `cp .env.example .env` (e ajuste usuário e senha do banco no `DATABASE_URL`)
2. `composer install`
3. `php bin/console importmap:install`
4. `php bin/console doctrine:database:create`
5. `php bin/console doctrine:migrations:migrate`
6. `symfony server:start`

Depois é só acessar http://localhost:8000/login

## Criando um usuário

Para acessar o painel em `/app`, crie um usuário com:

```
php bin/console app:criar-usuario email@exemplo.com senha
```
