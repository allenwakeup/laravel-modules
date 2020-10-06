<?php

namespace Goodcatch\Modules\Process;

use Nwidart\Modules\Process\Installer as NwidartModulesInstaller;
use Symfony\Component\Process\Process;

class Installer extends NwidartModulesInstaller
{

    const GOODCATCH_CN = 'goodcatch.cn';

    /**
     * @var null|string
     */
    private $type;

    /**
     * The constructor.
     *
     * @param string $name
     * @param string $version
     * @param string $type
     * @param bool   $tree
     */
    public function __construct ($name, $version = null, $type = null, $tree = false)
    {
        parent::__construct ($name, $version, $type, $tree);
        $this->type = $type;
    }
    /**
     * Get process instance.
     *
     * @return \Symfony\Component\Process\Process
     */
    public function getProcess ()
    {
        if ($this->type === self::GOODCATCH_CN)
        {

            return $this->installViaHttp ();
        }
        parent::getProcess ();
    }


    /**
     * Get git repo url.
     *
     * @return string|null
     */
    public function getRepoUrl ()
    {
        if ($this->type === self::GOODCATCH_CN)
        {
            // Check of type 'scheme://host/path'
            if (filter_var ($this->type, FILTER_VALIDATE_URL)) {
                return $this->type;
            }

            return app ('config')->get (
                'modules.install.http',
                'https://laravel-modules.goodcatch.cn/dl?p=%s&n=%s&v=%s&s=%s'
            );
        }

        return parent::getRepoUrl ();

    }

    /**
     * Install the module via http.
     *
     * @return \Symfony\Component\Process\Process
     */
    public function installViaHttp ()
    {
        $token = '';
        return Process::fromShellCommandline (
            sprintf (
        "cd %s && curl -H \"Authorization: Bearer {$token}\" -O {$this->getRepoUrl ()}",
                storage_path ('app/modules'),
                app ('config')->has ('light') ? 'light' : '',
                $this->getModuleName (),
                $this->version,
                md5 (self::GOODCATCH_CN . app ('config')->get ('app.url'))
        ));
    }
}
