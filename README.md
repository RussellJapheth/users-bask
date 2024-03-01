# UsersBask

## Project Overview

The project is built with `CodeIgniter 4` and consists of two microservices:

***Users Service:*** Provides an endpoint to create a new user and stores the information in a database or log file. Upon successful creation, it publishes an event to RabbitMQ.

***Notifications Service:*** Consumes messages from the RabbitMQ queue and saves the received user data in a separate log file.

### Prerequisites

* Docker 

### Installation

1. Cloning the repository:

    ```bash
        git clone https://github.com/RussellJapheth/users-bask.git

        cd users-bask
    ```

2. Using the helper scripts

    ```bash
    # This sets up the docker containers, installs the dependencies and starts the app
    # The app would be accessible at http://localhost:8080
    ./setup.sh

    # The other scripts are
    # restart.sh  # Restart the application
    # start.sh # Start the application
    # stop.sh # Stop the application
    # test.sh # Runs the unit tests
    ```

### Usage

Send a POST request to <http://localhost:8080/users> with the following JSON body:

```json
{
    "email": "sample@example.com",
    "firstName": "Sample",
    "lastName": "John"
}
```

* A successful response will indicate user creation and event publishing. Here is an example: 

```json
{
  "status": "success",
  "message": "User created successfully",
  "data": {
    "id": 1,
    "email": "sample@example.com",
    "firstName": "Sample",
    "lastName": "John"
  }
}
```

> The data is stored in `basket/writable/data.db` and the logged events are at `basket/writable/notifications.log`

The service runs continuously in the background, consuming messages from the RabbitMQ queue and saving user data to the log file.

### Testing

Tests can be run using the helper script:

```bash
./test.sh
```
