
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
```

---

## ⚙️ Project Initialization

```bash
# Install Dependencies
docker-compose exec app composer install

# Copy environment file
cp .env.example .env

# Run Migrations
docker-compose exec app php artisan migrate

# Seed the Database
docker-compose exec app php artisan db:seed

# Generate Swagger API Documentation 
# (if not already available at http://localhost:8000/api/documentation)
docker-compose exec app php artisan l5-swagger:generate
```

---

## 🔐 Authentication

This project uses **Laravel Sanctum** for API token authentication.

- Use the `/api/login` endpoint to get a **Bearer Token**
- Use the "Authorize" button in Swagger UI to send this token with requests to protected routes

---

## 📘 Swagger Documentation

Once the app is running and Swagger is generated, access API docs at:

```
http://localhost:8000/api/documentation
```

---

## 📄 Notes

- Make sure the `.env` file has the correct DB and app settings.
- If needed, run `docker-compose exec app php artisan config:clear` after updating `.env`.

---

## 🛠 Additional Commands (Optional)

```bash
# Run Laravel tests
docker-compose exec app php artisan test

# Clear cache (optional)
docker-compose exec app php artisan optimize:clear
```

---

Happy Coding! 🎉
