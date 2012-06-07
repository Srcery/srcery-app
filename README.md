##Installing
[Reference](http://symfony.com/doc/current/cookbook/workflow/new_project_git.html)

* Clone the repository
* Run `php bin/vendors install` - this will install the versions of third party libraries in your deps file.
* If you want to remove all the git history of the third party libs, `find vendor -name .git -type d | xargs rm -rf`
* If you choose to update the vendors, `php bin/vendors install --reinstall`, then re-delete the git histories, and `php bin/vendors lock`
* Copy `app/config/parameters.ini.dist` to `app/config/parameters.ini` and change your db connection settings.

If you have a runtime error with perm problems,

```
rm -rf app/cache/*
rm -rf app/logs/*

sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
```