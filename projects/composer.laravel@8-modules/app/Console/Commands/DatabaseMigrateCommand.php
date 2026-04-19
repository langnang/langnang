<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop tables, re-run migrations and seed the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $this->call('db:seed');
        return 0;
    }
}
