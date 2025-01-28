# Billing System

This is a Billing System. Follow the steps below to set up and run the project.

## Prerequisites

- PHP ^8.2
- Composer
- MySql
- Postman

## Installation

1. Clone the repository:

    ```sh
    git clone git@github.com:zakiamansyah/billing-system.git
    cd billing-system
    ```

2. Install PHP dependencies:

    ```sh
    composer install
    ```

3. Copy the example environment file and configure the environment variables:

    ```sh
    cp .env.example .env
    ```

4. Generate the application key:

    ```sh
    php artisan key:generate
    ```

5. Run the database migrations:

    ```sh
    php artisan migrate
    ```

6. Run the database seeder:

    ```sh
    php artisan db:seed
    ```

## Running the Project

1. Start the development server:

    ```sh
    php artisan serve
    ```

## API Endpoints

### 1. Create VPS
**URL:** `http://localhost:8000/api/billing/create-vps`

**Method:** `POST`

**Request Parameters:**
| Field        | Type    | Required | Description                    |
|--------------|---------|----------|--------------------------------|
| `customer_id` | Integer | Yes      | The ID of the customer.        |
| `cpu`        | Integer | Yes      | Number of CPUs.                |
| `ram`        | Integer | Yes      | Amount of RAM in MB.           |
| `storage`    | Integer | Yes      | Amount of storage in MB.       |

**Example Request:**
```json
{
    "customer_id": 11,
    "cpu": 1,
    "ram": 1024,
    "storage": 10240
}
```

**Response (Success):**
```json
{
    "message": "VPS created successfully"
}
```

**Response (Validation Error):**
```json
{
    "message": "The customer id field is required. (and 3 more errors)",
    "errors": {
        "customer_id": [
            "The customer id field is required."
        ],
        "cpu": [
            "The cpu field is required."
        ],
        "ram": [
            "The ram field is required."
        ],
        "storage": [
            "The storage field is required."
        ]
    }
}
```

3. Run Scheduler for Routine Check & Billing Hourly
    ```sh
    php artisan schedule:run
    ```