##Install Mongo On Mac

**I'm using mongohub as the sequelPro for mongo**

`brew update`  
`brew install mongodb`  
`sudo pecl install mongo`  
put `extension=mongo.so` in your php.ini

Assuming your homebrew setup is all good, you should be able to run `mongod` and start the mongo server

Connect locally with MongoHub (leave default settings and should be good)  

Make a new database
Name: `srcery_mongodb`
User: `srcery_mongo_user`
Pass: `srcery_mongo_pass_9889`