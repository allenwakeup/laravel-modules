<?php

namespace Goodcatch\Modules\Commands;

use ErrorException;
use Nwidart\Modules\Commands\SeedCommand as Command;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Str;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Module;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SeedCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'goodcatch:seed';

    /**
     * Get master database seeder name for the specified module.
     *
     * @param string $name
     *
     * @return string
     */
    public function getSeederName($name)
    {
        $name = Str::studly($name);

        $namespace = $this->laravel['modules']->config('namespace');
        $config = GenerateConfigReader::read('seeder');

        if(empty($config->getNamespace())){
            $seederPath = str_replace('/', '\\', $config->getPath());
        }else{
            $seederPath = $config->getNamespace();
        }

        return $namespace . '\\' . $name . '\\' . $seederPath . '\\' . $name . 'DatabaseSeeder';
    }

    /**
     * Get master database seeder name for the specified module under a different namespace than Modules.
     *
     * @param string $name
     *
     * @return array $foundModules array containing namespace paths
     */
    public function getSeederNames($name)
    {
        $name = Str::studly($name);

        $seederPath = GenerateConfigReader::read('seeder');

        if(empty($seederPath->getNamespace())){
            $seederPath = str_replace('/', '\\', $seederPath->getPath());
        }else{
            $seederPath = $seederPath->getNamespace();
        }

        $foundModules = [];
        foreach ($this->laravel['modules']->config('scan.paths') as $path) {
            $namespace = array_slice(explode('/', $path), -1)[0];
            $foundModules[] = $namespace . '\\' . $name . '\\' . $seederPath . '\\' . $name . 'DatabaseSeeder';
        }

        return $foundModules;
    }

}
