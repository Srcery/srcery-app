##Install Mongo On Mac

**I'm using mongohub as the sequelPro for mongo**

`brew update`  
`brew install mongodb`  
`sudo pecl install mongo`  
put `extension=mongo.so` in your php.ini  
restart apache (mac local:) `sudo /usr/sbin/apachectl restart`
//@todo - I tried to move specific ini files and have it scan, was able to get it working on CLI, but not apache.

Assuming your homebrew setup is all good, you should be able to run `mongod` and start the mongo server

Type `mongo` to enter the mongo shell;

`use admin` to switch to the admin database;

Make an admin user
`db.addUser("theadmin", "anadminpassword")`

Make a database for srcery and add a user into it.

`use srcery_mongodb`

`db.addUser("srcery_db_user", "srcery_db_pass9889")`

Create 'test_collection'

`db.createCollection("test_collection");`

Add a random object to a test collection

`db.test_collection.save({ name: "monkey"});`

Visit /mongotest to make sure it's all good.
