# Dolphin CRM
# Installation
### Requirements
- Apache 2.4
- PHP 5.6
- MySQL 5.7
- Composer

## Installing Composer
Composer is a dependency manager for PHP. It will install the required packages for the Dolphin CRM application. To install Composer, run the following commands:

### The Command Line
```
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
```

### The Installer
Navigate to https://getcomposer.org/download/ and download the installer

## Setting Up Environment Variables
Dolphin CRM uses environment variables to store sensitive information. To set up the environment variables, run the following command:
```bash
$ composer install
```

This will install all the necessary packages for the application.
The next thing you will need to do is create an `.env` file in the root directory of the application. This file will contain all the environment variables for the application. The `.env` file should look like this:
```dotenv
# .env

DATABASE_HOST=host
DATABASE_USERNAME=username
DATABASE_PASSWORD=password
DATABASE_NAME=name
```

If your environment variables are not set up properly you will not be able to use DolphinCRM's database logic the way it was intended.

## Setting Up the Database
Dolphin CRM uses a MySQL database to store all of its data. To set up the database, execute the scripts in the `schema.sql` file. This will create the database and all the tables needed for the application to run.
<br><br>
The default admin user has an email and password combination that follows `admin@dolphin.com:d0lphinadm1n`

