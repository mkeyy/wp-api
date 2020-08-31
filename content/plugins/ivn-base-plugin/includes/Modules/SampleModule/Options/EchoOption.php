<?php
namespace Ivn\Modules\SampleModule\Options;

use Ivn\Model\AbstractOption;

/**
 * Class EchoOption - sample echo option.
 * @package Ivn\Modules\SampleModule\Options
 */
class EchoOption extends AbstractOption
{
    /**
     * Properties
     */
    const ID = 2;
    const DESCRIPTION = 'Sample echo script description';

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
        add_action('admin_footer', array($this, 'optionActionHandler'));
    }

    /**
     * Performs option action.
     */
    public function optionActionHandler()
    {
        echo 'FOOTER ECHO CALLED FROM ADMIN_FOOTER ACTION';
    }
} 