# Laravel Blog API with Sanctum Authentication

A RESTful API built with Laravel 12 and Sanctum authentication for managing blog posts.

## Features

-   User Authentication (Register, Login, Logout)
-   Blog Post Management (CRUD Operations)
-   Protected Routes with Sanctum
-   Owner-only Post Update/Delete

## Requirements

-   PHP 8.2+
-   Composer
-   MySQL
-   Laravel 12.x

## Installation

```bash
# Clone repository
git clone https://github.com/mostafa123c/Blog-Api-Task.git
cd Blog-Api-Task

# Install dependencies
composer install

# Configure environment
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Start server
php artisan serve
```

## API Endpoints

### Auth Routes

| Method | Endpoint        | Description       |
| ------ | --------------- | ----------------- |
| POST   | `/api/register` | Register new user |
| POST   | `/api/login`    | Login user        |
| POST   | `/api/logout`   | Logout user       |
| GET    | `/api/me`       | Get user details  |

### Post Routes

| Method | Endpoint          | Description     |
| ------ | ----------------- | --------------- |
| GET    | `/api/posts`      | Get all posts   |
| POST   | `/api/posts`      | Create post     |
| GET    | `/api/posts/{id}` | Get single post |
| PUT    | `/api/posts/{id}` | Update post     |
| DELETE | `/api/posts/{id}` | Delete post     |

## Usage Examples

### Register

```http
POST /api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Login

```http
POST /api/login
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Create Post

```http
POST /api/posts
Authorization: Bearer {token}
{
  "title": "My First Post",
  "content": "Post content here"
}
```

## Authentication

Include the token in protected route headers:

```http
Authorization: Bearer {your_token}
```

## Testing

Import the included Postman collection: `Blog-API.postman_collection.json`
