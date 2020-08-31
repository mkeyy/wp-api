<?php
namespace Ivn\Model;

/**
 * Interface ModuleInterface - plugin module interface.
 * @package Ivn\Model
 */
interface ModuleInterface
{
    /**
     * Method used to obtain unique module identifier.
     * @return string - module identifier
     */
    public function getModuleId();

    /**
     * Method used to obtain module name.
     * @return string - module name.
     */
    public function getModuleName();

    /**
     * Method used to obtain module description.
     * @return string - module description
     */
    public function getModuleDescription();

    /**
     * Method used to load module options.
     * @param array $config - options config
     */
    public function loadOptions(array $config);

    /**
     * Method used to obtain loaded option classes.
     * @return array - loaded option classes
     */
    public function getLoadedOptions();

    /**
     * Method used to obtain array with enabled option names. Name is equal to option class basename.
     * @return array - enabled options array
     */
    public function getEnabledOptionsConfig();

    /**
     * Main module method invoked before options are loaded.
     */
    public function bootstrap();
}