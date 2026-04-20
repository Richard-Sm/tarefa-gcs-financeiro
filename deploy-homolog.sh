#!/bin/bash
echo "=========================================="
echo "   INICIANDO DEPLOY DE HOMOLOGAÇÃO..."
echo "=========================================="

# 1. Atualiza o código fonte
git pull origin main

# 2. Define variáveis específicas para Homologação (Porta 8080)
export COMPOSE_PROJECT_NAME=homolog
export APP_PORT=8080
export DB_DATABASE=financas_homolog
export APP_ENV=local
export APP_DEBUG=true

# 3. Sobe os contêineres e recria se houver mudanças
docker-compose up -d --build

# 4. Aguarda o banco de dados iniciar
echo "⏳ A aguardar a base de dados..."
sleep 10

# 5. Executa as migrações (Versionamento de BD) dentro do contêiner
docker exec homolog-app-1 php artisan migrate --force

# 6. Limpa os caches
docker exec homolog-app-1 php artisan optimize:clear

echo "✅ AMBIENTE DE HOMOLOGAÇÃO PRONTO NA PORTA 8080!"
