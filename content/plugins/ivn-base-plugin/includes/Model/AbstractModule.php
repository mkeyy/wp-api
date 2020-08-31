<?php
namespace Ivn\Model;

/**
 * Class AbstractModule - abstract module class, provide options loading logic.
 * @package Ivn\Model
 */
abstract class AbstractModule implements ModuleInterface
{
    /**
     * Loaded options array.
     */
    private $options = array();

    /**
     * Method used to load module options.
     * @param array $config - options config
     */
    public function loadOptions(array $config)
    {
        foreach ($this->getEnabledOptionsConfig() as $optionName) {
            /**
             * @var $option OptionInterface
             */
            $class = substr(get_class($this), 0, -strlen(basename(get_class($this)))) . 'Options\\' . $optionName;
            if (class_exists($class)) {
                $option = new $class;
                $this->options[$option->getOptionId()] = $option;
                if (isset($config[$option->getOptionId()]) && intval($config[$option->getOptionId()]) === 1) {
                    $option->enableOption();
                    $option->perform();
                }
            } else {
                throw new \DomainException('Could not find enabled option class (' . $optionName . ') for module: ' . $this->getModuleName() . ' (id: ' . $this->getModuleId() . ')');
            }
        }
        if (sizeof($this->getEnabledOptionsConfig()) !== sizeof($this->options)) {
            throw new \LengthException('Failed loading module options. Possible duplication of option IDs for module: ' . $this->getModuleName() . ' (id: ' . $this->getModuleId() . ')');
        }
    }

    /**
     * Method used to obtain loaded option classes.
     * @return array - loaded option classes
     */
    public function getLoadedOptions()
    {
        return $this->options;
    }
}