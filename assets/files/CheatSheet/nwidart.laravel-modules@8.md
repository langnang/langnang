# nwidart/laravel-modules 8.x

## Upgrading

### from v8.2.0

If you have an existing config file, and you get an error:

```bash
Target class [CommandMakeCommand] does not exist
```

Then the config file will need updating first import the commands class:

```php
use Nwidart\Modules\Commands;
```

Next replace the commands array with:

```php
'commands' => [

    Commands\CommandMakeCommand::class,

    Commands\ComponentClassMakeCommand::class,

    Commands\ComponentViewMakeCommand::class,

    Commands\ControllerMakeCommand::class,

    Commands\DisableCommand::class,

    Commands\DumpCommand::class,

    Commands\EnableCommand::class,

    Commands\EventMakeCommand::class,

    Commands\JobMakeCommand::class,

    Commands\ListenerMakeCommand::class,

    Commands\MailMakeCommand::class,

    Commands\MiddlewareMakeCommand::class,

    Commands\NotificationMakeCommand::class,

    Commands\ProviderMakeCommand::class,

    Commands\RouteProviderMakeCommand::class,

    Commands\InstallCommand::class,

    Commands\ListCommand::class,

    Commands\ModuleDeleteCommand::class,

    Commands\ModuleMakeCommand::class,

    Commands\FactoryMakeCommand::class,

    Commands\PolicyMakeCommand::class,

    Commands\RequestMakeCommand::class,

    Commands\RuleMakeCommand::class,

    Commands\MigrateCommand::class,

    Commands\MigrateRefreshCommand::class,

    Commands\MigrateResetCommand::class,

    Commands\MigrateRollbackCommand::class,

    Commands\MigrateStatusCommand::class,

    Commands\MigrationMakeCommand::class,

    Commands\ModelMakeCommand::class,

    Commands\PublishCommand::class,

    Commands\PublishConfigurationCommand::class,

    Commands\PublishMigrationCommand::class,

    Commands\PublishTranslationCommand::class,

    Commands\SeedCommand::class,

    Commands\SeedMakeCommand::class,

    Commands\SetupCommand::class,

    Commands\UnUseCommand::class,

    Commands\UpdateCommand::class,

    Commands\UseCommand::class,

    Commands\ResourceMakeCommand::class,

    Commands\TestMakeCommand::class,

    Commands\LaravelModulesV6Migrator::class,
],
```

Quick Example

Generate your first module using php artisan module:make Blog. The following structure will be generated.

    Modules/
      ├── Blog/
          ├── Config/
          ├── Console/
          ├── Database/
              ├── factories/
              ├── Migrations/
              ├── Seeders/
          ├── Entities/
          ├── Http/
              ├── Controllers/
              ├── Middleware/
              ├── Requests/
          ├── Providers/
              ├── BlogServiceProvider.php
              ├── RouteServiceProvider.php
          ├── Resources/
              ├── assets/
              ├── lang/
              ├── views/
          ├── Routes/
              ├── api.php
              ├── web.php
          ├── Tests/
          ├── composer.json
          ├── module.json
          ├── package.json
          ├── webpack.mix.js

## Installation and Setup

### Composer

To install through Composer, by run the following command:

    composer require nwidart/laravel-modules

The package will automatically register a service provider and alias.

Optionally, publish the package's configuration file by running:

    php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

### Autoloading

By default the module classes are not loaded automatically. You can autoload your modules using psr-4. By adding a Modules path "Modules\\": "Modules/", For example :

    {
      "autoload": {
        "psr-4": {
          "App\\": "app/",
          "Modules\\": "Modules/",
          "Database\\Factories\\": "database/factories/",
          "Database\\Seeders\\": "database/seeders/"
        }
      }
    }

This will load classes from the Modules namespace.

Tip: don't forget to run composer dump-autoload afterwards

## Lumen

