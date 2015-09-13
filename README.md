Ultimate Symfony2 Boilerplate
================

This is a boilerplate I've made to gain time when I need to kickstart projects

This ultimate symfony2 boilerplate comes with :

* [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) : Provides user management for your Symfony2 Project. Compatible with Doctrine ORM & ODM, and Propel.
* [IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle/) : Provides a CKEditor integration for your Symfony2 project.
* [StofDoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle) : Integration bundle for DoctrineExtensions by l3pp4rd in Symfony2
* [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle) : A simple Symfony2 bundle to ease file uploads with ORM entities and ODM documents.
* [LiipImagineBundle](https://github.com/liip/LiipImagineBundle) : Symfony2 Bundle to assist in imagine manipulation using the imagine library http://liip.ch
* [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) : SEO friendly Symfony2 paginator to sort and paginate http://knplabs.com/en/blog/knp-paginator-reborn
* [FMElfinderBundle] (https://github.com/helios-ag/FMElfinderBundle) : ElFinderBundle provides ElFinder integration with TinyMCE and CKEditor
* [DoctrineMigrationsBundle](https://github.com/doctrine/DoctrineMigrationsBundle) : This bundle integrates the Doctrine2 Migrations library. into Symfony so that you can safely and quickly manage database migrations.
* [MremiContactBundle](https://github.com/mremi/ContactBundle) : Provides a contact form for a Symfony2 project.
* [AvanzuAdminThemeBundle](https://github.com/avanzu/AdminThemeBundle) : Admin Theme based on the AdminLTE Template for easy integration into symfony
* [AcceleratorCacheBundle](https://github.com/Smart-Core/AcceleratorCacheBundle) : Provide a command to clear PHP Accelerator cache from CLI


<!-- -->

## Installation

This boilerplate comes with all the bundles above enabled and preconfigured

The easiest way to get started is to clone the repository:

```bash
# Get the latest snapshot
$ git clone https://github.com/numerogeek/ultimate-symfony2-boilerplate myproject
$ cd myproject
$ git remote rm origin
$ mkdir -p web/uploads/posts

#setup ACL (refer to the symfony documentation.
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs web/uploads
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs web/uploads

#composer install

$composer install

#install assets

$ php app/console assets:install --symlink
# The following command require bower. ensure to install in order to use this command
$ php app/console avanzu:admin:fetch-vendor

#Create schema

$ php app/console doctrine:database:create
$ php app/console doctrine:migrations:migrate
$ php app/console doctrine:fixtures:load

# A superadmin user is created with the fixtures with username `admin` and password `admin`



```

## Starter Kit

Go to http://www.myproject.local/app_dev.php/admin to have a look on what's coming with this bundle.

This boilerplate also comes with 4 customs bundle :
* UserBundle (inherits of FOSUserBundle to easily customize the entity) : very simple user bundle with a backoffice
* NumerogeekBlogBundle : a very simple blog bundle with a backoffice
* AppBundle : The one from the symfony installer, so you can kickstart your project right now !
* AdminBundle : which is the core of the admin part. There is not much in there because it mostly use the AvanzuAdminBundle
* FixturesBundle : see below.


## What's the fixtures Bundle ?

Usually when you start a project, you need some dummy data.
Instead of having a fixtures folder in each bundles, I have made a fixtures bundle which is basically just a folder to store all the
fixtures of your project.

## about MremiContact Bundle

The bundle comes fully configurated for you. I like to store the sent messages in the database, just in case there's a problem with the mail transport.
If you want to unactivate the storage in DB, you can set the `store_data` to `false` in the `config.yml`.
For any further documentation, check the [MremiContactBundle Documentation](https://github.com/mremi/ContactBundle).


