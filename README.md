# kampmenu
The main goal of this project is a tool for planning meals and shopping for a youth camp.

## a little introduction

### it all started with ...
... me vollonteering at a youth-organisation. I loved playing with the children and organize the camp. It also led to a new hobby: cooking! I love to cook for big groups and plan a healty and child-friendly menu.

So I became a specialist. I saw that it wasn't easy for everyone to plan meals, so I wrote a cookbook with a few other volunteers with some tips and tricks. Although there was a guide, planning for shopping the ingredients is a time-consuming task. Time that you can't use for the more funn parts of preparing a youth camp!

The day I decided that I would become a professional programmer, I knew what my first big project would be: an online guide and planning tool for meals at youth camps.

### the process
I wrote down a lot of user stories, designed the database, thought about different scenario's and brainstormed a lot.
With those ideas, I made a plan to create a first simple alfa version of the tool.

First, I created some pages in vanilla php, jQuery and css. I haven't learned any php-framework at that time.
After someone told me that I could give a try in a framework, I decided to study about Symfony and meanwhile refactore the work I did into a Symfony-application.

## getting started
Want to clone this project?

### symfony
Read symfony's documentation: [how to set up an existing symfony project](https://symfony.com/doc/current/setup.html#setting-up-an-existing-symfony-project).

### mysql database
In the root of this project you'll find a folder "my_database", download the latest version of kampmenu_v20xx.xx.xx.sql . Create a database and change the databasename, databasepassword and serverversion in the .env file on line 28.
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=x.x"
```
Execute the sql-file in order to get started with some data.

### register and log in
In order to use the CMS: register as a new user and change your role to ["ROLE_ADMIN"] .
  
## projects of the alfa-version
I split up the project into 6 smaller ones, in order to keep track of the progress.
The follow-up will be registered in each [project](../../projects) .

**010 - login and registration**

as an admin or user I want to register and login, so that I can use the tool

**020 - CMS for the recipes**

as an admin, I want to create, update or see the recipes (and all it's related-data), so it is available for the user in order to plan their meals

**030 - create a camp**

as a user, I want to create or update a camp, so I can plan my meals

**040 - plan the meals of a camp**

as a user, I want to choose recipes for every moment that there should be a meal, so I have a schedule and I have a shopping-list

**050 - create a shopping list**

as a user, I want to see a shopping-list sorted by the shopping shelves, so it is easy to prepare the shopping

**060 - guide the user during the camp**

as a user, I want to see the daily menu, so it can guide me during the cooking-process of that day
