#!/usr/bin/env bash
# Deploy do DG Imóveis Investimentos num servidor com Traefik compartilhado.
# Rode DENTRO do diretório do projeto no servidor (ex.: /opt/sites/dgimoveis).
#
#   chmod +x deploy/deploy.sh
#   ./deploy/deploy.sh              # sobe / atualiza a stack
#   ./deploy/deploy.sh --seed      # idem + roda db:seed (só na 1ª instalação)
set -euo pipefail
cd "$(dirname "$0")/.."

SEED=0
[ "${1:-}" = "--seed" ] && SEED=1

ENV_FILE=.env.production
if [ ! -f "$ENV_FILE" ]; then
  echo "Falta $ENV_FILE. Copie de .env.production.example e ajuste." >&2
  exit 1
fi

NET="$(grep -E '^TRAEFIK_NETWORK=' "$ENV_FILE" | cut -d= -f2)"
NET="${NET:-proxy}"
docker network inspect "$NET" >/dev/null 2>&1 || docker network create "$NET"

echo ">> build + up"
docker compose --env-file "$ENV_FILE" up -d --build

echo ">> aguardando o container app"
for i in $(seq 1 30); do
  if docker compose --env-file "$ENV_FILE" exec -T app php -v >/dev/null 2>&1; then break; fi
  sleep 2
  [ "$i" = "30" ] && { echo "app não respondeu a tempo" >&2; exit 1; }
done

echo ">> migrate"
docker compose --env-file "$ENV_FILE" exec -T app php artisan migrate --force

if [ "$SEED" = "1" ]; then
  echo ">> db:seed"
  docker compose --env-file "$ENV_FILE" exec -T app php artisan db:seed --force
fi

echo ">> cache de config/rotas/views"
docker compose --env-file "$ENV_FILE" exec -T app php artisan config:cache
docker compose --env-file "$ENV_FILE" exec -T app php artisan route:cache
docker compose --env-file "$ENV_FILE" exec -T app php artisan view:cache
docker compose --env-file "$ENV_FILE" exec -T app php artisan storage:link || true

echo ">> pronto. Estado:"
docker compose --env-file "$ENV_FILE" ps
