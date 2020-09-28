<?php

namespace Nwidart\Modules\Activators;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Illuminate\Log\LogManager;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Nwidart\Modules\Module;

class DatabaseActivator implements ActivatorInterface
{
    /**
     * Laravel cache instance
     *
     * @var CacheManager
     */
    private $cache;

    /**
     * Laravel Database connection
     *
     * @var \Illuminate\Database\Connection
     */
    private $connection;

    /**
     * Laravel Database modules table
     *
     * @var string
     */
    private $table;

    /**
     * Laravel config instance
     *
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * @var string
     */
    private $cacheLifetime;

    /**
     * Array of modules activation statuses
     *
     * @var array
     */
    private $modulesStatuses;

    /**
     * Application Logger
     *
     * @var LogManager
     */
    private $logger;

    public function __construct (Container $app)
    {
        $this->cache = $app ['cache'];
        $this->connection = $app ['db.connection'];
        $this->config = $app ['config'];
        $this->table = $this->config ('table');
        $this->cacheKey = $this->config ('cache-key');
        $this->cacheLifetime = $this->config ('cache-lifetime');
        $this->logger = $app ['log'];
        $this->modulesStatuses = $this->getModulesStatuses ();
    }

    /**
     * Get the path of the file where statuses are stored
     *
     * @return string
     */
    public function getTableName (): string
    {
        return $this->table;
    }

    /**
     * @inheritDoc
     */
    public function reset (): void
    {
        // TODO: delete
        $this->modulesStatuses = [];
        $this->flushCache ();
    }

    /**
     * @inheritDoc
     */
    public function enable (Module $module): void
    {
        $this->setActiveByName ($module->getName (), true);
    }

    /**
     * @inheritDoc
     */
    public function disable (Module $module): void
    {
        $this->setActiveByName ($module->getName (), false);
    }

    /**
     * @inheritDoc
     */
    public function hasStatus (Module $module, bool $status): bool
    {
        if (!isset($this->modulesStatuses [$module->getName ()])) {
            return $status === false;
        }

        return $this->modulesStatuses [$module->getName ()] === $status;
    }

    /**
     * @inheritDoc
     */
    public function setActive (Module $module, bool $active): void
    {
        $this->setActiveByName ($module->getName (), $active);
    }

    /**
     * @inheritDoc
     */
    public function setActiveByName (string $name, bool $status): void
    {
        $this->modulesStatuses [$name] = $status;
        $this->writeJson ();
        $this->flushCache ();
    }

    /**
     * @inheritDoc
     */
    public function delete (Module $module): void
    {
        if (!isset($this->modulesStatuses [$module->getName ()])) {
            return;
        }
        unset ($this->modulesStatuses [$module->getName ()]);
        $this->writeJson ();
        $this->flushCache ();
    }

    /**
     * Writes the activation statuses in a file, as json
     */
    private function writeJson(): void
    {
        try {
            $this->connection->transaction (function () {
                foreach ($this->modulesStatuses as $name => $status) {
                    $this->connection->table ($this->table)->where ('name', $name)->update (['status' => $status ? 1 : 0]);
                }
            }, 3);
        } catch (\Throwable $e) {
            $this->logger->error ($e->getMessage ());
        }
    }

    /**
     * Reads the json file that contains the activation statuses.
     * @return array
     */
    private function readJson (): array
    {
        return $this->connection->query ()->get ()->reduce (function ($reduce, $item) {
            $reduce [$item->name] = ($item->status === 1);
            return $reduce;
        }, []);
    }

    /**
     * Get modules statuses, either from the cache or from
     * the json statuses file if the cache is disabled.
     * @return array
     */
    private function getModulesStatuses (): array
    {
        if (!$this->config->get ('modules.cache.enabled')) {
            return $this->readJson ();
        }

        return $this->cache->remember ($this->cacheKey, $this->cacheLifetime, function () {
            return $this->readJson ();
        });
    }

    /**
     * Reads a config parameter under the 'activators.file' key
     *
     * @param  string $key
     * @param  $default
     * @return mixed
     */
    private function config (string $key, $default = null)
    {
        $activator = $this->config->get ('modules.activator', 'database');
        return $this->config->get ("modules.activators.$activator." . $key, $default);
    }

    /**
     * Flushes the modules activation statuses cache
     */
    private function flushCache (): void
    {
        $this->cache->forget ($this->cacheKey);
    }
}
