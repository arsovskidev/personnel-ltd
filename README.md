# personnel-ltd

#### The full-stack test project for Personnel LTD.

<img src="https://i.imgur.com/U0KHCMM.png"/>

###### Clone and install composer dependencies.

```
$ git clone git@github.com:arsovskidev/personnel-ltd.git
$ cd personnel-ltd

$ composer install
```

###### Rename the .env.example file to .env and change the following settings.

```
$ mv .env.example .env
$ nano .env

DB_DATABASE= YOUR_DATABASE_NAME
DB_USERNAME= YOUR_MYSQL_USERNAME
DB_PASSWORD= YOUR_MYSQL_PASSWORD
```

###### Migrate the database.

```
$ php artisan migrate
```

###### You are now done with setting up, go ahead and run the project!

```
$ php artisan serve
```


<img src="https://i.imgur.com/PrMLoIC.png"/>
