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

#### Database and Models :
we need 
+ a video table to persist video informations
+ a tags table
+ a roles table
+ a users table for basic authentication: 
    + only use user authenticated , the SUPER_ADMIN
    + other users can submit video links, all the admins has to do it validate them

videos
-----------
id
title
url
description
link
created_at

tags
-----
id
video_id
tagname

users
-----
id
username
email
password_salt
password_hash
created_at
updated_at
active
role_id

roles
-----
id
label ,not null
description ,null





