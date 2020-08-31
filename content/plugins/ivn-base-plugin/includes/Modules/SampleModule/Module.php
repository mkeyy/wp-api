<?php
namespace Ivn\Modules\SampleModule;

use Ivn\Model\AbstractModule;

/**
 * Class Module - sample module implementation.
 * @package Ivn\Modules\SampleModule
 */
class Module extends AbstractModule
{
    const ID = 'sample-module';
    const NAME = 'SampleModule';
    const DESCRIPTION = 'Netus urna, volutpat, quaerat quasi maecenas! Dolor facilisi cumque. Nostrud adipisci lorem autem maxime excepturi eu, ullamcorper praesentium ex tempore.';

    /**
     * Method used to obtain unique module identifier.
     * @return string - module identifier
     */
    public function getModuleId()
    {
        return self::ID;
    }

    /**
     * Method used to obtain module name.
     * @return string - module name.
     */
    public function getModuleName()
    {
        return self::NAME;
    }

    /**
     * Method used to obtain module description.
     * @return string - module description
     */
    public function getModuleDescription()
    {
        return self::DESCRIPTION;
    }

    /**
     * Method used to obtain array with enabled option names. Name is equal to option class basename.
     * @return array - enabled options array
     */
    public function getEnabledOptionsConfig()
    {
        return array(
            'VarDumpOption',
            'EchoOption'
        );
    }

    /**
     * Main module method invoked before options are loaded.
     */
    public function bootstrap()
    {
        // pre option perform() logic
    }
}