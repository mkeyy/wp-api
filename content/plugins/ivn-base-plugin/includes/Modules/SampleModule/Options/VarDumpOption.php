<?php
namespace Ivn\Modules\SampleModule\Options;

use Ivn\Model\AbstractOption;

/**
 * Class VarDumpOption - sample var_dump option.
 * @package Ivn\Modules\SampleModule\Options
 */
class VarDumpOption extends AbstractOption
{
    /**
     * Properties
     */
    const ID = 1;
    const DESCRIPTION = 'Sample var dump script description';

    /**
     * Method used to obtain unique option id.
     * @return int - option id
     */
    public function getOptionId()
    {
        return self::ID;
    }

    /**
     * Method used to obtain option description.
     * @return string - option description
     */
    public function getOptionDescription()
    {
        return self::DESCRIPTION;
    }

    /**
     * Main option method. Invoked only if option is enabled.
     * Its possible to use filters and actions inside.
     */
    public function perform()
    {
        add_action('init', array($this, 'optionActionHandler'));
    }

    /**
     * Performs option action.
     */
    public function optionActionHandler()
    {
        var_dump('VAR_DUMP CALLED FROM INIT ACTION');
    }
}