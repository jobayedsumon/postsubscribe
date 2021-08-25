After cloaning the project run these commands to run this project on your computer.

# composer install
# cp .env.example .env
# php artisan key:generate

Create an empty database
In the .env file, add database information to allow Laravel to connect to the database

# php artisan migrate

# php artisan email:send
to send email by command

# php artisan queue:listen
to allow email queuing in the background

API endpoints -
# /api/user
to create new user with 'name', 'email' and 'password'
# /api/website
to create new website with 'url', 'title' and 'description'
# /api/subscription
to subscribe a user in a particular website with 'user_id' and 'website_id'
# /api/post
to create new post with 'website_id', 'title' and 'description'

API documentation link -
# https://documenter.getpostman.com/view/15047522/TzzGGDiP
