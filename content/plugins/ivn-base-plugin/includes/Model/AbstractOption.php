<?php
namespace Ivn\Model;

/**
 * Class AbstractOption - abstract module option class, provide option enabling logic.
 * @package Ivn\Model
 */
abstract class AbstractOption implements OptionInterface
{
    private $enabled = false;

    /**
     * Method used to enable option.
     */
    public function enableOption()
    {
        $this->enabled = true;
    }

    /**
     * Method used to check if option is enabled.
     */
    public function isOptionEnabled()
    {
        return $this->enabled;
    }
}