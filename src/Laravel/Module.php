<?php

namespace Goodcatch\Modules\Laravel;

use Illuminate\Container\Container;
use Illuminate\Translation\Translator;
use Nwidart\Modules\Laravel\Module as BaseModule;

class Module extends BaseModule
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * The constructor.
     * @param Container $app
     * @param $name
     * @param $path
     */
    public function __construct(Container $app, string $name, $path)
    {
        parent::__construct($app, $name, $path);
        $this->translator = $app['translator'];

    }

    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        if (config('modules.register.translations', true) === true) {
            $this->registerTranslation();
        }

        parent::boot();
    }

    /**
     * {@inheritdoc}
     */
    protected function registerTranslation(): void
    {
        $lowerName = $this->getLowerName();

        $langPath = $this->getExtraPath('resources/lang');

        if (is_dir($langPath)) {
            $this->translator->addNamespace($lowerName, $langPath);
        }
    }
}
