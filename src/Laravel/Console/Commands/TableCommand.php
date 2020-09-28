<?php

namespace Goodcatch\Modules\Laravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class TableCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'goodcatch:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the laravel modules database table';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The application config
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new queue job table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct (Filesystem $files)
    {
        parent::__construct ();

        $this->files = $files;

        $this->config = $this->laravel ['config'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle ()
    {
        $activator = $this->config ['modules.activator'];

        $table = $this->config ["modules.activators.{$activator}.table"];

        $this->replaceMigration (
            $this->createBaseMigration ($table), $table, Str::studly ($table)
        );

        $this->info ('Migration created successfully!');
    }


    /**
     * Create a base migration file for the table.
     *
     * @param  string  $table
     * @return string
     */
    protected function createBaseMigration ($table = 'modules')
    {
        return $this->laravel ['migration.creator']->create (
            'create_' . $table . '_table', $this->laravel->databasePath ().'/migrations'
        );
    }


    /**
     * Replace the generated migration with the job table stub.
     *
     * @param string $path
     * @param string $table
     * @param string $tableClassName
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function replaceMigration ($path, $table, $tableClassName)
    {
        $stub = str_replace (
            ['{{table}}', '{{tableClassName}}'],
            [$table, $tableClassName],
            $this->files->get (__DIR__.'/stubs/modules.stub')
        );

        $this->files->put ($path, $stub);
    }
}
