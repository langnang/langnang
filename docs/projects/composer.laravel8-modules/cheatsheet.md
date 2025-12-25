# Laravel8-Modules.CheatSheet

## Artisan

```txt
Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  clear-compiled                        Remove the compiled class file
  completion                            Dump the shell completion script
  db                                    Start a new database CLI session
  down                                  Put the application into maintenance / demo mode
  env                                   Display the current framework environment
  help                                  Display help for a command
  inspire                               Display an inspiring quote
  list                                  List commands
  migrate                               Run the database migrations
  optimize                              Cache the framework bootstrap files
  serve                                 Serve the application on the PHP development server
  test                                  Run the application tests
  tinker                                Interact with your application
  ui                                    Swap the front-end scaffolding for the application
  up                                    Bring the application out of maintenance mode
 auth
  auth:clear-resets                     Flush expired password reset tokens
 cache
  cache:clear                           Flush the application cache
  cache:forget                          Remove an item from the cache
  cache:table                           Create a migration for the cache database table
 config
  config:cache                          Create a cache file for faster configuration loading
  config:clear                          Remove the configuration cache file
 db
  db:seed                               Seed the database with records
  db:wipe                               Drop all tables, views, and types
 debugbar
  debugbar:clear                        Clear the Debugbar Storage
 event
  event:cache                           Discover and cache the application's events and listeners
  event:clear                           Clear all cached events and listeners
  event:generate                        Generate the missing events and listeners based on registration
  event:list                            List the application's events and listeners
 key
  key:generate                          Set the application key
 l5-swagger
  l5-swagger:generate                   Regenerate docs
 livewire
  livewire:configure-s3-upload-cleanup  Configure temporary file upload s3 directory to automatically cleanup files older than 24hrs
  livewire:copy                         Copy a Livewire component
  livewire:delete                       Delete a Livewire component
  livewire:discover                     Regenerate Livewire component auto-discovery manifest
  livewire:make                         Create a new Livewire component
  livewire:move                         Move a Livewire component
  livewire:publish                      Publish Livewire configuration
  livewire:stubs                        Publish Livewire stubs
 make
  make:cast                             Create a new custom Eloquent cast class
  make:channel                          Create a new channel class
  make:command                          Create a new Artisan command
  make:component                        Create a new view component class
  make:controller                       Create a new controller class
  make:event                            Create a new event class
  make:exception                        Create a new custom exception class
  make:factory                          Create a new model factory
  make:job                              Create a new job class
  make:listener                         Create a new event listener class
  make:livewire                         Create a new Livewire component
  make:mail                             Create a new email class
  make:middleware                       Create a new middleware class
  make:migration                        Create a new migration file
  make:model                            Create a new Eloquent model class
  make:notification                     Create a new notification class
  make:observer                         Create a new observer class
  make:policy                           Create a new policy class
  make:provider                         Create a new service provider class
  make:request                          Create a new form request class
  make:resource                         Create a new resource
  make:rule                             Create a new validation rule
  make:seeder                           Create a new seeder class
  make:test                             Create a new test class
 migrate
  migrate:fresh                         Drop all tables and re-run all migrations
  migrate:install                       Create the migration repository
  migrate:refresh                       Reset and re-run all migrations
  migrate:reset                         Rollback all database migrations
  migrate:rollback                      Rollback the last database migration
  migrate:status                        Show the status of each migration
 model
  model:prune                           Prune models that are no longer needed
 module
  module:delete                         Delete a module from the application
  module:disable                        Disable the specified module.
  module:dump                           Dump-autoload the specified module or for all module.
  module:enable                         Enable the specified module.
  module:install                        Install the specified module by given package name (vendor/name).
  module:list                           Show list of all modules.
  module:make                           Create a new module.
  module:make-command                   Generate new Artisan command for the specified module.
  module:make-component                 Create a new component-class for the specified module.
  module:make-component-view            Create a new component-view for the specified module.
  module:make-controller                Generate new restful controller for the specified module.
  module:make-event                     Create a new event class for the specified module
  module:make-factory                   Create a new model factory for the specified module.
  module:make-job                       Create a new job class for the specified module
  module:make-listener                  Create a new event listener class for the specified module
  module:make-mail                      Create a new email class for the specified module
  module:make-middleware                Create a new middleware class for the specified module.
  module:make-migration                 Create a new migration for the specified module.
  module:make-model                     Create a new model for the specified module.
  module:make-notification              Create a new notification class for the specified module.
  module:make-policy                    Create a new policy class for the specified module.
  module:make-provider                  Create a new service provider class for the specified module.
  module:make-request                   Create a new form request class for the specified module.
  module:make-resource                  Create a new resource class for the specified module.
  module:make-rule                      Create a new validation rule for the specified module.
  module:make-seed                      Generate new seeder for the specified module.
  module:make-test                      Create a new test class for the specified module.
  module:migrate                        Migrate the migrations from the specified module or from all modules.
  module:migrate-refresh                Rollback & re-migrate the modules migrations.
  module:migrate-reset                  Reset the modules migrations.
  module:migrate-rollback               Rollback the modules migrations.
  module:migrate-status                 Status for all module migrations
  module:publish                        Publish a module's assets to the application
  module:publish-config                 Publish a module's config files to the application
  module:publish-migration              Publish a module's migrations to the application
  module:publish-translation            Publish a module's translations to the application
  module:route-provider                 Create a new route service provider for the specified module.
  module:seed                           Run database seeder from the specified module or from all modules.
  module:setup                          Setting up modules folders for first use.
  module:unuse                          Forget the used module with module:use
  module:update                         Update dependencies for the specified module or for all modules.
  module:use                            Use the specified module.
  module:v6:migrate                     Migrate laravel-modules v5 modules statuses to v6.
 notifications
  notifications:table                   Create a migration for the notifications table
 optimize
  optimize:clear                        Remove the cached bootstrap files
 package
  package:discover                      Rebuild the cached package manifest
 queue
  queue:batches-table                   Create a migration for the batches database table
  queue:clear                           Delete all of the jobs from the specified queue
  queue:failed                          List all of the failed queue jobs
  queue:failed-table                    Create a migration for the failed queue jobs database table
  queue:flush                           Flush all of the failed queue jobs
  queue:forget                          Delete a failed queue job
  queue:listen                          Listen to a given queue
  queue:monitor                         Monitor the size of the specified queues
  queue:prune-batches                   Prune stale entries from the batches database
  queue:prune-failed                    Prune stale entries from the failed jobs table
  queue:restart                         Restart queue worker daemons after their current job
  queue:retry                           Retry a failed queue job
  queue:retry-batch                     Retry the failed jobs for a batch
  queue:table                           Create a migration for the queue jobs database table
  queue:work                            Start processing jobs on the queue as a daemon
 route
  route:cache                           Create a route cache file for faster route registration
  route:clear                           Remove the route cache file
  route:list                            List all registered routes
 sail
  sail:install                          Install Laravel Sail's default Docker Compose file
  sail:publish                          Publish the Laravel Sail Docker files
 sanctum
  sanctum:prune-expired                 Prune tokens expired for more than specified number of hours.
 schedule
  schedule:clear-cache                  Delete the cached mutex files created by scheduler
  schedule:list                         List the scheduled commands
  schedule:run                          Run the scheduled commands
  schedule:test                         Run a scheduled command
  schedule:work                         Start the schedule worker
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
  route:cache                           Create a route cache file for faster route registration
  route:clear                           Remove the route cache file
  route:list                            List all registered routes
 sail
  sail:install                          Install Laravel Sail's default Docker Compose file
  sail:publish                          Publish the Laravel Sail Docker files
 sanctum
  sanctum:prune-expired                 Prune tokens expired for more than specified number of hours.
 schedule
  schedule:clear-cache                  Delete the cached mutex files created by scheduler
  schedule:list                         List the scheduled commands
  schedule:run                          Run the scheduled commands
  schedule:test                         Run a scheduled command
  schedule:work                         Start the schedule worker
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
  route:list                            List all registered routes
 sail
  sail:install                          Install Laravel Sail's default Docker Compose file
  sail:publish                          Publish the Laravel Sail Docker files
 sanctum
  sanctum:prune-expired                 Prune tokens expired for more than specified number of hours.
 schedule
  schedule:clear-cache                  Delete the cached mutex files created by scheduler
  schedule:list                         List the scheduled commands
  schedule:run                          Run the scheduled commands
  schedule:test                         Run a scheduled command
  schedule:work                         Start the schedule worker
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
  sail:publish                          Publish the Laravel Sail Docker files
 sanctum
  sanctum:prune-expired                 Prune tokens expired for more than specified number of hours.
 schedule
  schedule:clear-cache                  Delete the cached mutex files created by scheduler
  schedule:list                         List the scheduled commands
  schedule:run                          Run the scheduled commands
  schedule:test                         Run a scheduled command
  schedule:work                         Start the schedule worker
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
  schedule:clear-cache                  Delete the cached mutex files created by scheduler
  schedule:list                         List the scheduled commands
  schedule:run                          Run the scheduled commands
  schedule:test                         Run a scheduled command
  schedule:work                         Start the schedule worker
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
  schedule:run                          Run the scheduled commands
  schedule:test                         Run a scheduled command
  schedule:work                         Start the schedule worker
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
 schema
  schema:dump                           Dump the given database schema
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
 server
  server:dump-sql                       Start the dump sql server to collect sql information.
 session
 session
  session:table                         Create a migration for the session database table
 storage
  storage:link                          Create the symbolic links configured for the application
 stub
  stub:publish                          Publish all stubs that are available for customization
 ui
  ui:auth                               Scaffold basic login and registration views and routes
  ui:controllers                        Scaffold the authentication controllers
 vendor
  vendor:publish                        Publish any publishable assets from vendor packages
 view
  view:cache                            Compile all of the application's Blade templates
  view:clear                            Clear all compiled view files
```
