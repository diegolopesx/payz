# 💰 payz 💰

Criado utilizando docker-compose, mysql 8, php 7.4, nginx e  lumen 8.

## Configuração
[Docker Compose](https://docs.docker.com/compose/install/)

# Execute
docker-compose up -d

# Configuração Database

Criar Schema "payz"

# Na pasta do projeto Payz executar 

cd apps/payz
composer install

# Migrate com Seed
php artisan migrate:fresh --seed 