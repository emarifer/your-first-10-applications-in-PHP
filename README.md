# Your first 10 Applications in PHP

### 10 PHP Apps developed with the OOP paradigm to get you started in the world of PHP.

---

- **Prerequisites**: have PHP, NodeJs, Composer and Docker installed.

---

To start the database, you can proceed in 2 ways:

1. Run the *docker-compose.yml* file in the root of the repository folder
2. Run the *docker-compose.yml* file in the subfolder of the specific application you want to start

In the first case, the MariaDB and phpMyAdmin containers will be created, as well as a volume in the root of the repository that will contain the data.

In the second case, in addition to the same *MariaDB* and *phpMyAdmin* containers, the volume will be created only for the specific project where you run the *docker-compose.yml* file.

The command to create the containers is:

```
$ docker compose up -d
```

Once the containers are started, you must create a database called **appdb**, and access it via **CLI** or *phpMyAdmin* with the following credentials:

```
HOST=127.0.0.1
DBNAME=appdb
DBUSER=root
PASSWORD=my-secret-pw
PORT=3306
```

If you access *MariaDB* via **CLI** and want to create the database, you will need to run the following commands:

```
$ docker exec -it apps-db mariadb --user root -p

# Enter the password: my-secret-pw

# Create the 'appdb' database:

$ CREATE DATABASE appdb;
```

---

Since all the applications use TailwindCSS as their CSS framework, you must execute the NodeJs command in the specific application that you want to start:

```
$ npm i
```

Next, whether you want to make code changes or create production CSS, you need to run these commands in the root of the specific project:


```
# If you want to edit the code and update the build CSS:

$ npm run watch-css

# If you want to create the production CSS:

$ npm run build-css-prod
```

