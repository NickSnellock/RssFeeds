#Rss Feed Aggregator

## Installation

##Prerequisites
You will need docker and docker-compose installed to run this locally. The project includes a docker-compose.yml file that is used to start a docker stack to run the code.
Alternatively, you can run this project using a database server, php and web server installed on your own system. If doing so, configuration of these is left to you.

##Steps for using docker
* run ``docker-compose up`` from the root of the project.
This will start the required containers and also run the initialisation for the database and PHP (composer update). Please note that the initialisation of the database server can take some time.
* run ``docker exec -it rssfeeds_app bash`` to get a bash prompt within the app container
* run ``php artisan migrate`` to create the tables required.
* exit the app container (CTRL-D)

You can now access the system at localhost:8080

##Operation

You will need to register as a new user by clicking on 'Register' at the top right.
Once registered, log on to see a list of RSS feeds - initially none are registered.
Add a feed URL, e.g. http://feeds.bbci.co.uk/news/rss.xml. The list of feeds will then be displayed. Click on the feed to display a list of items from the feed.

##ToDo
Only basic validation is performed on the URL entered - it must provide valid XML. This needs to be improved to ensure that this is for an RSS feed. 
Exception handling needs to be improved to return valid error messages.

I have only provided unit tests for the RssFeedSewrvice class. This should be expanded to unit test all classes.
Functional tests are required for each page.
