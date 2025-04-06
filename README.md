# Flight Tracker

This project is the backend for the flight tracking application built with PHP and Lumen. It provides APIs for
managing airlines and airports, viewing live airport locations, and performing CRUD operations on airlines and airports.

## Technologies Used

- PHP
- Lumen
- MySQL
- Swagger
- Composer

## Project Structure

```plaintext
├── app
│   ├── Http -> Controllers - Contains the controllers for the application
│   ├── Models - Contains the models for the application
│   ├── providers - Contains service providers for the application
│   ├── Swagger - Contains the Swagger documentation for the application
│   ├── Swagger -> Schemas - Contains the schemas for the Swagger documentation
├── database
│   ├── migrations - Contains the migration files for the application
│   ├── seeders - Contains the seeder files for the application
├── routes
│   ├── web.php - Contains the API routes for the application
```

## Getting Started

### Prerequisites

- PHP (>= 8.0)
- Composer
- MySQL

### Installation

1. Clone the repository:

```sh
   git clone https://github.com/DominikHanzevacki/flight-tracker-backend.git
   cd flight-tracker-backend
```

2. Install dependencies:

```sh
   composer install
```

### Running Locally

### Database Setup

1. Create a new MySQL database for the application.

   You can do this by using the MySQL command line or a database management tool like MySql Workbench.

```
   CREATE DATABASE databasename;
```

2. Update the .env file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flight_tracker
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password
```

3. Run the migrations and seeders to create and fill the necessary tables in the database:

```sh
   php artisan migrate
   php artisan db:seed
```

4. Run the application:

```sh
   php -S localhost:8000 -t public
```

- This will start the application on http://localhost:8000.
- You can access the Swagger API documentation at http://localhost:8000/api/documentation.

Make sure you have the frontend running locally on port 3000.

You can do this by cloning the frontend repository and running it.

All the instructions for running the frontend can be
found in the frontend repository's README.md file.

```sh
   git clone https://github.com/DominikHanzevacki/flight-tracker-frontend.git
   cd flight-tracker-frontend
```

Check the existing .env file in the root directory if it contains the following environment variables:

- APP_URL="http://localhost:8000"

SWAGGER_LUME_FORCE_HTTPS and SWAGGER_LUME_CONST_HOST are not needed for local development.

### Build and Deploy

Check the existing .env file in the root directory if it contains the following environment variables:

- APP_URL="https://flight-tracker-be-production.up.railway.app"
- SWAGGER_LUME_FORCE_HTTPS="true"
- SWAGGER_LUME_CONST_HOST="https://flight-tracker-be-production.up.railway.app"
- DB_CONNECTION=mysql
- DB_HOST=interchange.proxy.rlwy.net
- DB_PORT=30906
- DB_DATABASE=flight-tracker-db
- DB_USERNAME=root
- DB_PASSWORD=dhUvELklDtxxVXMPKckPISzuYTxwVQoT

This project is deployed on Railway (https://flight-tracker-be-production.up.railway.app/api/documentation).

- Make sure to set the explore searchbar value to "https://flight-tracker-be-production.up.railway.app/docs" in the
  Swagger (For some reason it doesn't work with the default value and its set
  to https://flight-tracker-be-production.up.railway.app/docs)

UI to access the API documentation.
Any change
to the main branch will automatically trigger a deploy to production. Before making changes to the main branch, please
make sure that php artisan migrate and artisan db:seed commands are successful.
