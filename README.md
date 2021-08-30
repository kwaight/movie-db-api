### Development Setup
Copy the example env `cp .env.example .env` and update the variables.

Run the following command to initialize a local API on docker
```
docker-compose up --build
```

You must add movie-db.test to your local /etc/hosts file

SSH into the box with `docker exec -it movie_db_nginx sh` and run `composer install` to install dependencies.
