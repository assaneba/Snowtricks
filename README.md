# Snowtricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bfc8fecb47a84e138a1627509add930e)](https://www.codacy.com/manual/assaneba/Snowtricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=assaneba/Snowtricks&amp;utm_campaign=Badge_Grade)

Community website of snowboard lovers.

## Installation

### Prerequisites 

Install GitHub (<https://gist.github.com/derhuerst/1b15ff4652a867391f03>) .\
Install Composer (<https://getcomposer.org/>) .\
Install Nodejs (<https://nodejs.org/en/download/>) .\

Symfony 4.4 requires PHP 7.1.3 or higher to run.\
Prefer MySQL 5.6 or higher.\

### Download

[![Repo Size](https://img.shields.io/github/repo-size/assaneba/Snowtricks.svg?label=Repo+Size)](https://github.com/assaneba/Snowtricks/tree/master) \
After Git installation execute the following command line to download project into your chosen directory:
```
git clone https://github.com/assaneba/Snowtricks.git

```

Install dependencies by running the following command:
```
composer install
```
```
npm install public/
```
NB : create ```upload/images/``` directory to contain uploaded files

### Database

Change database connection in .env file.\
```
DATABASE_URL=mysql://root:@127.0.0.1:3306/snowtricks?serverVersion=5.7
```

Create database:
```
php bin/console doctrine:database:create
```

Build the database structure using the following command:
```
php bin/console doctrine:migrations:migrate
```

Load the initial data
```
php bin/console doctrine:fixtures:load
```

### Configure the mailer

Go to the .env file and find mailer configuration (line 34) then replace it by your own:
```
MAILER_URL=gmail://username:password@localhost
```

### Run the web application

Launch the Apache/Php runtime environment by using :
```
php bin/console server:run
```
Then go to <http://localhost:8000> from your browser.

### Users accounts

Default password for all users is ```passer12345```\
User with email ```assanetb@gmail.com``` is the SUPER_ADMIN_USER and have all rights.

## Creator

Assane Thione Ba

[![WebSite Status](https://img.shields.io/website-up-down-green-red/https/philippebeck.net.svg?label=https://assaneba.com)](https://assaneba.com)
[![GitHub Followers](https://img.shields.io/github/followers/assaneba.svg?label=GitHub+:+assaneba+|+Followers)](https://github.com/assaneba)
[![Twitter Follow](https://badgen.net/twitter/follow/assanetba)](https://twitter.com/assanetba)
