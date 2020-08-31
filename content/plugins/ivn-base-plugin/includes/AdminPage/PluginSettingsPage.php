<?php
namespace Ivn\AdminPage;

use Ivn\Base;
use Ivn\Model\ModuleInterface;
use Ivn\Model\OptionInterface;

/**
 * Class PluginSettingsPage - plugin settings page.
 * @package Ivn\AdminPage
 */
class PluginSettingsPage
{
    /**
     * Loaded modules.
     */
    private $modules;

    /**
     * PluginSettingsPage constructor.
     * @param array $modules - loaded modules array
     */
    public function __construct(array $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Method used to initialize admin page.
     */
    public function initialize()
    {
        /**
         * Menu action
         */
        add_action('admin_menu', array($this, 'registerMenu'));
    }

    /**
     * Method used to register custom admin menu.
     */
    public function registerMenu()
    {
        add_submenu_page(null, 'Import', 'Import', 'manage_options', 'ivn-base-plugin', array($this, 'renderModulesPage'));
    }

    /**
     * Method used to handle admin page form POST action.
     */
    public function postHandler()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
            if (!empty($_POST) && isset($_POST['mod'])) {
                $config = array();
                $config['mod'] = $_POST['mod'];
                /**
                 * Module name validation
                 */
                foreach (array_keys($config['mod']) as $moduleId) {
                    if (!in_array($moduleId, array_keys($this->modules))) {
                        throw new \DomainException('Invalid module id found in POST. Invalid module id: ' . $moduleId);
                    }
                }
                /**
                 * Option values validation
                 */
                array_map(function ($moduleOptionsState) {
                    foreach ($moduleOptionsState as $optionId => $optionState) {
                        if (!in_array($optionState, array('0', '1'))) {
                            throw new \DomainException('Invalid option value found in POST. Invalid option value: ' . $optionState);
                        }
                    }
                }, $config['mod']);
                update_option(Base::OPTION_NAME, $config);
                wp_redirect(add_query_arg(array('page' => 'ivn-base-plugin'), 'plugins.php'));
                exit;
            }
        }
    }

    /**
     * Method used to render admin menu.
     */
    public function renderModulesPage()
    {
        /**
         * Invoke post handler
         */
        $this->postHandler();
        ?>
        <div class="wrap">
            <h2>Modules</h2>

            <form method="POST">
                <?php
                /**
                 * @var $module ModuleInterface
                 * @var $option OptionInterface
                 */
                foreach ($this->modules as $module) : ?>
                    <h3><?= $module->getModuleName() ?></h3>
                    <p><?= $module->getModuleDescription() ?></p>
                    <ul>
                        <?php foreach ($module->getLoadedOptions() as $option):
                            $name = "mod[{$module->getModuleId()}][{$option->getOptionId()}]";
                            $enabled = $option->isOptionEnabled() ? ' checked="checked"' : '';
                            ?>
                            <li>
                                <label>
                                    <input name="<?= $name ?>" type="hidden" value="0"/>
                                    <input name="<?= $name ?>" type="checkbox" value="1"<?= $enabled ?>/> <?= $option->getOptionDescription() ?>
                                </label>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <hr/>
                <?php endforeach ?>
                <div class="submit">
                    <input type="submit" name="store" id="store" class="button button-primary button-large" value="Store">
                </div>
            </form>
        </div>
    <?php
    }
}