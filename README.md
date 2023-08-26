# Laravel API for User Data

This Laravel application provides an API endpoint for retrieving user data with various filtering options. The API endpoint is `/api/v1/users`.

## Features

- List all users with transactions from available providers: DataProviderX and DataProviderY.
- Filter results by payment provider.
- Filter results by status code (authorised, decline, refunded).
- Filter results by balance amount range.
- Filter results by currency.
- Combine multiple filters together.

## Requirements

Please make sure you have docker and docker-compose installed on your machine.

## Running the Application with Docker

1. Clone this repository.
    ```
    git clone 
   ```
2. Create a `.env` file by copying `.env.example` and updating the necessary configurations, including database settings.
   ```
    cp .env.example .env
   ```
4. Generate an application kay:
   ```
   php artisan key:generate
   ```
4. Build the Docker image for the application:
   ```
   docker-compose up --build
   ```
4. Start the application and its services using Docker Compose:
   ```
   docker-compose up -d
   ```
5. Access the Laravel application by visiting `http://localhost:9000` in your web browser.

## API Documentation

### List Users

- **Endpoint**: `/api/v1/users`
- **HTTP Method**: GET

#### Query Parameters:

- `provider`: Filter results by payment provider. Example: `/api/v1/users?provider=DataProviderX`
- `statusCode`: Filter results by status code. Example: `/api/v1/users?statusCode=authorised`
- `balanceMin` and `balanceMax`: Filter results by balance amount range. Example: `/api/v1/users?balanceMin=10&balanceMax=100`
- `currency`: Filter results by currency. Example: `/api/v1/users?currency=USD`

You can combine multiple query parameters to refine your search, for example:
- `/api/v1/users?provider=DataProviderX&statusCode=authorised&balanceMin=10&balanceMax=100&currency=USD`

## Running Tests

The application comes with PHPUnit tests for the API endpoints and filters. Run the tests using the following command:

```
docker exec -it api php artisan test
```

## Stopping the Application

To stop the application and its services, run:

```
docker-compose down
```
