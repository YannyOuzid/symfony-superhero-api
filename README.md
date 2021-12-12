# symfony-superhero-api-yanny-ouzid

## How to set up the project
```
Install the dependencies with "composer install"
Put your database url in the .env.example file and rename it .env
Create the database with "php bin/console doctrine create database"
Migrate the tables with "php bin/console doctrine:migrations:migrate"
Load the fixtures with "php bin/console doctrine:fixtures:load"
```

## How works the api
```
There are 3 roles : client, superhero and admin
The admin has all the rights in the user and villain list but he can't add new missions and can edit and delete the 
missions who are not validate
The superheroes can only see the missions and edit the missions who are validate
The clients can create the missions and edit and delete the missions who are not validate. He can see his own missions 
only
The clients and superheroes can edit their own profiles.
```

## How to connect on the api (Example of accounts)
```
Admin : Email: professorX@email.com /  password: password
Super Hero : Email: hero1@email.com / password: password
Client Hero: Email: created by the joker bundle / password: password
You can see the client's email in the user list
```


