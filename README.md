# 🚀 Laravel Translation API with Docker

This project provides a Laravel-based Translation API with Docker, Sanctum authentication, and Swagger documentation.

---

## 🐳 Docker Setup & Usage

### 🔧 Starting and Stopping the App

```bash
# Build and start containers in detached mode
docker-compose up --build -d

# Stop and remove containers, networks, and volumes
docker-compose down

#  Install Dependencies
docker-compose exec app composer install

copy .env.exmaple as .env
#Run Migrations
docker-compose exec app php artisan migrate

# Seed the Database
docker-compose exec app php artisan db:seed

# Generate Swagger API Documentation / if not exists (http://localhost:8000/api/documentation)
docker-compose exec app php artisan l5-swagger:generate

