# SILEX VIDEO

a one hour project with silex

author mparaiso , contact mparaiso@online.fr

#### Why : 
I needed a way to aggregate multiple videos from multiple websites 
and watch them on a single website. I needed to be able to tag the videos so i can organize them , and create little playlists. 

+ stack : 
    + apache http server 
    + php >5.3 , (5.4 to use the php server)
    + mysql
    + composer

#### Configuration :
+ define the following environment variables (use setx on windows, use export on linux):
    + SILEX_VIDEO_DB database name
    + SILEX_VIDEO_HOST database host
    + SILEX_VIDEO_USER db username
    + SILEX_VIDEO_PASSWORD db password

+ use composer to install silex-skeleton
    composer create-project fabpot/silex-skeleton -sdev

+ or clone the gitrepository
    git clone https://github.com/fabpot/Silex-Skeleton.git

+ to use php 5.4 built-in server create a simple router script web/router.php
<?php
//web/router.php
if (isset($_SERVER['SCRIPT_FILENAME'])) {
    return false;
} else {
    require 'index_dev.php';
}
then change dir to web folder and start the built-in server  `php -S localhost:8000 router.php`

### API :
Summary of the API we are going to implement:

HTTP verb   route               name

GET         /video              video_list
POST        /video              video_create
GET         /video/{id}         video_get_by_id
GET         /video/{title}      video_get_by_title
PUT         /video/{id}         video_update
DELETE      /video/{id}         video_delete

GET         /playlist           playlist_list
POST        /playlist           playlist_create
GET         /playlist/{id}      playlist_get_by_id
GET         /playlist/{title}   playlist_get_by_title
PUT         /playlist/{id}      playlist_update
DELETE      /playlist/{id}      playlist_delete

GET         /tag                tag_list
GET         /tag/{label}        tag_get_by_label

### Database and Models :
we need 
+ a video table to persist video informations
+ a tags table
+ a playlists table
+ a roles table
+ a users table for basic authentication: 
    + only one user authenticated , the SUPER_ADMIN
    + other users can submit video links, all the admins has to do it validate them

videos
+ id
+ title
+ url
+ description
+ link
+ created_at

tags
+ id
+ video_id
+ tagname

users
+ id
+ username
+ email
+ password_salt
+ password_hash
+ created_at
+ updated_at
+ active
+ role_id

roles
+ id
+ label ,not null

playlists
+ id
+ title
+ description
+ image

playlists_videos_relation
+ id
+ playlist_id
+ video_id
+ order
+ created_at

we'll use doctrine/orm to deal with our database

update your packages in composer.json

    require:{
            (... other packages ...)
            "doctrine/orm":"2.3.*",
            "mparaiso/silex-extensions":"0.0.*",
            "symfony/yaml":"2.*"
    },
    "repositories":[
        {
            "type":"vcs",
           "url":"https://github.com/Mparaiso/silex-extensions"
        }
    ]

then use the command  `composer update`

it will install doctrine/orm framework and some utilities for Silex, like
the DoctrineORMServiceProvider and MonologSQLLogger for logging db requests

now let's configure doctrine for our application

update src/app.php :

    // end of the file :

    use Mparaiso\Provider\DoctrineORMServiceProvider;
    use Mparaiso\Doctrine\ORM\Logger\MonologSQLLogger;

    $app->register(new DoctrineORMServiceProvider(),array(
        "em.options"=>array(
            "host"=>getenv("SILEX_VIDEO_HOST"),
            "dbname"=>getenv("SILEX_VIDEO_DB"),
            "user"=>getenv("SILEX_VIDEO_USER"),
            "password"=>getenv("SILEX_VIDEO_PASSWORD"),
            "driver"=>"pdo_mysql"
            ),
        "em.logger"=>function($app){
            return new MonologSQLLogger($app["logger"]);
        },
        "em.proxy_dir"=>dirname(__DIR__)."/cache",
        "em.is_dev_mode"=>$app["debug"],
        "em.metadata"=>array(
            "type"=>"yaml",
            "path"=>array(__DIR__."/Video/Entities/yml/")
            ),
        )
    );

    return $app;

update src/console.php :

    // at the end of the file
    // Configure Doctrine ORM tool for Console cli
    use Symfony\Component\Console\Helper\HelperSet;
    use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
    use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
    $em = $app["em"];
    $console->setHelperSet(new HelperSet(array(
        "em" => new EntityManagerHelper($em),
        "db" => new ConnectionHelper($em->getConnection()),
            )
            )
    );
    Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($console);

    return $console;

to make sure everything works , execute the following command at the root of your project :

    php console 

you should see doctrine orm custom command list , like orm:info , and their description.

create the yaml mapping files : @TODO

generate the php classes from the mapping files : 

    php console orm:generate-entities src

generate the tables in the database : 

    php console orm:schema-tool:create

add --dump-sql > db.sql to the command to preview the sql in a db.sql file

you can validate to schema and the mapping files at any moment during development :

    php console orm:validate-schema

### Forms













