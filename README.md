# :beer: Macon-Command-Center

Login:

![preview-login](http://i1158.photobucket.com/albums/p618/g12mcgov/Screenshot%202015-05-15%2023.27.34.png)

Dashboard:

![preview-dashboard](http://i.imgur.com/00p3j9G.gif)

Soon to be a dashboard to serve as an interface between my Raspberry Pi Security Camera, the lighting, air conditioning, and blinds in the Macon House (my house) for us to use Senior Year.

I want a way to control the utilities in my room over the web. These include Phillip Hue lightbulbs, Samsung SMART air conditioning unit, and a ethernet-connected motor to close and open the blinds. The ultimate goal is for this to be a "dashboard" with buttons allowing me to interact with these devices via a closed network and various APIs. 

Why PHP?

Quick and easy. Enough said.

Setup
=======

Currently, this is a PHP site running on Heroku with DNS support from [Cloudflare](https://www.cloudflare.com/) as well as SSL protection. 

You can find the site here:

[http://macon.pw](http://macon.pw)

It also uses New Relic APM support to prevent idling dynos.

Database
=======

It's currently using an extremely lightweight instance of MySQL supported through the ClearDB Heroku add-on.

DB Access can be achieved through the Heroku Dashboard.

Deploying
=======

<b>Disclaimer</b>: You'll need a running LAMP stack to run this application.

Steps:

`$ touch config.ini`

1) First make your own `config.ini` file which looks like this and fill in the necessary parameters.

	[macon-command-center]
	PRODUCTION=FALSE
	PRODUCTION_DB_HOST=
	PRODUCTION_DB_DATABASE=
	PRODUCTION_DB_USERNAME=
	PRODUCTION_DB_PASSWORD=
	DEVELOPMENT_DB_HOST=
	DEVELOPMENT_DB_DATABASE=
	DEVELOPMENT_DB_USERNAME=
	DEVELOPMENT_DB_PASSWORD=

The first value can be set to either <b>TRUE</b>/<b>FALSE</b> to indicate whether to pull production or local (development) database parameters.

2) Then, create a database (I call mine "dashboard") and a table to hold the users. Yeah yeah, I know this isn't secure but this is a localized site.

```sql
CREATE TABLE `users` (
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
```
Then, add a username and password to the table.

```sql
INSERT INTO users (username, password) VALUES ('admin', 'test');
```

3) Now, navigate to your localhost and you should have a working login screen.

	http://localhost/~grantmcgovern/macon-command-center


Finally, commit your project:


4) `$ git add .`


5) `$ git commit -m 'new_commit_message'`


6) `$git push heroku master`



