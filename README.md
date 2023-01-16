Ampliffy CI CD
===================

This library allow you checks which repositories have been affected by a commit

Requirements
------------

- PHP 8.1+
- Composer
- MySql 8.0+

Quick Start
-----------
```bash
$ composer install
```

Rename the .env.example file to .env

Create a database and place the configuration data in the **.env** file like this:

```
DB_DRIVER=pdo_mysql
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ampliffy_test
DB_USERNAME=root
DB_PASSWORD=password

BASE_PATH=/home/wilcar/code/ampliffy/repositories/
```

Use the **BASE_PATH** key to put the local path where the repositories are located

### Generate the database 

Go to the library path through the terminal and run the command:

```bash
$ php vendor/bin/doctrine orm:schema-tool:create
```

This command will create the following tables:
- **repositories** *(The in-home repositories located in the common local directory)*
- **commits** *(The information of each commit made)*
- **dependency_tree** *(The relationship between each repository and its dependencies)*
- **affected_repositories** *(The relationship between each commit and the affected repositories)*

Example Usage
-----------

Run this command via terminal inside the project directory

```bash
$ bin/console check-commit /home/wilcar/code/ampliffy/repositories/library_3 ac95e0d1490318742131fe92eb5d10b0ba3f5145 main
```
The parameters in that order are:
- git_path
- commit_id
- branch


According to the composer.json dependencies in the repositories located in **BASE_PATH**, it will show a result like the following:

```
Getting affected repositories... 
git_path: /home/wilcar/code/ampliffy/repositories/library_3
commit_id: ac95e0d1490318742131fe92eb5d10b0ba3f5145
branch: main
Affected repository: ampliffy/library_2
Affected repository: ampliffy/project_1
```

Tests
-----------
```bash
php vendor/bin/phpunit
```
 