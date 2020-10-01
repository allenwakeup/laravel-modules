<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class CreateModuleFiles extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'goodcatch:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate laravel-module model related files, such as model controller, repository, request and so on';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * all modules attrs
     *
     * @var array
     */
    protected $modules;

    protected $namespace;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct (Filesystem $files)
    {
        parent::__construct ();

        $this->files = $files;

        $this->modules = app ('modules') ? app ('modules')->all () : [];

        $this->namespace = config ('modules.namespace', 'App\Modules');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = trim ($this->argument ('module'));
        $module_conf = Arr::get ($this->modules, Str::ucfirst ($module), false);
        if ($module_conf)
        {
            $moduleUCFirst = Str::ucfirst ($module);
            $model = trim($this->argument ('model'));
            $model_name = \mb_convert_encoding (trim ($this->argument ('name')), 'utf-8', ['utf-8', 'gbk']);
            $modelPlural = Str::plural ($model);
            $modelUCFirst = Str::ucfirst ($model);
            $template = '';
            try {
                $template = $this->files->get (__DIR__ . '/stubs/template.stub');
            } catch (FileNotFoundException $e) {
                $this->error ($e->getMessage ());
            }

            if (! empty ($template))
            {
                $types = ['repository', 'controller', 'request', 'model', 'views', 'routes'];
                foreach ($types as $type) {
                    if (preg_match_all("%!start{$type}=(.+?\.php)(.+?)!end{$type}%s", $template, $match)) {
                        foreach ($match[1] as $k => $v) {
                            if ($type === 'views') {
                                $path = module_generated_path ($module, $type, 'admin');
                                if (!is_dir($path)) {
                                    mkdir($path);
                                }
                                $path = $path . '/' . $model;
                                if (!is_dir($path)) {
                                    mkdir($path);
                                }
                                $file = module_generated_path ($module, $type, 'admin/' . str_replace('{{-$model-}}', $model, $v));
                            } elseif ($type === 'routes') {
                                $path = module_generated_path ($module, $type, 'auto');
                                if (!is_dir($path)) {
                                    mkdir($path);
                                }
                                $file = module_generated_path ($module, $type, 'auto/' . str_replace('{{-$model-}}', $model, $v));
                            } else {
                                $path = module_generated_path ($module, $type, 'Admin');
                                if (!is_dir($path)) {
                                    mkdir($path);
                                }
                                $file = module_generated_path ($module, $type, str_replace('{{-$model_uc_first-}}', $modelUCFirst, $v));
                            }
                            if (empty ($file)) {
                                $this->warn("{$module} {$type} disabled");
                                continue;
                            }
                            if (file_exists($file)) {
                                $this->warn("{$file} has already existed, just ignore it");
                                continue;
                            }

                            $content = ltrim(str_replace('{{-$model_uc_first-}}', $modelUCFirst, $match[2][$k]));
                            $content = str_replace('{{-$module-namespace-}}', $this->namespace, $content);
                            $content = str_replace('{{-$module_uc_first-}}', $moduleUCFirst, $content);
                            $content = str_replace('{{-$module-}}', $module_conf->getLowerName (), $content);
                            $content = str_replace('{{-$model_name-}}', $model_name, $content);
                            $content = str_replace('{{-$model-}}', $model, $content);
                            $content = str_replace('{{-$model_plural-}}', $modelPlural, $content);
                            file_put_contents($file, $content);

                            $this->info("Created {$file}");
                        }
                    }
                }

                $this->info('All files created successfully');
            } else {
                $this->error("template file not found");
            }

        } else {
            $this->error("{$module} does not exist");
        }
        return;
    }

    /**
     * Get the console command arguments.
     * {module : laravel-module name} {model : model name} {name}
     * @return array
     */
    protected function getArguments () {
        return [
            ['model', InputArgument::REQUIRED, 'Model class name'],
            ['name', InputArgument::REQUIRED, 'Model displaying name'],
            ['module', InputArgument::REQUIRED, 'Module']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions () {
        return [
            // ['option_1', null, InputOption::VALUE_OPTIONAL, 'comment', ''],
        ];
    }
}
