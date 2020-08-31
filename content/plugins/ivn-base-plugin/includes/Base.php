<?php
namespace Ivn;

use Ivn\AdminPage\PluginSettingsPage;
use Ivn\Model\ModuleInterface;

/**
 * Class Base - main plugin class.
 * @package Ivn
 */
class Base
{
    /**
     * Constraints
     */
    const BASE_FILE = 'ivn-base-plugin/index.php';
    const OPTION_NAME = 'ivn-base-plugin';

    /**
     * Plugin directory
     */
    protected $PLUGIN_DIR;

    /**
     * Plugin instance
     */
    protected static $instance = null;

    /**
     * Plugin modules
     */
    private $modules = array();

    /**
     * Plugin config
     */
    private $config;

    /**
     * Base constructor, initialization.
     */
    public function __construct()
    {
        /**
         * Plugin directory property.
         */
        $this->PLUGIN_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR;

        /**
         * Auto-loader
         */
        spl_autoload_register(array($this, 'autoloader'));

        /**
         * Settings link appender
         */
        add_filter('plugin_action_links_' . self::BASE_FILE, array($this, 'appendSettingsLink'));

        /**
         * Config loader
         */
        $this->loadConfig();

        /**
         * Load modules
         */
        $this->loadModules();

        /**
         * Instant initialization
         */
        $this->initialize();
    }

    /**
     * Method used to render settings link in plugin section.
     * @param $links - current links array
     * @return array - new links array
     */
    public function appendSettingsLink($links)
    {
        $links[] = '<a href="plugins.php?page=ivn-base-plugin">Settings</a>';
        return $links;
    }

    /**
     * Method used to load all plugin modules.
     */
    private function loadModules()
    {
        $iteratorCounter = 0;
        foreach (new \DirectoryIterator("{$this->PLUGIN_DIR}Modules") as $file) {
            if ($file->isDot()) {
                continue;
            }
            if ($file->isDir()) {
                $moduleClass = "Ivn\\Modules\\{$file->getFilename()}\\Module";
                /**
                 * @var $module ModuleInterface
                 */
                $module = new $moduleClass;
                if (preg_match('/^[\w-]{1,20}$/', $module->getModuleId())) {
                    $this->modules[$module->getModuleId()] = $module;
                    $module->bootstrap();
                    $module->loadOptions(isset($this->config['mod'][$module->getModuleId()]) ? $this->config['mod'][$module->getModuleId()] : array());
                    $iteratorCounter++;
                } else {
                    throw new \DomainException('Invalid module id for module: ' . $module->getModuleName() . '(invalid id: ' . $module->getModuleId() . ')');
                }
            }
        }
        if (sizeof($this->modules) !== $iteratorCounter) {
            throw new \LengthException('Failed loading modules. Possible duplication of module IDs.');
        }
    }

    /**
     * Method used to load plugin config.
     */
    private function loadConfig()
    {
        $this->config = get_option(self::OPTION_NAME, array());
    }

    /**
     * Plugin initialization
     */
    private function initialize()
    {
        $page = new PluginSettingsPage($this->modules);
        $page->initialize();
    }

    /**
     * Return an instance of this class.
     * @return Base
     */
    public function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Custom auto-loader implementation.
     * @param $className - name of class
     * @return bool - true if class is found, otherwise false
     */
    public function autoloader($className)
    {
        if (false !== stripos($className, __NAMESPACE__)) {
            $classPath = preg_replace('/^' . __NAMESPACE__ . '\\\/', $this->PLUGIN_DIR, preg_replace('/\\\/', DIRECTORY_SEPARATOR, $className)) . '.php';
            if (file_exists($classPath)) {
                require $classPath;
                return true;
            }
        }
        return false;
    }
}
