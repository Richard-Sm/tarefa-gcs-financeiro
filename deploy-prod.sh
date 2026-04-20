#!/bin/bash
echo "=========================================="
echo "   INICIANDO DEPLOY DE PRODUÇÃO..."
echo "=========================================="

# 1. Atualiza o código fonte
git pull origin main

# 2. Define variáveis específicas para Produção (Porta 80)
export COMPOSE_PROJECT_NAME=prod
export APP_PORT=80
export DB_DATABASE=financas_prod
export APP_ENV=production
export APP_DEBUG=false

# 3. Sobe os contêineres e recria se houver mudanças
docker-compose up -d --build

# 4. Aguarda o banco de dados iniciar
echo "⏳ A aguardar a base de dados..."
sleep 10

# 5. Executa as migrações (Versionamento de BD) dentro do contêiner
docker exec prod-app-1 php artisan migrate --force

# 6. Otimiza a aplicação para produção
docker exec prod-app-1 php artisan optimize

echo "✅ AMBIENTE DE PRODUÇÃO PRONTO NA PORTA 80!"
