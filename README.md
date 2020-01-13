# kampmenu
The main goal of this project is a tool for planning meals and shopping for a youth camp.

## it all started with ...
  ... me vollonteering at a youth-organisation. I loved playing with the children and organize the camp.
  It also led to a new hobby: cooking! I love to cook for big groups and plan a healty and child-friendly menu.
  So I became a specialist. I saw that it wasn't easy for everyone to plan meals, so I wrote a cookbook with a few other volunteers with some tips and tricks.
  Although there was a guide, planning for shopping the ingredients is a time-consuming task. Time that you can't use for the more funn parts of preparing a youth camp!
  The day I decided that I would become a professional programmer, I knew what my first big project would be: an online guide and planning tool for meals at youth camps.

## the process
  I started to write user-storys and design the database.
  I wrote down a lot of user stories, thought about different scenario's and brainstormed a lot.
  With those ideas, I made a plan to create a first simple alfa version of the tool.
  
  First, I created some pages in vanilla php, jQuery and css. I haven't learned any php-framework at that time.
  After someone told me that I could give a try in a framework, I decided to study about Symfony and meanwhile refactore the work I did into a Symfony-application.
  
## milestones of the first alfa-version
  ...: as an admin or user I want to register and login, so that I can use the tool :. =>  DONE
  ...: as an admin, I want to create, update or see the recipes (and all it's related-data), so it is available for the user in order to plan their meals:
    ...: CREATE ingredients, recipes, rayons, ... to the database :. => DONE
    ...: READ a sortable & filterable list of all ingredients and recipes in the database :. => DONE
    ...: READ an individual ingredient :. => IN PROGRESS
    ...: UPDATE ingredients, recipes to the database :. => IN PROGRESS
  ...: as a user, I want to create or update a camp, so I can plan my meals
  ...: as a user, I want to choose recipes for every moment that there should be a meal, so I have a schedule and I have a shopping-list
  ...: as a user, I want to see a shopping-list sorted by the shopping shelves, so it is easy to prepare the shopping
  ...: as a user, I want to see the daily menu, so it can guide me during the cooking-process of that day
