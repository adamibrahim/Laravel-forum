### Demo

live demo can be found at :

[Demo](http://laravelforum.hostato.com)


### Install
``
$ git clone git@github.com:adamibrahim/Laravel-forum.git
``

create .env, and run 

``
$ composer udpate
``

### Generate App key

``
$ php artisan key:generate
``
##### Database 
- create new database (PostgreSQL / MySQL) I'm using PostgreSQL
- insert your database info at .env file

#### Migrations and Seeds
``
$ php artisan migrate --seed
``


##### Mail notification test with log Drive 
configure your .env file with:

``
MAIL_DRIVER=log
``

``
MAIL_LOG_CHANNEL=emails
``

##### Mail notification test with mailtrap 

Simply configure your .env file as instructed at mailtrap.io


#### Admin user

seeds will insert new user with admin role to database

``
username : adamibrahim1701@gmail.com
``

``
password : secret
``

#### Testing 

feel free to: 

- Register new user/s 
- Post threads and comments 
- Manage own threats (create, update, delete)
- Filter threats by Author/s (user/s) and order by (title, content, date and Author)
- if you are logged in as Admin (adamibrahim1701@gmail.com) you will see delete button at the /threats page and you may delete any thread

#### Tests and Data Factory

There are no written tests or data factory as they were not required at the task description  