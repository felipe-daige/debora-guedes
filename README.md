# DG Imóveis Investimentos

Aplicação Laravel com catálogo administrável, upload de fotos e funil de contatos. A produção usa PostgreSQL, PHP-FPM, Nginx, Docker Compose e Traefik.

Domínio de produção: `dgimoveisinvestimentos.com.br`.

## Desenvolvimento local

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Site: `http://127.0.0.1:8000`  
Painel: `http://127.0.0.1:8000/login`

As credenciais locais iniciais são `admin@example.com` / `change-me-now`. Troque-as antes de usar dados reais.

## Produção com Docker e Traefik

O servidor usa um **Traefik compartilhado** como proxy reverso para vários sites. Cada
projeto fica em seu próprio diretório com seu `.env.production` e seu `compose.yml`, e
todos publicam na mesma rede externa `proxy`.

Pré-requisitos no servidor: Docker + plugin Compose, um Traefik já rodando com um
certresolver TLS chamado `letsencrypt` e a rede externa definida em `TRAEFIK_NETWORK`
(padrão `proxy`). Se o Traefik ainda não existir, use `deploy/traefik/` (abaixo).

1. Aponte o DNS de `dgimoveisinvestimentos.com.br` e `www` (registros A) para o IP do servidor.
2. Copie os arquivos do projeto para o servidor, ex.: `/opt/sites/dgimoveis`.
3. Copie `.env.production.example` para `.env.production` e ajuste domínio, senhas e dados administrativos.
4. Gere `APP_KEY` com `php artisan key:generate --show` (ou `openssl rand -base64 32` prefixado por `base64:`).
5. Garanta a rede compartilhada: `docker network create proxy` (ignore o erro se já existir).
6. Suba a stack: `docker compose --env-file .env.production up -d --build`.
7. Migre: `docker compose --env-file .env.production exec app php artisan migrate --force`.
8. Na primeira instalação, crie o usuário e catálogo inicial: `docker compose --env-file .env.production exec app php artisan db:seed --force`.

### Traefik compartilhado (só se o servidor ainda não tiver um)

Em `deploy/traefik/` há um `compose.yml` mínimo com HTTP→HTTPS, Let's Encrypt
(`certresolver=letsencrypt`) e a rede `proxy`. Configure `TRAEFIK_ACME_EMAIL` e suba:

```sh
cd deploy/traefik
docker network create proxy   # ignore se já existir
docker compose up -d
```

## Backup

O serviço `backup` gera diariamente um `pg_dump` compactado no volume `backups` e remove arquivos mais antigos que `BACKUP_RETENTION_DAYS` (14 dias por padrão).

Listar: `docker compose --env-file .env.production exec backup ls -lh /backups`

Restaurar um arquivo:

```sh
gunzip -c /backups/postgres-AAAAMMDD-HHMMSS.dump.gz | PGPASSWORD="$DB_PASSWORD" psql -h postgres -U "$DB_USERNAME" -d "$DB_DATABASE"
```
