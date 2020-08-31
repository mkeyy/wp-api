<?php
namespace Ivn\Model;

/**
 * Interface OptionInterface - plugin module option interface.
 * @package Ivn\Model
 */
interface OptionInterface
{
    /**
     * Method used to obtain unique option id.
     * @return int - option id
     */
    public function getOptionId();

    /**
     * Method used to obtain option description.
     * @return string - option description
     */
    public function getOptionDescription();

    /**
     * Method used to enable option.
     */
    public function enableOption();

    /**
     * Method used to check if option is enabled.
     */
    public function isOptionEnabled();

    /**
     * Main option method. Invoked only if option is enabled.
     * Its possible to use filters and actions inside.
     */
    public function perform();
}