Lumen doesn't come with a vendor publisher. In order to use laravel-modules with lumen you have to set it up manually.

Create a config folder inside the root directory and copy vendor/nwidart/laravel-modules/config/config.php to that folder named modules.php

    mkdir config
    cp vendor/nwidart/laravel-modules/config/config.php config/modules.php

Then load the config and the service provider in bootstrap/app.php

```php
$app->configure('modules');
$app->register(\Nwidart\Modules\LumenModulesServiceProvider::class)
```

Laravel-modules uses path.public which isn't defined by default in Lumen. Register path.public before loading the service provider.

```php
$app->bind('path.public', function() {
 return __DIR__ . 'public/';
});
```

## Configuration

You can publish the package configuration using the following command:

```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

In the published configuration file you can configure the following things:

### Default namespace

What the default namespace will be when generating modules.

Default: `Modules`

The default namespace is set as Modules this will apply the namespace for all classes the module will use when it's being created and later when generation additional classes.

### Overwrite the generated files (stubs)

Overwrite the default generated stubs to be used when generating modules. This can be useful to customise the output of different files.

These stubs set options and paths.

Enabled true or false will enable or disable a module upon creation, the default is false meaning you will have to enable a module manually.

To enable a module edit **module_statuses.json** or run the command:

```php
php artisan module:enable ModuleName
```

> note the module_statues.json file will be created if it does not exist using this command.

The contents of module_statuses.json looks like:

```php
{
  "Users": true
}
```

> The above would be when there is a single module called Users and is enabled.

Path points to a vendor directly where the default stubs are located, these can be published and modified.

Files set the file locations defaults.

Replacements is a way to do a Find and Replace on generation any matches will be replaced.

```php
'stubs' => [ 'enabled' => false, 'path' => base_path() . '/vendor/nwidart/laravel-modules/src/Commands/stubs', 'files' => [ 'routes/web' => 'Routes/web.php', 'routes/api' => 'Routes/api.php', 'views/index' => 'Resources/views/index.blade.php', 'views/master' => 'Resources/views/layouts/master.blade.php', 'scaffold/config' => 'Config/config.php', 'composer' => 'composer.json', 'assets/js/app' => 'Resources/assets/js/app.js', 'assets/sass/app' => 'Resources/assets/sass/app.scss', 'webpack' => 'webpack.mix.js', 'package' => 'package.json', ], 'replacements' => [ 'routes/web' => ['LOWER_NAME', 'STUDLY_NAME'], 'routes/api' => ['LOWER_NAME'], 'webpack' => ['LOWER_NAME'], 'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'], 'views/index' => ['LOWER_NAME'], 'views/master' => ['LOWER_NAME', 'STUDLY_NAME'], 'scaffold/config' => ['STUDLY_NAME'], 'composer' => [ 'LOWER_NAME', 'STUDLY_NAME', 'VENDOR', 'AUTHOR_NAME', 'AUTHOR_EMAIL', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE', ], ], 'gitkeep' => true, ],
```

### Generator Path

By default, these are the files that are generated by default where generate is set to true, when false is used that path is not generated.

Don't like Entities for the Models here's where you can change the path to Models instead.

```php
'generator' => [ 'config' => ['path' => 'Config', 'generate' => true], 'command' => ['path' => 'Console', 'generate' => true], 'migration' => ['path' => 'Database/Migrations', 'generate' => true], 'seeder' => ['path' => 'Database/Seeders', 'generate' => true], 'factory' => ['path' => 'Database/factories', 'generate' => true], 'model' => ['path' => 'Entities', 'generate' => true], 'routes' => ['path' => 'Routes', 'generate' => true], 'controller' => ['path' => 'Http/Controllers', 'generate' => true], 'filter' => ['path' => 'Http/Middleware', 'generate' => true], 'request' => ['path' => 'Http/Requests', 'generate' => true], 'provider' => ['path' => 'Providers', 'generate' => true], 'assets' => ['path' => 'Resources/assets', 'generate' => true], 'lang' => ['path' => 'Resources/lang', 'generate' => true], 'views' => ['path' => 'Resources/views', 'generate' => true], 'test' => ['path' => 'Tests/Unit', 'generate' => true], 'test-feature' => ['path' => 'Tests/Feature', 'generate' => true], 'repository' => ['path' => 'Repositories', 'generate' => false], 'event' => ['path' => 'Events', 'generate' => false], 'listener' => ['path' => 'Listeners', 'generate' => false], 'policies' => ['path' => 'Policies', 'generate' => false], 'rules' => ['path' => 'Rules', 'generate' => false], 'jobs' => ['path' => 'Jobs', 'generate' => false], 'emails' => ['path' => 'Emails', 'generate' => false], 'notifications' => ['path' => 'Notifications', 'generate' => false], 'resource' => ['path' => 'Transformers', 'generate' => false], 'component-view' => ['path' => 'Resources/views/components', 'generate' => false], 'component-class' => ['path' => 'View/Component', 'generate' => false], ]
```

### Package Commands

The commands you can run is determined from this list. Any commands you don't want to use can be commented out / removed from this list and will not then be available when running `php artisan`.

```php
'commands' => [
  Commands\CommandMakeCommand::class,
  Commands\ComponentClassMakeCommand::class,
  Commands\ComponentViewMakeCommand::class,
  Commands\ControllerMakeCommand::class,
  Commands\DisableCommand::class,
  Commands\DumpCommand::class,
  Commands\EnableCommand::class,
  Commands\EventMakeCommand::class,
  Commands\JobMakeCommand::class,
  Commands\ListenerMakeCommand::class,
  Commands\MailMakeCommand::class,
  Commands\MiddlewareMakeCommand::class,
  Commands\NotificationMakeCommand::class,
  Commands\ProviderMakeCommand::class,
  Commands\RouteProviderMakeCommand::class,
  Commands\InstallCommand::class,
  Commands\ListCommand::class,
  Commands\ModuleDeleteCommand::class,
  Commands\ModuleMakeCommand::class,
  Commands\FactoryMakeCommand::class,
  Commands\PolicyMakeCommand::class,
  Commands\RequestMakeCommand::class,
  Commands\RuleMakeCommand::class,
  Commands\MigrateCommand::class,
  Commands\MigrateRefreshCommand::class,
  Commands\MigrateResetCommand::class,
  Commands\MigrateRollbackCommand::class,
  Commands\MigrateStatusCommand::class,
  Commands\MigrationMakeCommand::class,
  Commands\ModelMakeCommand::class,
  Commands\PublishCommand::class,
  Commands\PublishConfigurationCommand::class,
  Commands\PublishMigrationCommand::class,
  Commands\PublishTranslationCommand::class,
  Commands\SeedCommand::class,
  Commands\SeedMakeCommand::class,
  Commands\SetupCommand::class,
  Commands\UnUseCommand::class,
  Commands\UpdateCommand::class,
  Commands\UseCommand::class,
  Commands\ResourceMakeCommand::class,
  Commands\TestMakeCommand::class,
  Commands\LaravelModulesV6Migrator::class,
  Commands\ComponentClassMakeCommand::class,
  Commands\ComponentViewMakeCommand::class,
],
```

### Overwrite the paths

Overwrite the default paths used throughout the package.

Set the path for where to place the Modules folder, where the assets will be published and the location for the migrations.

> It's recommend keep the defaults here.

```php
'paths' => [ 'modules' => base_path('Modules'), 'assets' => public_path('modules'), 'migration' => base_path('database/migrations'),
```

### Scan additional folders for modules

By default, modules are loaded from a directory called Modules, in addition to the scan path. Any packages installed for modules can be loaded from here.

```php
'scan' => [
  'enabled' => false,
  'paths' => [
    base_path('vendor/*/*'),
  ],
],
```

You can add your own locations for instance say you're building a large application and want to have multiple module folder locations, you can create as many as needed.

```php
'scan' => [
  'enabled' => true,
  'paths' => [
    base_path('ModulesCms'),
    base_path('ModulesERP'),
    base_path('ModulesShop'),
  ],
],
```

> Remember to set enabled too true to enable these locations.

### Composer file template

When generating a module the composer.json file will contain the author details as set out below, change them as needed.

Take special notice of the vendor, if you plan on extracting modules to packages later it's recommend using your BitBucket/GitHub/GitLab vendor name here.

```php
'composer' => [ 'vendor' => 'nwidart', 'author' => [ 'name' => 'Nicolas Widart', 'email' => 'n.widart@gmail.com', ], ]
```

### Caching

If you have many modules it's a good idea to cache this information (like the multiple `module.json` files for example).

Modules can be cached, by default caching is off.

```php
'cache' => [ 'enabled' => false, 'key' => 'laravel-modules', 'lifetime' => 60, ],
```

### Registering custom namespace

Decide which custom namespaces need to be registered by the package. If one is set to false, the package won't handle its registration.

## Compiling Assets (Laravel Mix)

### Installation & Setup

When you create a new module it also create assets for CSS/JS and the `webpack.mix.js` configuration file.

```bash
php artisan module:make Blog
```

Change directory to the module:

```bash
cd Modules/Blog
```

The default `package.json` file includes everything you need to get started. You may install the dependencies it references by running:

```bash
npm install
```

### Running Mix

Mix is a configuration layer on top of [Webpack](https://webpack.js.org/), so to run your Mix tasks you only need to execute one of the NPM scripts that is included with the default `laravel-modules` `package.json` file

```bash
// Run all Mix tasks... npm run dev // Run all Mix tasks and minify output... npm run production
```

After generating the versioned file, you won't know the exact file name. So, you should use Laravel's global mix function within your views to load the appropriately hashed asset. The mix function will automatically determine the current name of the hashed file:

```html
// Modules/Blog/Resources/views/layouts/master.blade.php
<link rel="stylesheet" href="{{ mix('css/blog.css') }}" />
<script src="{{ mix('js/blog.js') }}"></script>
```

For more info on Laravel Mix view the documentation here: <https://laravel.com/docs/mix>

> Note: to prevent the main Laravel Mix configuration from overwriting the `public/mix-manifest.json` file:

Install `laravel-mix-merge-manifest`

```bash
npm install laravel-mix-merge-manifest --save-dev
```

Modify `webpack.mix.js` main file

```js
let mix = require('laravel-mix');
/* Allow multiple Laravel Mix applications*/ require('laravel-mix-merge-manifest');
mix.mergeManifest();
/*----------------------------------------*/ mix.js('resources/assets/js/app.js', 'public/js').sass('resources/assets/sass/app.scss', 'public/css');
```

## Creating a module

To make modules use the artisan command `php artisan module:make ModuleName` to create a module called Posts:

```bash
php artisan module:make posts
```

This will create a module in the path `Modules/Posts`

You can create multiple modules in one command by specifying the names separately:

```bash
php artisan module:make customers contacts users invoices quotes
```

Which would create each module.

### Flags

By default when you create a new module, the command will add some resources like a controller, seed class, service provider, etc. automatically. If you don't want these, you can add `--plain` flag, to generate a plain module.

```bash
php artisan module:make Blog --plain
```

or

```bash
php artisan module:make Blog -p
```

Additional flags are as follows:

Generate an api module.

```bash
php artisan module:make Blog --api
```

Do not enable the module at creation.

```bash
php artisan module:make Blog --disabled
```

or

```bash
php artisan module:make Blog -d
```

### Naming convention

Because we are autoloading the modules using [psr-4](http://www.php-fig.org/psr/psr-4/), we strongly recommend using StudlyCase convention.

### Folder structure

    Modules/
      ├── Blog/
          ├── Config/
          ├── Console/
          ├── Database/
              ├── factories/
              ├── Migrations/
              ├── Seeders/
          ├── Entities/
          ├── Http/
              ├── Controllers/
              ├── Middleware/
              ├── Requests/
          ├── Providers/
              ├── PostsServiceProvider.php
              ├── RouteServiceProvider.php
          ├── Resources/
              ├── assets/
              ├── lang/
              ├── views/
          ├── Routes/
              ├── api.php
              ├── web.php
          ├── Tests/
          ├── composer.json
          ├── module.json
          ├── package.json
          ├── webpack.mix.js

### Composer.json

Each module has its own composer.json file, this sets the name of the module, its description and author. You normally only need to change this file if you need to change the vendor name or have its own composer dependencies.

For instance say you wanted to install a package into this module:

```php
"require": { "dcblogdev/laravel-box": "^2.0" }
```

This would require the package for this module, but it won't be loaded for the main Laravel composer.json file. For that you would have to put the dependency in the Laravel composer.json file. The main reason this exists is for when extracting a module to a package.

### Module.json

This file details the name alias and description / options:

```php
{ "name": "Blog", "alias": "blog", "description": "", "keywords": [], "priority": 0, "providers": [ "Modules\\Blog\\Providers\\BlogServiceProvider" ], "aliases": {}, "files": [], "requires": [] }
```

Modules are loaded in the priority order, change the priority number to have modules booted / seeded in a custom order.

The files option can be used to include files:

```php
"files": [ "start.php" ]
```

## Custom namespaces

When you create a new module it also registers new custom namespace for `Lang`, `View` and `Config`. For example, if you create a new module named blog, it will also register new namespace/hint blog for that module. Then, you can use that namespace for calling `Lang`, `View` or `Config`. Following are some examples of its usage:

Calling Lang:

```php
Lang::get('blog::group.name'); @trans('blog::group.name');
```

Calling View:

```php
view('blog::index') view('blog::partials.sidebar')
```

Calling Config:

```php
Config::get('blog.name')
```

## Helpers

### Module path function

Get the path to the given module.

```php
$path = module_path('Blog');
```

Returns absolute path of project ending with /Modules/Blog

`module_path` can take a string as a second param, which tacks on to the end of the path:

```php
$path = module_path('Blog', 'Http/controllers/BlogController.php');
```

Returns absolute path of project ending with /Modules/Blog/Http/controllers/BlogController.php

## Artisan commands

Useful Tip:

You can use the following commands with the `--help` suffix to find its arguments and options.

**Note all the following commands use "Blog" as example module name, and example class/file names**

### Utility commands

Generate a new module.

生成一个新模块

```bash
php artisan module:make Blog
```

Generate multiple modules at once.

一次生成多个模块。

```bash
php artisan module:make Blog User Auth
```

Use a given module. This allows you to not specify the module name on other commands requiring the module name as an argument.

使用给定的模块。这允许您在需要将模块名称作为参数的其他命令上不指定模块名称。

```bash
php artisan module:use Blog
```

This unsets the specified module that was set with the `module:use` command.

```bash
php artisan module:unuse
```

List all available modules.

```bash
php artisan module:list
```

Migrate the given module, or without a module an argument, migrate all modules.

```bash
php artisan module:migrate Blog
```

Rollback the given module, or without an argument, rollback all modules.

```bash
php artisan module:migrate-rollback Blog
```

Refresh the migration for the given module, or without a specified module refresh all modules migrations.

刷新给定模块的迁移，或者在没有指定模块的情况下刷新所有模块迁移。

```bash
php artisan module:migrate-refresh Blog
```

Reset the migration for the given module, or without a specified module reset all modules migrations.

重置给定模块的迁移，或者在没有指定模块的情况下重置所有模块迁移。

```bash
php artisan module:migrate-reset Blog
```

Seed the given module, or without an argument, seed all modules

为给定模块设置种子，或者在不带参数的情况下为所有模块设置种子

```bash
php artisan module:seed Blog
```

Publish the migration files for the given module, or without an argument publish all modules migrations.

```bash
php artisan module:publish-migration Blog
```

Publish the given module configuration files, or without an argument publish all modules configuration files.

```bash
php artisan module:publish-config Blog
```

Publish the translation files for the given module, or without a specified module publish all modules migrations.

```bash
php artisan module:publish-translation Blog
```

Enable the given module.

```bash
php artisan module:enable Blog
```

Disable the given module.

```bash
php artisan module:disable Blog
```

Update the given module.

```bash
php artisan module:update Blog
```

### Generator commands

Generate the given console command for the specified module.

```bash
php artisan module:make-command CreatePostCommand Blog
```

Generate a migration for specified module.

```bash
php artisan module:make-migration create_posts_table Blog
```

Generate the given seed name for the specified module.

```bash
php artisan module:make-seed seed_fake_blog_posts Blog
```

Generate a controller for the specified module.

```bash
php artisan module:make-controller PostsController Blog
```

Optional options:

- `--plain`,`-p` : create a plain controller

- `--api` : create a resouce controller

Generate the given model for the specified module.

```bash
php artisan module:make-model Post Blog
```

Optional options:

- `--fillable=field1,field2`: set the fillable fields on the generated model

- `--migration`, `-m`: create the migration file for the given model

Generate the given service provider name for the specified module.

```bash
php artisan module:make-provider BlogServiceProvider Blog
```

Generate the given middleware name for the specified module.

```bash
php artisan module:make-middleware CanReadPostsMiddleware Blog
```

Generate the given mail class for the specified module.

```bash
php artisan module:make-mail SendWeeklyPostsEmail Blog
```

Generate the given notification class name for the specified module.

```bash
php artisan module:make-notification NotifyAdminOfNewComment Blog
```

Generate the given listener for the specified module. Optionally you can specify which event class it should listen to. It also accepts a `--queued` flag allowed queued event listeners.

```bash
php artisan module:make-listener NotifyUsersOfANewPost Blog php artisan module:make-listener NotifyUsersOfANewPost Blog --event=PostWasCreated php artisan module:make-listener NotifyUsersOfANewPost Blog --event=PostWasCreated --queued
```

Generate the given request for the specified module.

```bash
php artisan module:make-request CreatePostRequest Blog
```

Generate the given event for the specified module.

```bash
php artisan module:make-event BlogPostWasUpdated Blog
```

Generate the given job for the specified module.

```bash
php artisan module:make-job JobName Blog php artisan module:make-job JobName Blog --sync # A synchronous job class
```

Generate the given route service provider for the specified module.

```bash
php artisan module:route-provider Blog
```

Generate the given database factory for the specified module.

```bash
php artisan module:make-factory ModelName Blog
```

Generate the given policy class for the specified module.

The `Policies` is not generated by default when creating a new module. Change the value of `paths.generator.policies` in `modules.php` to your desired location.

```bash
php artisan module:make-policy PolicyName Blog
```

Generate the given validation rule class for the specified module.

The `Rules` folder is not generated by default when creating a new module. Change the value of `paths.generator.rules` in `modules.php` to your desired location.

```bash
php artisan module:make-rule ValidationRule Blog
```

Generate the given resource class for the specified module. It can have an optional `--collection` argument to generate a resource collection.

The `Transformers` folder is not generated by default when creating a new module. Change the value of `paths.generator.resource` in `modules.php` to your desired location.

```bash
php artisan module:make-resource PostResource Blog php artisan module:make-resource PostResource Blog --collection
```

Generate the given test class for the specified module.

```bash
php artisan module:make-test EloquentPostRepositoryTest Blog
```
