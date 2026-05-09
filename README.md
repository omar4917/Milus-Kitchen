# Lilus Kitchen - Home-Made Food Ordering System

A production-ready MVP for a home-made food business with customer ordering and admin dashboard.

## Quick Start (Local Development)

### Prerequisites

-   Docker Desktop installed
-   Git

### Setup

```bash
# Clone and enter directory
cd Lilus-Kitchen

# Copy environment file
copy .env.example .env

# Generate app key
php artisan key:generate

# Start Docker containers
docker-compose up -d

# Run migrations and seed data
docker-compose exec app php artisan migrate --seed

# Create storage link
docker-compose exec app php artisan storage:link
```

### Access

-   **Customer Site**: http://localhost:8080
-   **Admin Panel**: http://localhost:8080/admin/login
    -   Email: `admin@liluskitchen.com`
    -   Password: `password`

## Features

### Customer

-   Browse menu by categories
-   Add items to cart
-   Checkout with delivery/pickup options
-   Multiple payment methods (COD, bKash, Nagad)
-   Order confirmation with email notification

### Admin

-   Dashboard with daily stats
-   Manage categories and menu items
-   Photo uploads for items
-   Order management with status workflow
-   Role-based access (Admin/Staff)

## Deployment (VPS - Canada)

### 1. Server Setup

```bash
# Install Docker
curl -fsSL https://get.docker.com | sh

# Clone repository
git clone <your-repo> /var/www/lilus-kitchen
cd /var/www/lilus-kitchen

# Create production env
cp .env.example .env.production
# Edit with production values
nano .env.production
```

### 2. Deploy

```bash
# Build and start
docker-compose -f docker-compose.prod.yml up -d --build

# Run migrations
docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Seed initial data
docker-compose -f docker-compose.prod.yml exec app php artisan db:seed --force
```

### 3. SSL with Certbot

```bash
# Install certbot
apt install certbot

# Get certificate
certbot certonly --webroot -w /var/www/lilus-kitchen/public -d liluskitchen.com

# Copy certs to nginx ssl folder
cp /etc/letsencrypt/live/liluskitchen.com/fullchain.pem docker/nginx/ssl/
cp /etc/letsencrypt/live/liluskitchen.com/privkey.pem docker/nginx/ssl/

# Restart nginx
docker-compose -f docker-compose.prod.yml restart nginx
```

### 4. Backups (Cron)

```bash
# Add to crontab -e
0 2 * * * docker-compose -f /var/www/lilus-kitchen/docker-compose.prod.yml exec -T db pg_dump -U postgres lilus_kitchen > /backups/db-$(date +\%Y\%m\%d).sql
```

## Environment Variables

| Variable        | Description                                                       |
| --------------- | ----------------------------------------------------------------- |
| `APP_KEY`       | Laravel encryption key (generate with `php artisan key:generate`) |
| `DB_PASSWORD`   | PostgreSQL password                                               |
| `MAIL_HOST`     | SMTP server (e.g., smtp.mailgun.org)                              |
| `MAIL_USERNAME` | SMTP username                                                     |
| `MAIL_PASSWORD` | SMTP password                                                     |

## Folder Structure

```
├── app/
│   ├── Http/Controllers/      # Request handlers
│   ├── Models/                # Eloquent models
│   ├── Services/              # Business logic
│   └── Mail/                  # Email templates
├── database/migrations/       # Database schema
├── resources/views/           # Blade templates
├── public/                    # Static assets
└── docker/                    # Docker configs
```

## Launch Checklist

-   [ ] Domain DNS configured
-   [ ] SSL certificate installed
-   [ ] Production environment variables set
-   [ ] Database migrations run
-   [ ] Admin account password changed
-   [ ] Email delivery tested
-   [ ] Menu items added
-   [ ] Contact information updated in Settings
-   [ ] Payment instructions configured
-   [ ] Mobile responsiveness tested

## License

Private - All rights reserved.
