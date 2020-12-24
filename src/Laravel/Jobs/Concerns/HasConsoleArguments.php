<?php

namespace Goodcatch\Modules\Laravel\Jobs\Concerns;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;

trait HasConsoleArguments
{

    public function getJobPayloadByInputString (string $input)
    {
        $definition = new InputDefinition ();


        $definition->setArguments ($this->getArguments ());
        $definition->setOptions ($this->getOptions ());

        $input_interface = new StringInput ($input);

        $input_interface->bind ($definition);

        return array_merge ($input_interface->getArguments (), $input_interface->getOptions ());
    }

    private function getArguments ()
    {

        return \collect ($this->getConsoleArguments ())->reduce (function ($arr, $arg) {
            list($name, $mode, $description, $default) = array_merge ($arg, [null, null, null, null]);
            $arr [] = new InputArgument ($name, $mode, $description, $default);
            return $arr;
        }, []);

    }

    private function getOptions ()
    {
        return \collect ($this->getConsoleOptions ())->reduce (function ($arr, $arg) {
            list($name, $shortcut, $mode, $description, $default) = array_merge ($arg, [null, null, null, null, null]);
            $arr [] = new InputOption ($name, $shortcut, $mode, $description, $default);
            return $arr;
        }, []);
    }

    protected function getConsoleArguments ()
    {
        return [];
    }

    protected function getConsoleOptions ()
    {
        return [];
    }
}
